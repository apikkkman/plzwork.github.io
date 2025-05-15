<?php
$host = 'localhost'; 
$db = 'u68672';
$user = 'u68672'; 
$pass = '5722731'; 

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$valid_users = ['admin' => 'password123'];

if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
    !array_key_exists($_SERVER['PHP_AUTH_USER'], $valid_users) ||
    $valid_users[$_SERVER['PHP_AUTH_USER']] !== $_SERVER['PHP_AUTH_PW']) {
    header('WWW-Authenticate: Basic realm="Admin Area"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Authentication required.';
    exit;
}

$messages = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete']) && isset($_POST['user_id'])) {
        $id = intval($_POST['user_id']);
        $stmt = $pdo->prepare("DELETE FROM applications WHERE id = ?");
        if ($stmt->execute([$id])) {
            $messages[] = "Пользователь #$id удален успешно.";
        } else {
            $messages[] = "Ошибка при удалении пользователя.";
        }
    } elseif (isset($_POST['edit']) && isset($_POST['user_id'])) {
        $id = intval($_POST['user_id']);
        $name = trim($_POST['name']);
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $birthday = $_POST['birthday'];
        $gender = $_POST['gender'];
        $bio = trim($_POST['bio']);
        $languages = json_encode($_POST['languages'] ?? []);
        $agreement = isset($_POST['agreement']) ? 1 : 0;

        $stmt = $pdo->prepare("UPDATE applications SET name = ?, phone = ?, email = ?, birthday = ?, gender = ?, bio = ?, languages = ?, agreement = ? WHERE id = ?");
        if ($stmt->execute([$name, $phone, $email, $birthday, $gender, $bio, $languages, $agreement, $id])) {
            $messages[] = "Пользователь #$id обновлен успешно.";
        } else {
            $messages[] = "Ошибка при обновлении пользователя.";
        }
    }
}

$stmt = $pdo->query("SELECT * FROM applications");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$langs = ['C', 'C++', 'JavaScript', 'Python', 'Java', 'Haskell', 'Clojure', 'Prolog'];
$lang_stats = array_fill_keys($langs, 0);
foreach ($users as $user) {
    $user_languages = json_decode($user['languages'], true);
    foreach ($user_languages as $lang) {
        if (in_array($lang, $langs)) {
            $lang_stats[$lang]++;
        }
    }
}

include 'bv.html';
?>
