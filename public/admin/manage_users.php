<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}
require_once __DIR__ . '/../../src/config/database.php';
$db = new Database();
$pdo = $db->pdo;

// Handle user creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_user'])) {
    $username = $_POST['username'];
    $position = $_POST['position'];
    $stmt = $pdo->prepare("INSERT INTO users (username, position, pin, is_admin) VALUES (?, ?, '1234', 0)");
    $stmt->execute([$username, $position]);
    $success = "User created with default PIN 1234.";
}

// Handle user update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $user_id = intval($_POST['user_id']);
    $position = $_POST['position'];
    $pin = $_POST['pin'];
    $stmt = $pdo->prepare("UPDATE users SET position = ?, pin = ? WHERE id = ?");
    $stmt->execute([$position, $pin, $user_id]);
    $success = "User updated.";
}

// Fetch all users (except admin)
$stmt = $pdo->prepare("SELECT * FROM users WHERE is_admin = 0 ORDER BY id ASC");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users - Super Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%); min-height: 100vh; }
        .admin-panel { background: #fff; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 24px rgba(0,0,0,0.1);}
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="admin-panel mx-auto" style="max-width: 800px;">
            
            
            <div class="d-flex flex-column align-items-center mb-4">
    <img src="/assets/img/logo.png" alt="Logo" style="height:48px;width:auto;">
 <h3 class="mb-4 text-center text-warning fw-bold">User Management</h3>
</div>
            
            
            
            
            
            
           
            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <form class="row g-3 mb-4" method="post">
                <input type="hidden" name="create_user" value="1">
                <div class="col-md-5">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="col-md-5">
                    <input type="text" name="position" class="form-control" placeholder="Position" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Add</button>
                </div>
            </form>
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>SN#</th>
                        <th>Username</th>
                        <th>Position</th>
                        <th>PIN</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $i => $user): ?>
                    <tr>
                        <form method="post">
                            <input type="hidden" name="update_user" value="1">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <td><?= $i+1 ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td>
                                <input type="text" name="position" value="<?= htmlspecialchars($user['position']) ?>" class="form-control" required>
                            </td>
                            <td>
                                <input type="text" name="pin" value="<?= htmlspecialchars($user['pin']) ?>" class="form-control" maxlength="4" required>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-center mt-4">
                <a href="report.php" class="btn btn-info">View Daily Report</a>
                <a href="logout.php" class="btn btn-secondary ms-2">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>