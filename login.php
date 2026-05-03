<?php
// Start the session
session_start();

require_once 'config.php';
require_once 'mail_config.php';

$message = '';
$message_type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // --- Check for admin credentials first ---
    // The `admins` table has 'id', 'email', 'password'. We'll use 'email' for the name.
    $sql_admin = "SELECT id, password, email FROM admins WHERE email = :email";

    if ($stmt_admin = $pdo->prepare($sql_admin)) {
        $stmt_admin->bindParam(":email", $email, PDO::PARAM_STR);
        if ($stmt_admin->execute()) {
            if ($stmt_admin->rowCount() == 1) {
                $row_admin = $stmt_admin->fetch(PDO::FETCH_ASSOC);

                if ($password === $row_admin['password']) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id'] = $row_admin['id'];
                    $_SESSION['email'] = $email;
                    $_SESSION['userType'] = 'admin';
                    $_SESSION['name'] = "Admin"; // Use a generic name or the email
                    
                    // Send login notification email
                    $subject = "Admin Login Notification - ProCricketTrials";
                    $body = "Dear Admin,<br><br>Your ProCricketTrials admin account ({$email}) was just logged into.<br><br>If this was not you, please secure your account immediately.<br><br>Best regards,<br>ProCricketTrials Team";
                    sendEmail($email, $subject, $body);

                    header("location: /pro/admin/manage_coaches.php");
                    exit();
                } else {
                    $message = "The password you entered was not valid.";
                    $message_type = 'error';
                }
            }
        }
        unset($stmt_admin);
    }

    // --- If not an admin, check the regular users table ---
    if (empty($message)) {
        $sql_user = "SELECT id, password, userType, firstName, lastName FROM users WHERE email = :email";
        
        if ($stmt_user = $pdo->prepare($sql_user)) {
            $stmt_user->bindParam(":email", $email, PDO::PARAM_STR);

            if ($stmt_user->execute()) {
                if ($stmt_user->rowCount() == 1) {
                    $row_user = $stmt_user->fetch(PDO::FETCH_ASSOC);

                    if (password_verify($password, $row_user['password'])) {
                        $_SESSION['loggedin'] = true;
                        $_SESSION['id'] = $row_user['id'];
                        $_SESSION['email'] = $email;
                        $_SESSION['userType'] = $row_user['userType'];
                        
                        // Set a default name from the users table
                        $_SESSION['name'] = $row_user['firstName'] . ' ' . $row_user['lastName'];

                        // If the user is a coach, fetch the name from the 'coaches' table
                        if ($row_user['userType'] === 'coach') {
                            $sql_coach = "SELECT name FROM coaches WHERE email = :email";
                            $stmt_coach = $pdo->prepare($sql_coach);
                            $stmt_coach->bindParam(":email", $email, PDO::PARAM_STR);
                            $stmt_coach->execute();
                            $coach_row = $stmt_coach->fetch(PDO::FETCH_ASSOC);
                            
                            // If coach name is found, overwrite the session name
                            if ($coach_row) {
                                $_SESSION['name'] = $coach_row['name'];
                            }
                        }

                        // Send login notification email
                        $userDisplayName = ucfirst($row_user['userType']);
                        $subject = "Login Notification - ProCricketTrials";
                        $body = "Dear {$userDisplayName},<br><br>Your ProCricketTrials account ({$email}) was just logged into.<br><br>If this was not you, please secure your account immediately.<br><br>Best regards,<br>ProCricketTrials Team";
                        sendEmail($email, $subject, $body);

                        if ($row_user['userType'] === 'coach') {
                            header("location: /pro/coach/player.php");
                        } else {
                            header("location: /pro/index.php");
                        }
                        exit();
                    } else {
                        $message = "The password you entered was not valid.";
                        $message_type = 'error';
                    }
                } else {
                    $message = "No account found with that email.";
                    $message_type = 'error';
                }
            } else {
                $message = "Something went wrong. Please try again later.";
                $message_type = 'error';
            }
            unset($stmt_user);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login Page</title>
    <link rel="icon" type="image/png" href="./img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .login-box { max-width: 400px; margin: 60px auto; background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        .form-control { border: 2px solid black; }
        .form-control:focus { border-color: #4cd964; box-shadow: 0 0 5px #4cd964; }
        .login-btn { background-color: #4cd964; border: none; transition: background-color 0.3s ease; font-weight: 600; }
        .login-btn:hover { background-color: #45c757; color: white; }
        .social-btn { width: 100%; margin-bottom: 10px; color: white !important; border: none; border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px; transition: background-color 0.3s ease; cursor: pointer; }
        .social-btn.facebook { background-color: blue; }
        .social-btn.facebook:hover { background-color: blue; color: white !important; box-shadow: none; }
        .social-btn.google { background-color: #db4437; }
        .social-btn.google:hover { background-color: #bb392e; color: white !important; box-shadow: none; }
    </style>
</head>
<body>
   <?php
// ... other code ...
include 'admin/includes/header.php';
// ... rest of the page ...
?>
    <div class="login-box">
        <h3 class="text-center mb-4">LOGIN</h3>
        <?php if (!empty($message)): ?>
            <div class="alert alert-danger text-center"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required />
            </div>
            <div class="mb-3">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
            </div>
            <div class="d-grid mb-3">
                <button type="submit" class="btn login-btn text-white">LOGIN</button>
            </div>
            <div class="text-center my-2">Or</div>
            <button type="button" class="social-btn facebook">
                <i class="fab fa-facebook-f me-2"></i> Continue with Facebook
            </button>
            <button type="button" class="social-btn google">
                <i class="fab fa-google me-2"></i> Continue with Google
            </button>
            <div class="text-center mt-3">
                Don't have an account? <a href="/pro/register.php" class="text-primary">SIGNUP</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>