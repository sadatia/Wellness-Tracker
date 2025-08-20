<?php
session_start();
require_once __DIR__ . '/../src/config/database.php';
$db = new Database();
$pdo = $db->pdo;

// Fetch all users (except admin)

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    $stmt = $pdo->prepare("SELECT id, username, position FROM users WHERE is_admin = 0 AND (username LIKE ? OR position LIKE ?) ORDER BY id ASC");
    $like = "%$search%";
    $stmt->execute([$like, $like]);
} else {
    $stmt = $pdo->prepare("SELECT id, username, position FROM users WHERE is_admin = 0 ORDER BY id ASC");
    $stmt->execute();
}
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wellness Tracker - User Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS for responsiveness and color -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); min-height: 100vh; }
        .user-list { background: #fff; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 24px rgba(0,0,0,0.1);}
        .user-row { cursor: pointer; transition: background 0.2s; }
        .user-row:hover { background: #fda08522; }
        .modal-content { border-radius: 1rem; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="container my-5">
        <div class="user-list mx-auto" style="max-width: 500px;">
            
            
<div class="d-flex flex-column align-items-center mb-4">
    <img src="/assets/img/logo.png" alt="Logo" style="height:48px;width:auto;">
    <h4 class="text-secondary">Penta-Ocean/TOA JV</h4>
     <h4 class="text-secondary">Daily Wellness Tracker</h4>
    
   
   
   
   
</div>

            
            
            <form method="get" class="mb-3">
    <input type="text" name="search" class="form-control" placeholder="Search by username or position" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
</form>
            
            
            
            <ul class="list-group">
                <?php foreach ($users as $i => $user): ?>
                <li class="list-group-item user-row d-flex justify-content-between align-items-center"
                    data-user-id="<?= $user['id'] ?>" data-username="<?= htmlspecialchars($user['username']) ?>">
                    <span>
                        <strong> <?= $i+1 ?></strong> - <?= htmlspecialchars($user['username']) ?> - <em><?= htmlspecialchars($user['position']) ?></em>
                    </span>
                    <span class="badge bg-info text-dark">Login</span>
                </li>
                <?php endforeach; ?>
            </ul>
            <div class="text-center mt-4">
                <a href="admin/index.php" class="btn btn-dark btn-sm">Super Admin Login</a>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1">
      <div class="modal-dialog">
        <form class="modal-content" method="post" action="login.php">
          <div class="modal-header">
            <h5 class="modal-title">User Login</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="user_id" id="modalUserId">
            <div class="mb-3">
                <label for="modalUsername" class="form-label">Username</label>
                <input type="text" class="form-control" id="modalUsername" readonly>
            </div>
            <div class="mb-3">
                <label for="modalPin" class="form-label">4-digit PIN</label>
                <input type="password" class="form-control" name="pin" id="modalPin" maxlength="4" pattern="\d{4}" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </div>
        </form>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Show login modal on user click
    document.querySelectorAll('.user-row').forEach(row => {
        row.addEventListener('click', function() {
            document.getElementById('modalUserId').value = this.dataset.userId;
            document.getElementById('modalUsername').value = this.dataset.username;
            new bootstrap.Modal(document.getElementById('loginModal')).show();
        });
    });
    </script>
</body>
</html>