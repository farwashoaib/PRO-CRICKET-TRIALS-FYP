<?php
// Start the session at the very top of the script
session_start();

// Check if the user is a logged-in coach or admin
$is_coach = false;
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && ($_SESSION['userType'] === 'coach' || $_SESSION['userType'] === 'admin')) {
    $is_coach = true;
}

// Check if a user is not logged in. If not, redirect to the login page.
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Database connection details
// This section will only run if the user is NOT a coach or admin
if (!$is_coach) {
    $conn = new mysqli('localhost', 'root', 'admin123', 'pro');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION['id'];
    $player = null; 
    $report_link = null;
    $pdf_link = null;

    // Query to get the player's ID from the user's ID
    $query = "SELECT id, name FROM players WHERE user_id = ?";
    $stmt = $conn->prepare($query);

    // Check if statement preparation was successful
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $player = $result->fetch_assoc();
        $player_id = $player['id'];
        
        // Query to fetch the pdf_path from the evaluations table
        $eval_query = "SELECT pdf_path FROM evaluations WHERE player_id = ?";
        $eval_stmt = $conn->prepare($eval_query);
        if ($eval_stmt === false) {
            die("Error preparing evaluation statement: " . $conn->error);
        }
        $eval_stmt->bind_param("i", $player_id);
        $eval_stmt->execute();
        $eval_result = $eval_stmt->get_result();

        if ($eval_result->num_rows > 0) {
            $eval_data = $eval_result->fetch_assoc();
            if ($eval_data['pdf_path']) {
                // Construct the full URL for the PDF
                $pdf_link = "http://127.0.0.1:5000/" . htmlspecialchars($eval_data['pdf_path']);
            }
        }
        $eval_stmt->close();
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Your Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { padding: 0; }
        .card { max-width: 600px; margin: auto; padding: 20px; }
        .btn-1,
        .btn-custom {
            background-color: #00aa00; 
            color: #fff;
            border-color: #00aa00;
            font-weight: bold;
        }
        .btn-1:hover,
        .btn-custom:hover {
            background-color: #008800;
            border-color: #008800;
            color: #fff;
        }
    </style>
</head>
<body>

<?php
// Include the header file
include 'admin/includes/header.php';

if ($is_coach) {
    if ($_SESSION['userType'] === 'coach') {
        // This is the "forbidden" content for coaches
        echo '<div class="container text-center mt-5">';
        echo '    <div class="alert alert-warning" role="alert">';
        echo '        <h4 class="alert-heading">Permission Denied!</h4>';
        echo '        <p>You do not have access to "View_Report" page. As a coach, you should view player reports directly from Dashboard.</p>';
        echo '        <hr>';
        echo '        <p class="mb-0">Please go back to your dashboard to manage players.</p>';
        echo '        <a href="/pro/coach/player.php" class="btn btn-success mt-3">Go to Player Management</a>';
        echo '    </div>';
        echo '</div>';
    } elseif ($_SESSION['userType'] === 'admin') {
        // This is the "forbidden" content for admins
        echo '<div class="container text-center mt-5">';
        echo '    <div class="alert alert-danger" role="alert">';
        echo '        <h4 class="alert-heading">Access Denied!</h4>';
        echo '        <p>This page is restricted. As an administrator, you should manage coach registrations through the admin panel.</p>';
        echo '        <hr>';
        echo '        <p class="mb-0">Please return to the admin dashboard.</p>';
        echo '        <a href="/pro/admin/manage_coaches.php" class="btn btn-danger mt-3">Go to Admin Dashboard</a>';
        echo '    </div>';
        echo '</div>';
    }
} else {
    // This is the original report content for non-coach users
?>
<div class="card shadow-sm mt-5">
    <?php if ($player): ?>
        <h2>Welcome, <?php echo htmlspecialchars($player['name']); ?>!</h2>
        <p>You can view and download your evaluation report here.</p>
        
        <?php if ($pdf_link): ?>
            <a href="<?php echo $pdf_link; ?>" class="btn btn-primary btn-custom" target="_blank">
                <i class="fas fa-file-pdf"></i> View/Download Your Report (PDF)
            </a>
            <p style="margin-top: 10px;">
                If the report does not load, please email <a href="mailto:raudiyahiman@gmail.com">raudiyahiman@gmail.com</a> for assistance.
            </p>
        <?php else: ?>
            <p class="text-danger">Your report has not been generated yet. Please contact your coach.</p>
        <?php endif; ?>
        
    <?php else: ?>
        <h2>Report Not Found</h2>
        <p>It seems your player profile is not yet linked. Please contact support.</p>
    <?php endif; ?>
</div>
<?php
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>