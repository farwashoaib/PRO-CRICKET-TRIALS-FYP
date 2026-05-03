<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Adjust path if you manually downloaded
// If using Composer, this line is sufficient:
require 'vendor/autoload.php'; 

// If you manually downloaded and placed src in vendor/phpmailer
// require 'vendor/phpmailer/src/Exception.php';
// require 'vendor/phpmailer/src/PHPMailer.php';
// require 'vendor/phpmailer/src/SMTP.php';

function sendEmail($toEmail, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'hajrabibi012003@gmail.com';                 // SMTP username (YOUR GMAIL ADDRESS)
        $mail->Password   = 'vdwu ihre dsxh vvnh';                    // SMTP password (YOUR GMAIL APP PASSWORD)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
        $mail->Port       = 465;                                    // TCP port to connect to; use 587 if you added `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;`

        // IMPORTANT: For Gmail, you need to generate an **App Password** // if you have 2-Factor Authentication enabled.
        // Go to your Google Account -> Security -> App passwords.
        // If 2FA is not enabled, you might need to enable "Less secure app access" 
        // (NOT RECOMMENDED for production, but might work for testing).

        //Recipients
        $mail->setFrom('hajrabibi012003@gmail.com', 'ProCricketTrials'); // Sender
        $mail->addAddress($toEmail);                                // Add a recipient

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body); // Plain text for non-HTML mail clients

        $mail->send();
        // echo 'Message has been sent'; // For debugging, remove in production
        return true;
    } catch (Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"; // For debugging
        return false;
    }
}
?>