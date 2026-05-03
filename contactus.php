<?php
// Include your configuration file
require_once 'config.php';

// The session check and redirect has been removed to allow public access.
// A visitor can now view this page directly.

// Check if the user is logged in and is a client
/*
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['userType'] !== 'client'){
    // Redirect to the login page if not logged in
    header("location: login.php");
    exit;
}
*/

// Fetch user data from the session if a user is logged in
session_start();
$firstName = $_SESSION['firstName'] ?? 'Client';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact Us</title>
 <link rel="icon" type="image/png" href="./img/logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
/* Footer links styling */
footer a {
  text-decoration: none;
  color: #000; /* Black color for footer links */
}

footer a:hover {
    color: #000; /* Keeping it black on hover as well */
}

/* Submit button and Login button styling */
.submit-btn,
.btn-outline-light {
  background-color: #00aa00; /* Specific green color */
  border-color: #00aa00; /* Specific green color */
  color: #fff;
  font-weight: bold;
}

.submit-btn:hover,
.btn-outline-light:hover {
  background-color: #008800; /* A darker green for hover effect */
  border-color: #008800;
  color: #fff;
}

/* Contact box styling */
.contact-box {
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 30px;
  background-color: #fff;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  height: 100%; /* Ensure all boxes are same height */
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.contact-box .icon {
  font-size: 2.5rem;
  color: #28a745;
  margin-bottom: 10px;
}
</style>


</head>
<body>
      <?php
// ... other code ...
include 'admin/includes/header.php';
// ... rest of the page ...
?>

<div class="container py-5">
  <h2 class="text-center fw-bold mb-3">HOW TO CONTACT US?</h2>
  <p class="text-center mb-5">
    Please fill in the required details in below form and you will be contacted by our marketing department regarding your media inquiry.
    <br>Please note that this contact form is for media-related topics only.
  </p>

  <div class="row g-4">
    <div class="col-lg-6">
      <div class="row g-3">
        <div class="col-12">
          <div class="contact-box text-center">
            <div class="icon mb-2"><i class="fas fa-map-marker-alt"></i></div>
            <h5 class="fw-bold">HEAD OFFICE</h5>
            <p>12A-04, DAMAC SMART HEIGHTS, TECOM, DUBAI, UAE.</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="contact-box text-center h-100">
            <div class="icon mb-2"><i class="fas fa-phone"></i></div>
            <h5 class="fw-bold">HELP LINE</h5>
            <p>+971 4 360 5680</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="contact-box text-center h-100">
            <div class="icon mb-2"><i class="fas fa-mobile-alt"></i></div>
            <h5 class="fw-bold">OFFICE NUMBER</h5>
            <p>PAKISTAN: +92 332 8075188<br>UAE: +97 55 9987521</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <form class="needs-validation" novalidate action="submit.php" method="POST">
        <div class="mb-3">
          <input type="text" class="form-control p-2" name="name" placeholder="Name*" required>
          <div class="invalid-feedback">Please enter your name.</div>
        </div>
        <div class="mb-3">
          <input type="email" class="form-control p-2" name="email" placeholder="Email*" required>
          <div class="invalid-feedback">Please enter a valid email.</div>
        </div>
        <div class="mb-3">
          <input type="tel" class="form-control p-2" name="mobile" placeholder="Mobile Number*" pattern="^\+?\d{7,15}$" required>
          <div class="invalid-feedback">Please enter a valid phone number.</div>
        </div>
        <div class="mb-3">
          <select class="form-select p-2" name="type" required>
            <option value="">Select Type</option>
            <option value="media">Media</option>
            <option value="general">General</option>
            <option value="support">Support</option>
          </select>
          <div class="invalid-feedback">Please select a type.</div>
        </div>
        <div class="mb-3">
          <textarea class="form-control p-2" name="message" rows="4" placeholder="Write Message*" required></textarea>
          <div class="invalid-feedback">Please write your message.</div>
        </div>
        <div class="d-grid">
          <button type="submit" class="btn submit-btn p-2">SUBMIT</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Bootstrap validation
  (() => {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  })();
</script>

<section class="text-white py-5" style="background: linear-gradient(135deg, #00aa00, #008800);">
  <div class="container text-center">
    <h2 class="fw-bold mb-3">GET AMAZED WITH <span style="color: #c3ff00;">ProCricketTrials</span></h2>
    <p class="mb-4">
      Fully responsive Web platform and Apps that is Simple, Easy to use, and FREE with a lot of features!<br>
      Are you Cricket FAN or PROFESSIONAL? Come discover our products, you are just a click away to witness the cricket revolution!
    </p>
    <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">
      <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" height="50"></a>
      <a href="#"><img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="App Store" height="50"></a>
    </div>
    <a href="login.php" class="btn btn-outline-light px-4 py-2">Login</a>
  </div>
</section>

<footer class="bg-light pt-5 pb-3">
  <div class="container">
    <div class="row text-center text-md-start">
      <div class="col-md-3 mb-4">
        <h5 class="fw-bold">ProCricketTrials</h5>
        <ul class="list-unstyled">
          <li><a href="#">About Us</a></li>
          <li><a href="#">Contact Us</a></li>
          <li><a href="#">News</a></li>
          <li><a href="#">Blogs</a></li>
          <li><a href="#">Pricing</a></li>
          <li><a href="#">Terms & Conditions</a></li>
        </ul>
      </div>
      <div class="col-md-3 mb-4">
        <h5 class="fw-bold">Matches</h5>
        <ul class="list-unstyled">
          <li><a href="#">Live</a></li>
          <li><a href="#">Completed</a></li>
          <li><a href="#">Upcoming</a></li>
        </ul>
      </div>
      <div class="col-md-3 mb-4">
        <h5 class="fw-bold">Useful Links</h5>
        <ul class="list-unstyled">
          <li><a href="#">Competitions</a></li>
          <li><a href="#">Teams</a></li>
          <li><a href="#">Clubs</a></li>
          <li><a href="#">Officials</a></li>
          <li><a href="#">Players</a></li>
          <li><a href="#">Search Talent</a></li>
        </ul>
      </div>
      <div class="col-md-3 mb-4">
        <h5 class="fw-bold">Countries</h5>
        <select class="form-select mb-3">
          <option selected>Select your country</option>
          <option value="1">Pakistan</option>
          <option value="2">UAE</option>
          <option value="3">India</option>
        </select>
        <h6 class="fw-bold">Connect with us</h6>
        <div class="d-flex justify-content-center justify-content-md-start gap-2 mt-2">
  <a href="https://facebook.com" target="_blank" rel="noopener noreferrer">
    <i class="fab fa-facebook fa-lg text-primary"></i>
  </a>
  <a href="https://twitter.com" target="_blank" rel="noopener noreferrer">
    <i class="fab fa-twitter fa-lg text-info"></i>
  </a>
  <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer">
    <i class="fab fa-linkedin fa-lg text-primary"></i>
  </a>
  <a href="https://instagram.com" target="_blank" rel="noopener noreferrer">
    <i class="fab fa-instagram fa-lg text-danger"></i>
  </a>
  <a href="https://youtube.com" target="_blank" rel="noopener noreferrer">
    <i class="fab fa-youtube fa-lg text-danger"></i>
  </a>
</div>

        </div>
      </div>
    </div>
  </div>
</footer>

</body>
</html>