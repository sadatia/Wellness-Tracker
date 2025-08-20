<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
require_once __DIR__ . '/../src/config/database.php';
$db = new Database();
$pdo = $db->pdo;

$user_id = $_SESSION['user_id'];
$old_pin = $_POST['old_pin'] ?? '';
$new_pin = $_POST['new_pin'] ?? '';

if (!preg_match('/^\d{4}$/', $new_pin)) {
    $_SESSION['pin_error'] = "New PIN must be 4 digits.";
    header("Location: dashboard.php");
    exit;
}

// Verify old PIN
$stmt = $pdo->prepare("SELECT pin FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || $user['pin'] !== $old_pin) {
    $_SESSION['pin_error'] = "Old PIN is incorrect.";
    header("Location: dashboard.php");
    exit;
}

// Update PIN
$stmt = $pdo->prepare("UPDATE users SET pin = ? WHERE id = ?");
$stmt->execute([$new_pin, $user_id]);

$_SESSION['pin_success'] = "PIN changed successfully.";
header("Location: dashboard.php");
exit;
?>