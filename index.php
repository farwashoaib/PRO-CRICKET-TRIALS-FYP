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
    <title>ProCricketTrials</title>
    <link rel="icon" type="image/png" href="./img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
/* Global Styles for a more modern, stylish look */
body {
    font-family: 'Roboto', sans-serif;
    color: #333;
}

.hero-section {
    position: relative;
    background: url('./img/background.jpg') no-repeat center center/cover;
    color: #fff;
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    z-index: 1;
    overflow: hidden;
}

.hero-section::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6); /* Dark transparent overlay */
    z-index: -1;
}

/* Updated buttons for a sleek look */
.btn-1 {
    background-color: #1a861a; /* Darker, more elegant green */
    color: #fff;
    border-color: #1a861a;
    font-weight: 500;
    border-radius: 50px; /* Rounded pill shape */
    padding: 10px 25px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(26, 134, 26, 0.3);
}

.btn-1:hover {
    background-color: #156d15;
    border-color: #156d15;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(26, 134, 26, 0.4);
}

/* Stylish card and icon hover effects */
.icon-box {
    color: #1a861a;
    transition: transform 0.4s ease-in-out;
}

.icon-box:hover {
    transform: translateY(-10px);
}

.icon-circle {
    background-color: #e6f7ec;
    padding: 20px;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    transition: background-color 0.3s ease;
}

.icon-box:hover .icon-circle {
    background-color: #1a861a;
}

.icon-box:hover .icon {
    color: #fff;
}

.icon {
    font-size: 2.5rem;
    color: #28a745;
    transition: color 0.3s ease;
}

/* Section titles and text for better readability */
h2, h4, h5 {
    font-weight: 700;
}
p.lead, p.text-muted {
    font-weight: 300;
    font-size: 1.1rem;
}
h1.display-4 {
    font-size: 2.5rem !important;
}

/* Footer links styling */
footer a {
    text-decoration: none;
    color: #555; /* A softer black for links */
    transition: color 0.3s ease;
}

footer a:hover {
    color: #1a861a; /* Green on hover */
}

/* Styling for the new pro-club section */
.pro-club-section {
    position: relative;
    background: linear-gradient(135deg, #1a861a, #0c4d0c);
    padding: 30px 20px;
    color: #fff;
    overflow: hidden;
}

.pro-club-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('data:image/svg+xml,%3Csvg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"%3E%3Cpath d="M50 0L61.8 38.2L100 38.2L69.1 61.8L80.9 100L50 76.4L19.1 100L30.9 61.8L0 38.2L38.2 38.2L50 0Z" fill="%23FFFFFF" fill-opacity="0.05"%3E%3C/path%3E%3C/svg%3E');
    background-size: 200px;
    opacity: 0.8;
    z-index: 0;
}

.pro-club-section .container {
    position: relative;
    z-index: 1;
}

/* Button style for the new section */
.btn-pro-club {
    background-color: #fff;
    color: #1a861a;
    border: none;
    border-radius: 50px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

.btn-pro-club:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    background-color: #f0f0f0;
    color: #126812;
}

.pro-club-section h2 {
    font-size: 3rem;
}

@media (max-width: 768px) {
    .pro-club-section h2 {
        font-size: 2rem;
    }
}

.hover-card:hover {
    box-shadow: 0 0 25px rgba(26, 134, 26, 0.2) !important;
}

/* Add glow effect for the main button */
.btn-1 {
    transition: all 0.4s ease; /* Ensure the glow is animated smoothly */
}

.btn-1:hover {
    box-shadow: 0 0 20px #1a861a; /* A softer, glowing box-shadow */
}

/* --- Start of new animation styles --- */

/* CSS for professional image animation */
.image-wrapper {
    /* Ensures the image is correctly positioned for transforms */
    position: relative;
    overflow: hidden; 
}

.image-hover-effect {
    /* Scale the image slightly and transition smoothly */
    transform: scale(1);
    transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1); /* Subtle shadow for depth */
}

/* Hover effect on the image */
.image-hover-effect:hover {
    transform: scale(1.03); /* Slightly zoom in on hover */
    box-shadow: 0 8px 25px rgba(0,0,0,0.2); /* Enhance shadow on hover */
}

/* Optional: Subtle animation for list items */
.animated-list li {
    transition: transform 0.3s ease-out;
}

.animated-list li:hover {
    transform: translateX(5px); /* Move list item slightly to the right on hover */
}

