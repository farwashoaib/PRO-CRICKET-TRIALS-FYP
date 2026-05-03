<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include the Composer autoloader
require 'vendor/autoload.php';

// Check if registration data exists in the session
if (!isset($_SESSION['registration_data'])) {
    // If no data is found, redirect back to the registration form or an error page
    header("Location: registration.php");
    exit;
}

// Retrieve the registration data from the session
$formData = $_SESSION['registration_data'];

// Clear the session data after displaying it to prevent re-display on refresh
unset($_SESSION['registration_data']);

$mailSent = false;

// Instantiate PHPMailer
$mail = new PHPMailer(true); // Passing `true` enables exceptions

try {
    // Server settings
    $mail->SMTPDebug = 0; // Set to 2 for detailed debugging
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Use your SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'hajrabibi012003@gmail.com'; // Your SMTP username
    $mail->Password   = 'vdwu ihre dsxh vvnh'; // Your SMTP password or app password
    $mail->SMTPSecure = 'tls'; // Use 'ssl' for port 465
    $mail->Port       = 587; // Use 465 for 'ssl'

    // Recipients
    $to = $formData['email'] ?? '';
    if (!empty($to) && filter_var($to, FILTER_VALIDATE_EMAIL)) {
        $mail->setFrom('hajrabibi012003@gmail.com', 'ProCricketTrials');
        $mail->addAddress($to, $formData['name'] ?? 'Player');
        
        // Content
        $mail->isHTML(false); // Set to true if you want to send HTML email
        $mail->Subject = 'Player Registration Successful';
        
        $message = "Dear " . htmlspecialchars($formData['name'] ?? 'Player') . ",\n\n";
        $message .= "Your registration for ProCricketTrials has been submitted successfully.\n\n";
        $message .= "Your Submitted Details:\n\n";

        // Add all form data to the email message
        foreach ($formData as $key => $value) {
            if (!is_array($value) && $key !== 'playerImage' && $key !== 'cnicFront' && $key !== 'cnicBack') {
                $message .= ucfirst(str_replace('_', ' ', $key)) . ": " . htmlspecialchars($value) . "\n";
            }
        }
        $message .= "\nThank you for registering!\n\nProCricketTrials Team";

        $mail->Body = $message;

        $mail->send();
        $mailSent = true;
    }

} catch (Exception $e) {
    // Log the error for debugging, but don't show it to the user
    error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    $mailSent = false;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <link rel="icon" type="image/png" href="/pro/img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   
</head>
<body>
    <?php include 'admin/includes/header.php'; ?>

    <div class="container text-center">
      <img src="/pro/img/logo.png" alt="PCB Logo" width="120" class="mt-4 mb-4" />
        <h2 class="mb-4 text-success">🎉 Registration Successful! 🎉</h2>
        <p class="lead">Thank you, **<?= htmlspecialchars($formData['name'] ?? 'Player') ?>**, for registering. Your details have been successfully submitted.</p>
        
        <?php if ($mailSent): ?>
            <div class="alert alert-info mt-3" role="alert">
                A confirmation email has been sent to **<?= htmlspecialchars($formData['email'] ?? 'your email address') ?>**. Please check your inbox (and spam folder).
            </div>
        <?php else: ?>
            <div class="alert alert-warning mt-3" role="alert">
                Registration was successful, but a confirmation email could not be sent. Please ensure your server's mail function is properly configured.
            </div>
        <?php endif; ?>

        <hr>

        <h4 class="mt-5 mb-3 text-primary">Your Submitted Details:</h4>
        <div class="row text-start">
            <div class="col-md-6">
                <div class="section-heading">Personal Information</div>
                <div class="detail-row"><strong>Name:</strong> <?= htmlspecialchars($formData['name'] ?? 'N/A') ?></div>
                <div class="detail-row"><strong>Gender:</strong> <?= htmlspecialchars($formData['gender'] ?? 'N/A') ?></div>
                <div class="detail-row"><strong>Date of Birth:</strong> <?= htmlspecialchars($formData['dob'] ?? 'N/A') ?></div>
                <div class="detail-row"><strong>Birth Place:</strong> <?= htmlspecialchars($formData['birthPlace'] ?? 'N/A') ?></div>
                <div class="detail-row"><strong>Religion:</strong> <?= htmlspecialchars($formData['religion'] ?? 'N/A') ?></div>
                <div class="detail-row"><strong>Nationality:</strong> <?= htmlspecialchars($formData['nationality'] ?? 'N/A') ?></div>
                <div class="detail-row"><strong>Marital Status:</strong> <?= htmlspecialchars($formData['maritalStatus'] ?? 'N/A') ?></div>
                <div class="detail-row"><strong>Blood Group:</strong> <?= htmlspecialchars($formData['bloodGroup'] ?? 'N/A') ?></div>
            </div>
            <div class="col-md-6">
                <div class="section-heading">Contact & Location</div>
                <div class="detail-row"><strong>Email:</strong> <?= htmlspecialchars($formData['email'] ?? 'N/A') ?></div>
                <div class="detail-row"><strong>Mobile No:</strong> <?= htmlspecialchars($formData['mobileNo'] ?? 'N/A') ?></div>
                <div class="detail-row"><strong>Residence Phone:</strong> <?= htmlspecialchars($formData['residencePhone'] ?? 'N/A') ?></div>
                <div class="detail-row"><strong>Postal Address:</strong> <?= htmlspecialchars($formData['postalAddress'] ?? 'N/A') ?></div>
                <div class="detail-row"><strong>Residence City:</strong> <?= htmlspecialchars($formData['residenceCity'] ?? 'N/A') ?></div>
                <div class="detail-row"><strong>Province:</strong> <?= htmlspecialchars($formData['province'] ?? 'N/A') ?></div>
                <div class="detail-row"><strong>Region:</strong> <?= htmlspecialchars($formData['region'] ?? 'N/A') ?></div>
                <div class="detail-row"><strong>District:</strong> <?= htmlspecialchars($formData['district'] ?? 'N/A') ?></div>
                <div class="detail-row"><strong>City:</strong> <?= htmlspecialchars($formData['city'] ?? 'N/A') ?></div>
            </div>
        </div>

        <div class="row text-start mt-4">
            <div class="col-md-6">
                <div class="section-heading">Cricket Details</div>
                <div class="detail-row"><strong>Batting Type:</strong> <?= htmlspecialchars($formData['battingType'] ?? 'N/A') ?></div>
                <div class="detail-row"><strong>Cricket Played:</strong> <?= htmlspecialchars($formData['cricketPlayed'] ?? 'N/A') ?></div>
            </div>
            
        </div>

        <div class="row text-start mt-4">
            <div class="col-md-4">
                <div class="section-heading">Player Image</div>
                <?php if (!empty($formData['playerImagePath'])): ?>
                    <img src="<?= htmlspecialchars($formData['playerImagePath']) ?>" alt="Player Image" class="img-fluid image-preview">
                <?php else: ?>
                    <p>No player image uploaded.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-5">
            <a href="http://localhost/pro/index.php" class="btn btn-secondary">Go to Dashboard</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>