<?php
session_start();
require_once __DIR__ . '/../src/config/database.php';
$db = new Database();
$pdo = $db->pdo;

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$status = $_POST['status'] ?? '';

// Validate status
if ($status !== 'Well' && $status !== 'Not Well') {
    header("Location: dashboard.php");
    exit;
}

// Check if already submitted today
$stmt = $pdo->prepare("SELECT id FROM wellness_status WHERE user_id = ? AND DATE(submitted_at) = CURDATE()");
$stmt->execute([$user_id]);
if ($stmt->fetch()) {
    $message = "You have already submitted your status for today. See you tomorrow! 😉";
    session_destroy();
    show_popup_and_redirect($message, "index.php");
    exit;
}

// Insert status
$stmt = $pdo->prepare("INSERT INTO wellness_status (user_id, status) VALUES (?, ?)");
$stmt->execute([$user_id, $status]);

// Set message based on status
if ($status === 'Well') {
    $message = "Thanks, Have a great day! 😊";
} else {
    $message = "You are requested to communicate with Clinic Team.  😷,  Call: +880 1902-506 110";
    
    
}

// Destroy session and show popup
session_destroy();
show_popup_and_redirect($message, "index.php");
exit;

// Function to show popup and redirect
function show_popup_and_redirect($msg, $redirect) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Status Submitted</title>
        <script>
            alert("<?= addslashes($msg) ?>");
            window.location.href = "<?= $redirect ?>";
        </script>
    </head>
    <body></body>
    </html>
    <?php
}
?>