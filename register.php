<?php
session_start();
require_once 'config.php';

$signup_message = '';
$signup_message_class = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];

    // Basic server-side validation
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        $signup_message = "Please fill out all required fields.";
        $signup_message_class = "alert-danger";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $signup_message = "Please enter a valid email address.";
        $signup_message_class = "alert-danger";
    } else {
        // Check if email already exists
        $sql = "SELECT id FROM users WHERE email = :email";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    // Email exists, display an error message on the same page
                    $signup_message = "This email is already registered. Please use a different email.";
                    $signup_message_class = "alert-danger";
                } else {
                    // Email is not in the database, proceed with registration
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    $sql = "INSERT INTO users (firstName, lastName, email, phone, password, userType) VALUES (:firstName, :lastName, :email, :phone, :password, 'client')";
                    
                    if ($stmt = $pdo->prepare($sql)) {
                        $stmt->bindParam(":firstName", $firstName);
                        $stmt->bindParam(":lastName", $lastName);
                        $stmt->bindParam(":email", $email);
                        $stmt->bindParam(":phone", $phone);
                        $stmt->bindParam(":password", $hashed_password);
                        
                        if ($stmt->execute()) {
                            // Registration successful, redirect to login page
                            header("location: login.php");
                            exit;
                        } else {
                            $signup_message = "Something went wrong. Please try again later.";
                            $signup_message_class = "alert-danger";
                        }
                    }
                }
            } else {
                $signup_message = "Oops! Something went wrong. Please try again later.";
                $signup_message_class = "alert-danger";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Signup Form</title>
   <link rel="icon" type="image/png" href="./img/logo.png">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>
  <style>
    .form-container {
      max-width: 400px;
      margin: 50px auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
    .form-control {
      border: 2px solid black !important;
      transition: border-color 0.3s ease;
    }
    .form-control:focus {
      border-color: #4cd964 !important;
      box-shadow: 0 0 5px #4cd964;
      outline: none;
    }
    .signup-btn {
      background-color: #4cd964;
      border: none;
      transition: background-color 0.3s ease;
      font-weight: 600;
    }
    .signup-btn:hover,
    .signup-btn:focus {
      background-color: #45c757;
      color: white;
      box-shadow: none;
    }
    .social-btn {
      width: 100%;
      margin-bottom: 10px;
      color: white !important;
      border: none;
      border-radius: 0.375rem;
      padding: 0.5rem 1rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: background-color 0.3s ease;
      cursor: pointer;
    }
    .social-btn.facebook {
      background-color: blue;
    }
    .social-btn.facebook:hover,
    .social-btn.facebook:focus {
      background-color: blue;
      color: white !important;
      box-shadow: none;
    }
    .social-btn.google {
      background-color: #db4437;
    }
    .social-btn.google:hover,
    .social-btn.google:focus {
      background-color: #bb392e;
      color: white !important;
      box-shadow: none;
    }
    .eye-icon {
      cursor: pointer;
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
    }
  </style>
</head>
<body>
<?php
// ... other code ...
include 'admin/includes/header.php';
// ... rest of the page ...
?>

<div class="form-container">
  <h4 class="text-center mb-4">SIGN UP</h4>
  <?php if ($signup_message): ?>
      <div class="alert <?php echo $signup_message_class; ?> text-center"><?php echo $signup_message; ?></div>
  <?php endif; ?>
  <form id="signupForm" novalidate action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <div class="mb-3">
      <input type="text" id="firstName" name="firstName" class="form-control" placeholder="First Name" required />
    </div>
    <div class="mb-3">
      <input type="text" id="lastName" name="lastName" class="form-control" placeholder="Last Name" required />
    </div>
    <div class="mb-3">
      <input type="email" id="email" name="email" class="form-control" placeholder="Email" required />
    </div>
    <div class="mb-3">
      <input type="tel" id="phone" name="phone" class="form-control" placeholder="Mobile Number" />
    </div>
    <div class="mb-3 position-relative">
      <input type="password" id="password" name="password" class="form-control" placeholder="Password" required minlength="6" />
      <span class="eye-icon" onclick="togglePassword()">👁️</span>
    </div>
    <div class="mb-3 small">
      By clicking on Sign up you agree to ProCricketTrials
      <a href="#" class="text-success">Terms and Conditions</a> and
      <a href="#" class="text-success">Privacy Policy</a>.
    </div>
    <div class="d-grid mb-3">
      <button type="submit" class="btn signup-btn text-white">SIGN UP</button>
    </div>
    <div class="text-center my-2">Or</div>
    <button type="button" class="social-btn facebook">
      <i class="bi bi-facebook"></i> Continue with Facebook
    </button>
    <button type="button" class="social-btn google">
      <i class="bi bi-google"></i> Continue with Google
    </button>
    <div class="text-center mt-3">
      Already have an account? <a href="login.php" class="text-primary">LOGIN</a>
    </div>
  </form>
</div>

<script>
  // Show/hide password
  function togglePassword() {
    const passField = document.getElementById("password");
    passField.type = passField.type === "password" ? "text" : "password";
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>