/* --- End of new animation styles --- */
</style>
</head>
<body>
<?php
// ... other code ...
include 'admin/includes/header.php';
// ... rest of the page ...
?>


<section class="hero-section">
    <div class="container text-white">
      <h1 class="fw-bold display-4" data-aos="fade-up" data-aos-duration="1000">Your Path to Professional Cricket Starts Here.</h1>
      <p class="lead mt-3" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
        Prove your talent at our official cricket trials.<br>
        Showcase your skills, get scouted, and take the first step toward a pro career.
      </p>

<div class="d-flex justify-content-center align-items-center flex-wrap gap-2 mt-4 download-buttons" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
  <a href="https://apps.apple.com/app/id123456789" target="_blank">
    <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg"
             alt="Download on the App Store" style="height:70px; width:220px; object-fit: contain;">
  </a>

  <a href="https://play.google.com/store/apps/details?id=com.example.app" target="_blank">
    <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
             alt="Get it on Google Play" style="height:70px; width:220px; object-fit: contain;">
  </a>
</div>

    </div>
  </section>

  <section class="py-5 text-center">
  <div class="container">
    <h2 class="fw-bold">Powering Cricket at Every Level</h2>
    <p class="text-muted">Manage any level of competition from backyard & street cricket to school, University, club and professional matches.</p>
    
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mt-4">

      <div class="col">
        <div class="p-3 border-0 icon-box" data-aos="fade-up" data-aos-delay="100">
          <div class="icon-circle mb-3">
            <i class="bi bi-person-up icon"></i>
          </div>
          <h5>Players</h5>
          <p class="small text-muted">Unlock your potential. Get an AI-powered report on your technique and track your progress to get noticed by coaches and scouts.</p>
        </div>
      </div>

      <div class="col">
        <div class="p-3 border-0 icon-box" data-aos="fade-up" data-aos-delay="200">
          <div class="icon-circle mb-3">
            <i class="bi bi-shield-fill-check icon"></i>
          </div>
          <h5>Cricket Clubs</h5>
          <p class="small text-muted">Streamline your scouting. Use AI-powered analysis to quickly evaluate a player's shot technique and find new talent for your club.</p>
        </div>
      </div>

      <div class="col">
        <div class="p-3 border-0 icon-box" data-aos="fade-up" data-aos-delay="300">
          <div class="icon-circle mb-3">
            <i class="bi bi-book-half icon"></i>
          </div>
          <h5>Academies & Schools</h5>
          <p class="small text-muted">Elevate your coaching. Provide students with data-driven feedback on their shots and create personalized training plans for development.</p>
        </div>
      </div>

      <div class="col">
        <div class="p-3 border-0 icon-box" data-aos="fade-up" data-aos-delay="400">
          <div class="icon-circle mb-3">
            <i class="bi bi-graph-up-arrow icon"></i>
          </div>
          <h5>Coaches & Scouts</h5>
          <p class="small text-muted">Make smarter decisions. Use objective, data-backed reports on a player's technique to make confident recruiting choices for your team.</p>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
function toggleGreen(element) {
  document.querySelectorAll('.icon-box').forEach(box => box.classList.remove('active'));
  element.classList.add('active');
}
</script>

<section class="py-5 bg-light">
  <div class="container">
    <div class="row align-items-center g-4">

      <div class="col-md-6" data-aos="fade-right" data-aos-duration="1000">

        <h4 class="fw-bold mt-4 mb-2">Your Journey to the Top Starts Here.</h4>
        <p class="text-muted">
          Every professional cricketer started somewhere. Once they we're in your shoes, practicing tirelessly and dreaming of a professional career. At ProCricketTrials, we believe that with the right tools, any aspiring player can achieve greatness. We're here to provide the platform to showcase your skills, get noticed by scouts, and make your dreams a reality.
        </p>
        <ul class="list-unstyled">
          <li class="mb-2" data-aos="fade-right" data-aos-delay="100">
            <i class="bi bi-check-circle-fill me-2" style="color: #1a861a;"></i> Our AI-powered reports give you precise, data-driven feedback on your technique, helping you turn practice into real progress.
          </li>
          <li class="mb-2" data-aos="fade-right" data-aos-delay="200">
            <i class="bi bi-check-circle-fill me-2" style="color: #1a861a;"></i> We connect you directly with professional scouts and coaches who are actively searching for new talent.
          </li>
          <li class="mb-2" data-aos="fade-right" data-aos-delay="300">
            <i class="bi bi-check-circle-fill me-2" style="color: #1a861a;"></i> Track your skills over time with detailed stats and insights, showing you how far you've come and what you need to do next.
          </li>
          <li class="mb-2" data-aos="fade-right" data-aos-delay="400">
            <i class="bi bi-check-circle-fill me-2" style="color: #1a861a;"></i> Get a world-class profile that puts your performance on display for teams and talent hunters everywhere.
          </li>
          <li class="mb-2" data-aos="fade-right" data-aos-delay="500">
            <i class="bi bi-check-circle-fill me-2" style="color: #1a861a;"></i> Stop hoping to be seen. Our system ensures your talent is highlighted, giving you a competitive edge.
          </li>
          <li class="mb-2" data-aos="fade-right" data-aos-delay="600">
            <i class="bi bi-check-circle-fill me-2" style="color: #1a861a;"></i> Sign up for exclusive trials and opportunities that are only available through our network.
          </li>
        </ul>
