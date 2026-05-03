<?php
// Start the session at the very beginning of the file
session_start();

// The session check and redirect has been removed so the page loads for everyone.
// A visitor can now view this page directly.

// Fetch user data from the session if a user is logged in
$firstName = $_SESSION['firstName'] ?? 'Client';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>About</title>
    <link rel="icon" type="image/png" href="./img/logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
/* about.css content */
    .highlight {
      font-weight: bold;
    }
    .underline-title {
      border-bottom: 3px solid #28a745;
      display: inline-block;
      padding-bottom: 5px;
    }
    .card-custom {
      border: 1px solid #ddd;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      padding: 20px;
      transition: transform 0.3s ease;
      background-color: #fff;
    }
    .card-custom:hover {
      transform: translateY(-5px);
    }

      .underline-title {
    border-bottom: 3px solid #28a745;
    display: inline-block;
    padding-bottom: 5px;
  }

  .card-custom {
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease;
  }

  .card-custom:hover {
    transform: translateY(-5px);
  }

    .underline-title {
    border-bottom: 3px solid #28a745;
    display: inline-block;
    padding-bottom: 5px;
  }

  .card-custom {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease;
  }

  .card-custom:hover {
    transform: translateY(-5px);
  }

    /* Green border and shadow on focus */
    .form-control:focus,
    .form-select:focus,
    textarea:focus {
      border-color: #00cc00;
      box-shadow: 0 0 0 0.2rem rgba(0, 204, 0, 0.25);
    }
        /* Hero and Footer Styling */
    footer a {
      color: #000; /* Black link text */
      text-decoration: none; /* No underline */
    }

    footer a:hover {
      color: black; /* Optional hover color */
  
    }
</style>
</head>
<body>
    <?php
// ... other code ...
include 'admin/includes/header.php';
// ... rest of the page ...
?>

<div class="container py-5 text-center">
  <h2 class="fw-bold underline-title">Why ProCricketTrials</h2>
  <p class="mt-4">
    <span class="highlight">ProCricketTrials</span> was started in Dubai by a team of tech entrepreneurs and cricket fanatics,
    who realised there was an opportunity to bring an international level of quality to every cricket match in the world
    by building a one stop cricket solution to the palm of your hand. Having team members from global cricket powerhouses
    including Pakistan, Australia and India, the CricksLab team has seen the fanaticism of every level of cricket and have
    seen that matches are run in an archaic way that doesn’t use any modern technology.
    <span class="highlight">ProCricketTrials</span> is here to bring the awesomeness of stats and real-time data to even match –
    from the players in the street to world renowned domestic competitions. CricksLab delivers a one-window-solution to
    track every ball, count every run and see real-time match information from your mobile.
    <strong>Its a cricket revolution!</strong>
  </p>

  <div class="row mt-5">
    <div class="col-md-6 mb-4">
      <div class="card-custom h-100">
        <h4 class="fw-bold">OUR MISSION</h4>
        <p class="mt-3">
          To redefine the way domestic cricket is played around the world, using digital technology to provide an ‘international’
          experience for clubs, players & fans.
        </p>
      </div>
    </div>
    <div class="col-md-6 mb-4">
      <div class="card-custom h-100">
        <h4 class="fw-bold">OUR VISION</h4>
        <p class="mt-3">
          To be the world's leading online cricket portal.
        </p>
      </div>
    </div>
  </div>
</div>

<section class="py-5">
  <div class="container text-center">
    <h2 class="fw-bold underline-title">What we do Offer</h2>
    <p class="mt-3">
      <span class="fw-bold">ProCricketTrials</span> is a complete cricket match and league management solution that benefits
      Clubs, Universities, Cricket Event Organizations, Talent hunters, Game Fans, Advertisers, Merchants, Media
      and of course the Players! Checkout our suite of product features below:
    </p>

    <div class="row justify-content-center mt-4 g-3">
      <div class="col-6 col-md-3">
        <div class="card-custom text-center py-4">
          <h5 class="fw-bold mb-0">ADMINISTRATION</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card-custom text-center py-4">
          <h5 class="fw-bold mb-0">CRM</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card-custom text-center py-4">
          <h5 class="fw-bold mb-0">SCORING</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card-custom text-center py-4">
          <h5 class="fw-bold mb-0">TALENT HUNTING</h5>
        </div>
      </div>
    </div>
  </div>
</section>




<section class="py-5 bg-light">
  <div class="container text-center">
    <h2 class="fw-bold underline-title">Match Centre</h2>
    <p class="mt-3">
      View matches, checkout ongoing competitions and leagues, checkout and join teams & clubs in your area,
      find your friends currently playing with CricksLab and search for talent if you're a club or professional organisation.
    </p>

    <div class="row mt-5 g-3 justify-content-center">
      <div class="col-6 col-md-3">
        <div class="card-custom py-4 text-center">
          <h5 class="fw-bold mb-0">CLUBS</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card-custom py-4 text-center">
          <h5 class="fw-bold mb-0">PLAYERS</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card-custom py-4 text-center">
          <h5 class="fw-bold mb-0">TEAMS</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card-custom py-4 text-center">
          <h5 class="fw-bold mb-0">MATCHES</h5>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card-custom py-4 text-center">
          <h5 class="fw-bold mb-0">COMPETITIONS</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card-custom py-4 text-center">
          <h5 class="fw-bold mb-0">OFFICIALS</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card-custom py-4 text-center">
          <h5 class="fw-bold mb-0">FANS</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card-custom py-4 text-center">
          <h5 class="fw-bold mb-0">TALENT HUNTING</h5>
        </div>
      </div>
    </div>
  </div>
</section>




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
    <a href="/html/HTML/login.html" class="btn btn-outline-light px-4 py-2">Login</a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>