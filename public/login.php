<?php
session_start();
require_once __DIR__ . '/../src/config/database.php';
$db = new Database();
$pdo = $db->pdo;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $pin = $_POST['pin'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? AND pin = ? AND is_admin = 0");
    $stmt->execute([$user_id, $pin]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $_SESSION['login_error'] = "Invalid PIN!";
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>