<?php

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        
$host = 'localhost'; 
$db = 'u68672';
$user = 'u68672'; 
$pass = '5722731'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("CSRF token validation failed.");
    }
    if (isset($_POST['edit'])) {
        $user_id = $_POST['user_id'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $birthday = $_POST['birthday'];
        $gender = $_POST['gender'];
        $bio = $_POST['bio'];
        $languages = json_encode($_POST['languages'] ?? []);
        $agreement = isset($_POST['agreement']) ? 1 : 0;
        $stmt = $pdo->prepare("UPDATE applications SET name = ?, phone = ?, email = ?, birthday = ?, gender = ?, bio = ?, languages = ?, agreement = ? WHERE id = ?");
        $stmt->execute([$name, $phone, $email, $birthday, $gender, $bio, $languages, $agreement, $user_id]);
        $_SESSION['messages'][] = "Заявка обновлена.";
    }
    if (isset($_POST['delete'])) {
        $user_id = $_POST['user_id'];
        $stmt = $pdo->prepare("DELETE FROM applications WHERE id = ?");
        $stmt->execute([$user_id]);
        $_SESSION['messages'][] = "Заявка удалена.";
    }

include 'bv.html';
?>
