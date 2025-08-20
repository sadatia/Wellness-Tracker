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
$username = $_SESSION['username'];

// Check if user already submitted today
$stmt = $pdo->prepare("SELECT * FROM wellness_status WHERE user_id = ? AND DATE(submitted_at) = CURDATE()");
$stmt->execute([$user_id]);
$status_today = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Wellness Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%); min-height: 100vh; }
        .dashboard { background: #fff; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 24px rgba(0,0,0,0.1);}
        .status-btn { font-size: 1.5rem; width: 45%; }
        .selected { border: 3px solid #185a9d !important; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="container my-5">
        <div class="dashboard mx-auto" style="max-width: 500px;">
            <h3 class="mb-4 text-center text-success fw-bold">Welcome, How do you feel today: Mr. <?= htmlspecialchars($username) ?></h3>
            <?php if ($status_today): ?>
                <div class="alert alert-info text-center">
                    You have already submitted your status for today.<br>
                    See you tomorrow! 😉
                </div>
                <div class="text-center mt-4">
                    <a href="logout.php" class="btn btn-secondary">Logout</a>
                </div>
            <?php else: ?>
                <form id="statusForm" method="post" action="submit_status.php">
                    <input type="hidden" name="status" id="statusInput">
                    <div class="d-flex justify-content-between mb-4">
                        <button type="button" class="btn btn-outline-success status-btn" id="wellBtn">Well</button>
                        <button type="button" class="btn btn-outline-danger status-btn" id="notWellBtn">Not Well</button>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" id="saveBtn" style="display:none;">Save & Exit</button>
                </form>
                <div class="text-center mt-4">
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#changePinModal">Change PIN</button>
                    <a href="logout.php" class="btn btn-secondary ms-2">Logout</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Change PIN Modal -->
    <div class="modal fade" id="changePinModal" tabindex="-1">
      <div class="modal-dialog">
        <form class="modal-content" method="post" action="change_pin.php">
          <div class="modal-header">
            <h5 class="modal-title">Change PIN</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
                <label for="oldPin" class="form-label">Old PIN</label>
                <input type="password" class="form-control" name="old_pin" id="oldPin" maxlength="4" pattern="\d{4}" required>
            </div>
            <div class="mb-3">
                <label for="newPin" class="form-label">New PIN</label>
                <input type="password" class="form-control" name="new_pin" id="newPin" maxlength="4" pattern="\d{4}" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success w-100">Change PIN</button>
          </div>
        </form>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Status button logic
    let selected = null;
    document.getElementById('wellBtn').onclick = function() {
        selected = 'Well';
        this.classList.add('selected');
        document.getElementById('notWellBtn').classList.remove('selected');
        document.getElementById('statusInput').value = 'Well';
        document.getElementById('saveBtn').style.display = 'block';
    };
    document.getElementById('notWellBtn').onclick = function() {
        selected = 'Not Well';
        this.classList.add('selected');
        document.getElementById('wellBtn').classList.remove('selected');
        document.getElementById('statusInput').value = 'Not Well';
        document.getElementById('saveBtn').style.display = 'block';
    };
    document.getElementById('statusForm').onsubmit = function() {
        if (!selected) {
            alert('Please select your status.');
            return false;
        }
    };
    </script>
</body>
</html>