<div data-aos="fade-in" data-aos-delay="900" data-aos-duration="1500">
    <p class="mt-3 mb-2">
      <a href="registration.php" class="btn-1 mt-2">Ready to get Started?</a><br><br>
      <small>or <a href="contactus.php" style="color: black;">Contact Us</a> for more information</small>
    </p>
</div>

      </div>

      <div class="col-md-6 d-flex justify-content-center" data-aos="zoom-in" data-aos-duration="1000">
        <img  src="./img/women.png" alt="Cricket Illustration" class="img-fluid rounded" style="max-width: 100%; height: auto;">
      </div>

    </div>
  </div>
</section>

<section class="pro-club-section">
  <div class="container text-center">
    <h2 class="fw-bold display-6" data-aos="fade-up" data-aos-duration="1000">
      Seize Your Shot. Don't Miss Out!
    </h2>
    <p class="lead mt-4" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
      The clock is ticking! Hurry and register for trials before the dates are gone. <br>This is your moment to prove yourself and take the next step in your cricket journey.
    </p>
    <p class="mx-auto mt-3" style="max-width: 700px;" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
      The journey to greatness is paved with commitment and action. <br>Don't let this opportunity pass you by.<br> Your future in cricket starts with a single click.
    </p>
    <div class="mt-5" data-aos="zoom-in" data-aos-delay="500" data-aos-duration="1000">
      <a href="registration.php" class="btn btn-pro-club px-5 py-3 fw-bold">Register now and make your dream a reality!</a>
    </div>
    <div class="mt-4" data-aos="fade-in" data-aos-delay="600" data-aos-duration="1000">
      <small>Not sure? <a href="contactus.php" class="text-white-50">Contact our support team</a></small>
    </div>
  </div>
</section>

<section class="py-5 bg-light animated-section">
    <div class="container">
        <div class="row align-items-center g-4">

            <div class="col-md-6" 
                data-aos="fade-right" 
                data-aos-duration="1000" 
                data-aos-once="true">
                <h4 class="fw-bold mt-4 mb-2">More than just an app, Pro Cricket Trials is your partner in talent discovery.</h4>
                <h6 class="fw-bold mt-3 mb-2">Here's what makes us different:</h6>
                <p class="text-muted">
                    We specialize in helping young cricketers achieve their dreams by providing a clear, unbiased path to success. Our services are built on the principle of fair, data-driven selection, ensuring every player gets the chance they deserve.
                </p>
                <ul class="list-unstyled animated-list">
                    <li class="mb-2" data-aos="fade-right" data-aos-delay="100" data-aos-once="true">
                        <i class="bi bi-check-circle-fill me-2" style="color: #1a861a;"></i>We eliminate bias and favoritism with AI-generated performance reports, giving young players and selectors a clear, objective analysis of their skills.
                    </li>
                    <li class="mb-2" data-aos="fade-right" data-aos-delay="200" data-aos-once="true">
                        <i class="bi bi-check-circle-fill me-2" style="color: #1a861a;"></i>Our platform connects promising talent with clubs, associations, and coaches, all based on transparent data, not personal connections.
                    </li>
                    <li class="mb-2" data-aos="fade-right" data-aos-delay="300" data-aos-once="true">
                        <i class="bi bi-check-circle-fill me-2" style="color: #1a861a;"></i> We are more than just a trial organizer; we're a launchpad for the next generation of cricketing stars.
                    </li>
                </ul>
                <div data-aos="fade-in" data-aos-delay="400" data-aos-once="true">
                    <p class="mt-3 mb-2">
                        Ready to get started
                    </p>
                    <a href="contactus.php" class="btn-1 mt-2">Contact Us</a>
                </div>
            </div>

            <div class="col-md-6 d-flex justify-content-center">
                <div class="image-wrapper" data-aos="zoom-in" data-aos-duration="1000" data-aos-once="true">
                    <img src="./img/young.png" alt="Young cricket players taking a group photo" class="img-fluid rounded image-hover-effect">
                </div>
            </div>
            
        </div>
    </div>
