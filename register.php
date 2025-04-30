<?php
$host = 'localhost';
$db = 'u68672';
$user = 'u68672';
$pass = '5722731';

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $biography = $_POST['biography'] ?? 'Нет биографии';
    $programming_languages = implode(',', $_POST['programming_languages']);
    $consent = isset($_POST['consent']) ? 1 : 0;
    $username = strtolower(substr($name, 0, 3) . rand(100, 999));
    $password = bin2hex(random_bytes(4));
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, phone, email, gender, birthdate, biography, programming_languages, password_hash, username) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    try {
        $stmt->execute([$name, $phone, $email, $gender, $birthdate, $biography, $programming_languages, $password_hash, $username]);
        echo "Регистрация прошла успешно!<br>";
        echo "Ваш логин: $username<br>";
        echo "Ваш пароль: $password<br>";
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
?>
