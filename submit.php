<?php
// Include the database configuration file
require_once 'config.php';

// Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize the form data
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $mobile = trim($_POST["mobile"]);
    $type = trim($_POST["type"]);
    $message = trim($_POST["message"]);

    // Check if the fields are valid
    if (empty($name) OR empty($email) OR empty($mobile) OR empty($type) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Handle error: not all fields were filled correctly
        http_response_code(400);
        header("Location: contactus.php?status=error");
        exit;
    }

    // Prepare a database insertion statement using PDO
    $sql = "INSERT INTO contacts (name, email, mobile, type, message) VALUES (?, ?, ?, ?, ?)";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $email, $mobile, $type, $message]);
        
        // Success: Redirect to a success page
        header("Location: success.php?name=" . urlencode($name));
        exit;
        
    } catch(PDOException $e) {
        // Log the error if the insertion fails
        error_log("Error saving contact form to database: " . $e->getMessage());
        
        // Display an error message to the user
        http_response_code(500);
        header("Location: contactus.php?status=db_error");
        exit;
    }
} else {
    // Not a POST request, so set a 403 (forbidden) response code.
    http_response_code(403);
    echo "You are not authorized to access this page directly. Please use the contact form to submit your inquiry.";
}
?>