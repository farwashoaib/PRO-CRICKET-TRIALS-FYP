<?php
session_start();
$firstName = $_GET['name'] ?? 'Player';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Successful</title>
    <link rel="icon" type="image/png" href="images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 100px;
        }
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
        }
        .btn-primary {
            background-color: #00aa00;
            border-color: #00aa00;
        }
        .btn-primary:hover {
            background-color: #008800;
            border-color: #008800;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        Submission Successful
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Thank you, <?php echo htmlspecialchars($firstName); ?>!</h5>
                        <p class="card-text">Your message has been successfully submitted to our database. We will get back to you shortly.</p>
                        <a href="http://localhost/pro/index.php" class="btn btn-primary mt-3">Return to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>