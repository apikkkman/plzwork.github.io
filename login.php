<?php
$host = 'localhost';
$db = 'my_database';
$user = 'root';
$pass = '';

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function jwt_encode($payload, $secret) {
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $header = base64_encode($header);
    $payload = base64_encode(json_encode($payload));
    $signature = hash_hmac('sha256', "$header.$payload", $secret, true);
    $signature = base64_encode($signature);
    return "$header.$payload.$signature";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password_hash'])) {
        $secret = 'your_secret_key';
        $payload = [
            'id' => $user['id'],
            'username' => $user['username'],
            'exp' => time() + 3600
        ];
        $jwt = jwt_encode($payload, $secret);
        echo "Аутентификация прошла успешно!<br>";
        echo "Ваш JWT: $jwt<br>";
    } else {
        echo "Неверный логин или пароль.";
    }
}
?>
