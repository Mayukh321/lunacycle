<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Luna Cycle</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<link rel="stylesheet" href="style.css">
</head>

<body>

<!-- NAVBAR -->

<nav class="navbar">
    <div class="navlogo">
        <img src="./logo.png" class="logo">
    </div>

 
<div class="navitems">
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Features</a></li>
        <li><a href="#">Contact</a></li>
    </ul>
</div>

<div class="navlog">
    <i class="fa-solid fa-circle-user"></i>
    <div class="dropdown">
        <a href="user_login.php">User Login</a>
        <a href="doctorlogin.php">Doctor Login</a>
    </div>
</div>
     

</nav>

<!-- HERO -->

<section class="hero">
    <img src="./home.jpg" class="hero-img">

     
<div class="hero-overlay"></div>

<div class="hero-content">
    <h1>Welcome to Luna Cycle</h1>
    <p>Track your cycle. Understand your body. Take control.</p>
    <button onclick="location.href='#cta'">Get Started</button>
</div>
     

</section>

<!-- FEATURES -->

<section class="features">
    <h2>Our Features</h2>

     
<div class="cards">

    <div class="card" data-aos="fade-right">
        <i class="fa-solid fa-calendar"></i>
        <h3>Period Tracking</h3>
        <p>Predict your cycle with smart tracking.</p>
    </div>

    <div class="card" data-aos="fade-up" data-aos-delay="100">
        <i class="fa-solid fa-heart-pulse"></i>
        <h3>Symptom Tracking</h3>
        <p>Monitor mood, cramps, and health.</p>
    </div>

    <div class="card" data-aos="fade-down" data-aos-delay="200">
        <i class="fa-solid fa-bell"></i>
        <h3>Reminders</h3>
        <p>Get timely notifications.</p>
    </div>

    <div class="card" data-aos="fade-left" data-aos-delay="300">
        <i class="fa-solid fa-chart-line"></i>
        <h3>Insights</h3>
        <p>AI-based personalized health insights.</p>
    </div>

    <div class="card" data-aos="flip-left" data-aos-delay="400">
        <i class="fa-solid fa-users"></i>
        <h3>Community</h3>
        <p>Connect and share experiences.</p>
    </div>

</div>
     

</section>

<!-- STATS -->

<section class="stats">
    <div class="stat">
        <h2>Smart AI</h2>
        <p>Personalized Predictions</p>
    </div>

     
<div class="stat">
    <h2>Secure</h2>
    <p>100% Private Data</p>
</div>

<div class="stat">
    <h2>24/7</h2>
    <p>Health Support</p>
</div>

<div class="stat">
    <h2>User Friendly</h2>
    <p>Simple & Clean UI</p>
</div>
     

</section>

<!-- CTA -->

<section class="cta" id="cta">
    <h2>Start Your Health Journey Today</h2>
    <button onclick="location.href='logoption.html'">Join Now</button>
</section>

<!-- FOOTER -->

<footer class="footer">
    <div class="footer-container">

     
    <div class="footer-section">
        <h2>Luna Cycle</h2>
        <p>Your personal companion for tracking cycles and wellness.</p>
    </div>

    <div class="footer-section">
        <h3>Links</h3>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Features</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </div>

    <div class="footer-section">
        <h3>Follow</h3>
        <div class="social-icons">
            <i class="fa-brands fa-facebook"></i>
            <i class="fa-brands fa-instagram"></i>
            <i class="fa-brands fa-twitter"></i>
        </div>
    </div>

</div>

<p class="copy">© 2026 Luna Cycle | All Rights Reserved</p>
     

</footer>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
AOS.init({
    duration: 1000,
    once: true
});
</script>

</body>
</html>