</section>

<section class="py-5 bg-light text-center">
  <div class="container">
    <h2 class="fw-bold mb-3">Manage School, University & District Cricket</h2>
    <p class="mb-5 text-muted">
      Now players, parents, coaches and admins can track individual, team and even school performance<br>
      from one platform.
    </p>
    
    <div class="row justify-content-center">
      <div class="col-12 col-md-10">
        <img src="./img/2.png" alt="CricksLab Devices" class="img-fluid">
      </div>
    </div>
  </div>
</section>

<section class="py-5 bg-light">
  <div class="container">
    <div class="row text-center mb-5">
      <div class="col-md-6 col-lg-3 mb-4">
        <div class="card h-100 shadow-sm border-0 hover-card">
          <div class="card-body">
            <div class="icon-box mb-3">
              <i class="bi bi-puzzle" style="font-size: 2rem;"></i>
            </div>
            <h5 class="card-title">Students (the players)</h5>
            <p class="card-text">
              Never miss a score. Get all of your stats for every game you play at school-level. Plus share live scores, matches and results with friends and family!
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 mb-4">
        <div class="card h-100 shadow-sm border-0 hover-card">
          <div class="card-body">
            <div class="icon-box mb-3">
              <i class="bi bi-puzzle" style="font-size: 2rem;"></i>
            </div>
            <h5 class="card-title">Parents & Family (the fans)</h5>
            <p class="card-text">
              Never miss a wicket or a boundary from your kids' cricket matches. See games in real-time with live scores, see video replays from match days in case you couldn’t be there.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 mb-4">
        <div class="card h-100 shadow-sm border-0 hover-card">
          <div class="card-body">
            <div class="icon-box mb-3">
              <i class="bi bi-puzzle" style="font-size: 2rem;"></i>
            </div>
            <h5 class="card-title">Schools, Universities & Academies</h5>
            <p class="card-text">
              Manage leagues, tournaments, matches, teams and rosters. Present live scores on the school website or get a custom site where students can sign-up, register and play.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 mb-4">
        <div class="card h-100 shadow-sm border-0 hover-card">
          <div class="card-body">
            <div class="icon-box mb-3">
              <i class="bi bi-puzzle" style="font-size: 2rem;"></i>
            </div>
            <h5 class="card-title">Coaches, Talent Hunters</h5>
            <p class="card-text">
              See all the best talent from every school in your area, around the country or in the world. Get access to player and match data from all official school and university matches.
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="text-center py-5">
      <h4 class="fw-bold">Discover your next star player with ProCricketTrials.</h4>
      <p class="mb-4">
        Our talent hunter platform gives you instant access to detailed player stats and a powerful CRM,<br> making it easier than ever to search, contact, and recruit the best players.
      </p>
      <a href="/pro/registration.php" class="btn px-4 py-2 fw-semibold text-white" style="background-color: #1a861a;">REGISTER NOW</a>
    </div>
  </div>
</section>

<section class="text-white py-5" style="background: linear-gradient(135deg, #1a861a, #156d15);">
  <div class="container text-center">
    <h2 class="fw-bold mb-3">READY TO BE DISCOVERED?</h2>
    <p class="mb-4">
      Sign up for our next trial, get your performance analyzed, and connect with scouts and coaches who are looking for players just like you.
    </p>
    <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">
      <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" height="50"></a>
      <a href="#"><img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="App Store" height="50"></a>
    </div>
    <a href="register.php" class="btn btn-outline-light px-4 py-2">REGISTER FOR TRIALS</a>
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
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        // Global settings for AOS
        once: true, // Only animate elements once
    });
</script>

</body>
</html>