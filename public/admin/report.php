<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}
require_once __DIR__ . '/../../src/config/database.php';
$db = new Database();
$pdo = $db->pdo;

// Get selected date or default to today
$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Fetch statuses for the selected date
$stmt = $pdo->prepare("
    SELECT u.username, u.position, w.status, w.submitted_at
    FROM users u
    LEFT JOIN wellness_status w ON u.id = w.user_id AND w.date = ?
    WHERE u.is_admin = 0
    ORDER BY u.id ASC
");
$stmt->execute([$selected_date]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// PDF download
if (isset($_GET['download']) && $_GET['download'] === 'pdf') {
    require_once __DIR__ . '/../../../vendor/autoload.php';
    $html = '<h2>Daily Wellness Report</h2><table border="1" cellpadding="5"><tr><th>#</th><th>Username</th><th>Position</th><th>Status</th><th>Time</th></tr>';
    foreach ($rows as $i => $row) {
        $html .= '<tr><td>'.($i+1).'</td><td>'.htmlspecialchars($row['username']).'</td><td>'.htmlspecialchars($row['position']).'</td><td>'.htmlspecialchars($row['status'] ?? '-').'</td><td>'.htmlspecialchars($row['submitted_at'] ?? '-').'</td></tr>';
    }
    $html .= '</table>';
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    $mpdf->Output('daily_report.pdf', 'D');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daily Report - Super Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%); min-height: 100vh; }
        .report-panel { background: #fff; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 24px rgba(0,0,0,0.1);}
    
    
    
    
    @media print {
    .btn, form, .text-end { display: none !important; }
    .report-panel { box-shadow: none !important; }
  
  
  
  page {
        margin: 0;
    }
    body {
        margin: 0px 50px !important;
        padding: 0 !important;
        background: #fff !important;
        font-size: 10px !important;
        color: #333 !important;
    }
    .container, .report-panel {
        margin: 0px !important;
        padding: 10px !important;
        box-shadow: none !important;
    }
    /* Prevent wrapping in Position and Submitted At columns */
    td.position-col, th.position-col,
    td.submitted-col, th.submitted-col {
        white-space: nowrap !important;
    }
    /* Optionally, set a min-width for these columns */
    td.position-col, th.position-col { min-width: 100px; }
    td.submitted-col, th.submitted-col { min-width: 100px; }
    
    }
    
    
    
    
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="report-panel mx-auto" style="max-width: 900px;">
        <div class="d-flex flex-column align-items-center mb-4">
    <img src="/assets/img/logo.png" alt="Logo" style="height:48px;width:auto;">
    <h3 class="text-primary fw-bold mt-2">Penta-Ocean/TOA JV</h3>
    <h4 class="text-secondary">Daily Wellness Report</h4>
    <p class="text-muted mb-0">Date: <?= htmlspecialchars($selected_date) ?></p>
</div>

         <div style="float: left;">
        
           <form class="row g-3 mb-4" method="get">
                <div class="col-auto">
                    <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($selected_date) ?>" required>
                </div>
                 <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Show Report</button>
                 </div>
            </form>
        </div>

<div class="text-end mb-3">
    <button class="btn btn-secondary" onclick="window.print()">Print</button>
</div>

<table class="table table-bordered table-striped align-middle"> 




<thead>
    <tr>
        <th>SN#</th>
        <th>Username</th>
        <th class="position-col">Position</th>
        <th>Status</th>
        <th class="submitted-col">Submitted At</th>
    </tr>
</thead>
<tbody>
<?php foreach ($rows as $i => $row): ?>
    <tr>
        <td><?= $i+1 ?></td>
        <td><?= htmlspecialchars($row['username']) ?></td>
        <td class="position-col"><?= htmlspecialchars($row['position']) ?></td>
        <td><?= htmlspecialchars($row['status'] ?? '-') ?></td>
        <td class="submitted-col"><?= htmlspecialchars($row['submitted_at'] ?? '-') ?></td>
    </tr>
<?php endforeach; ?>
</tbody>
               
                
                
                
            </table>
            <div class="text-center mt-4">
                         <a href="manage_users.php" class="btn btn-secondary ms-2">Back</a>
            </div>
        </div>
    </div>
</body>
</html>