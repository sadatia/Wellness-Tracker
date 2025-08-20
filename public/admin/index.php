<?php
session_start();
require_once __DIR__ . '/../../src/config/database.php';
$db = new Database();
$pdo = $db->pdo;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $pin = $_POST['pin'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND pin = ? AND is_admin = 1");
    $stmt->execute([$username, $pin]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($admin) {
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: manage_users.php");
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Super Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); min-height: 100vh; }
        .admin-login { background: #fff; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 24px rgba(0,0,0,0.1);}
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="container my-5">
        <div class="admin-login mx-auto" style="max-width: 400px;">
            <h3 class="mb-4 text-center text-danger fw-bold">Super Admin Login</h3>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">PIN</label>
                    <input type="password" name="pin" class="form-control" maxlength="4" required>
                </div>
                <button type="submit" class="btn btn-danger w-100">Login</button>
            </form>
        </div>
    </div>
</body>
</html>