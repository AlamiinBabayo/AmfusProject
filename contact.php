<?php
include('./includes/connect.php'); 

if (isset($_POST['contact_submit'])) {
    
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    
    if (empty($name) || empty($email) || empty($message)) {
        echo "<script>alert('Please fill all the fields.'); window.history.back();</script>";
        exit();
    }

   
    $query = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo "<script>alert('Thank you for reaching out! Your message has been sent successfully.'); window.location.href='contact.php';</script>";
    } else {
        echo "<script>alert('Error submitting your message. Please try again later.'); window.history.back();</script>";
    }
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Learn about Yandutse International School - Our history, mission, vision, values and commitment to excellence in education">
    <meta name="keywords" content="about yandutse school, international school, education excellence, school history, mission vision">
    <title>Contact Us -  Amfus Comprehensive Model School</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="/CSS/main.css">
</head>
<style>
    /* Navbar container */
    :root{
  --highlight: #ff4b5c;
  --jobs: #4169e1;
  --bg: #fff;
  --text: #111;
}

/* Reset */
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:system-ui,Arial,Helvetica,sans-serif;color:var(--text);}

/* ===== NAVBAR ===== */
.main-header{
  position:sticky; top:0; z-index:1200;
  background:var(--bg);
  box-shadow:0 6px 18px rgba(0,0,0,0.06);
}

.navbar{
  display:flex;
  align-items:center;
  justify-content:space-between;
  padding:12px 5%;
  gap:20px;
}

/* Logo & School Name */
.logo{display:flex;align-items:center;gap:10px;}
.logo img{height:48px;width:auto;display:block}
.school-name{font-weight:700;font-size:20px;line-height:1;display:flex;align-items:center}

/* Nav Links */
.nav-links{
  display:flex;
  gap:20px;
  list-style:none;
  align-items:center;
  justify-content:center;
  flex:1;
}
.nav-links li{position:relative}
.nav-links a,
.nav-links button.dropdown-toggle{
  text-decoration:none;
  color:var(--text);
  font-weight:500;
  font-size:16px;
  background:none;
  border:0;
  cursor:pointer;
  padding:8px 10px;
  display:inline-flex;
  align-items:center;
  gap:5px;
}
.nav-links a.active,
.nav-links a:hover,
.nav-links button.dropdown-toggle:hover{ color:var(--highlight) }

/* Dropdown Menu */
.dropdown-menu{
  display:none;
  position:absolute;
  top:100%;
  left:0;
  min-width:220px;
  background:#fff;
  border-radius:6px;
  box-shadow:0 8px 18px rgba(0,0,0,0.1);
  padding:8px 0;
  z-index:1200;
}
.dropdown-menu li{list-style:none}
.dropdown-menu a{
  display:block;
  padding:10px 16px;
  font-size:15px;
  color:#333;
  text-decoration:none;
}
.dropdown-menu a:hover{background:#f9f9f9;color:var(--highlight)}

/* Desktop dropdown via hover */
@media (min-width:921px){
  .dropdown:hover > .dropdown-menu{ display:block }
}

/* Mobile dropdown via click */
.dropdown.open > .dropdown-menu{ display:block }
.arrow{transition:transform .25s}
.dropdown.open .arrow{ transform:rotate(180deg) }

/* Action Buttons (desktop) */
.action-buttons{display:flex;gap:12px}
.btn{
  padding:8px 16px;
  border-radius:8px;
  text-decoration:none;
  font-weight:600;
  color:#fff;
  display:inline-flex;
  align-items:center;
  gap:8px;
}
.btn-apply{background:var(--highlight)}
.btn-jobs{background:var(--jobs)}
.btn:hover{filter:brightness(.95)}

/* Hamburger (mobile) */
.menu-toggle{display:none;background:none;border:0;font-size:26px;cursor:pointer}

/* ===== MOBILE ===== */
@media (max-width:920px){
  .nav-links{
    display:none;
    flex-direction:column;
    background:#fff;
    position:absolute;
    top:64px;
    left:0;
    width:100%;
    padding:12px 0;
    border-top:1px solid #eee;
    gap:0;
  }
  .nav-links.show{ display:flex }
  .nav-links li{ width:100%; text-align:left }
  .nav-links a,
  .nav-links button.dropdown-toggle{ width:100%; padding:12px 18px; }
  .dropdown-menu{ position:static; box-shadow:none; border-radius:0; padding:0; margin:0; display:none }
  .dropdown.open > .dropdown-menu{ display:block }
  .dropdown-menu a{ padding-left:30px }
  .action-buttons{ display:none }
  .menu-toggle{ display:block }
  .mobile-actions{display:flex;gap:10px;justify-content:center;padding:12px 18px;width:100%}
  .mobile-actions .btn{ flex:1; justify-content:center }
}

/* Small screens */
@media (max-width:420px){
  .school-name{ display:none }
  .nav-links a, .nav-links button.dropdown-toggle{ font-size:15px }
}



/* ===== PAGE HEADER (HERO) with faded "Amfus" - replaced per request ===== */
.page-header {
    position: relative;
    background: #eef5fb;
    text-align: center;
    padding: 100px 20px;
    overflow: hidden;
}

/* Faded background word "Amfus" — responsive using clamp */
.page-header::before {
    content: "Amfus";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    /* scales between 60px and 180px depending on viewport */
    font-size: clamp(60px, 15vw, 180px);
    font-weight: 900;
    color: rgba(11,23,38,0.06);
    white-space: nowrap;
    pointer-events: none;
    z-index: 0;
}

.page-header-content {
    position: relative;
    z-index: 2;
}

.breadcrumb {
    margin-bottom: 15px;
    color: #666;
    font-size: 15px;
}
.breadcrumb a { color: var(--highlight); text-decoration: none; }

.page-header h1 {
    font-size: 40px;
    font-weight: 800;
    color: #111;
    margin-bottom: 8px;
}
.page-header p {
    font-size: 18px;
    color: #444;
}

/* decorative shapes (optional subtle circles similar to screenshot) */
.page-header .shape {
    position: absolute;
    border-radius: 50%;
    z-index: 1;
    opacity: .9;
}
.page-header .shape.s1 { width: 140px; height: 140px; bottom: 10px; left: 8%; background: linear-gradient(180deg,#f7e6cf,#f2dcc1); }
.page-header .shape.s2 { width: 220px; height: 220px; top: 12px; right: 6%; background: linear-gradient(90deg,#dbeffa,#cfe6f6); clip-path: ellipse(85% 55% at 50% 50%); opacity: .7; }

@media (max-width:768px){
  .page-header { padding: 70px 15px; }
  .page-header::before { top: 48%; } /* slightly adjust vertical position for small screens */
  .page-header h1 { font-size: 28px; }
  .page-header p { font-size: 16px; }
}
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background: #f4f6f8;
        color: #333;
    }

    h1, h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #ff4b5c;
    }

    .container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    /* Contact Info Cards */
    .cards {
        display: flex;
        gap: 20px;
        margin-bottom: 40px;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .card {
        flex: 1 1 30%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 220px;
        background: #fff;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        text-align: center;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .card i {
        font-size: 45px;
        color: #ff4b5c;
        margin-bottom: 15px;
        font-style: italic;

    }

    .card h3 {
        margin-bottom: 10px;
        color: #4169e1;
        font-style: italic;

    }

    .card p, .card a {
        font-size: 16px;
        line-height: 1.5;
        color: #333;
        text-decoration: none;
        font-style: italic;
    }

    /* Contact Form */
    .contact-form {
        background: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 0 auto 40px;
        transition: transform 0.3s;
        font-style: italic;
    }

    .contact-form:hover {
        transform: translateY(-5px);
    }

    .contact-form input,
    .contact-form textarea {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 20px;
        border: 2px solid #ddd;
        border-radius: 8px;
        transition: border-color 0.3s, box-shadow 0.3s;
        font-size: 16px;
        font-style: italic;
    }

    .contact-form input:focus,
    .contact-form textarea:focus {
        border-color: #ff4b5c;
        box-shadow: 0 0 10px rgba(255,75,92,0.3);
        outline: none;
    }

    .contact-form button {
        padding: 12px 25px;
        border: none;
        background: #ff4b5c;
        color: #fff;
        font-size: 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s, transform 0.3s;
        font-style: italic;
    }

    .contact-form button:hover {
        background: #e63c50;
        transform: scale(1.05);
    }

    /* Map */
    .map-container {
        width: 100%;
        height: 450px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        margin-bottom: 40px;
    }

    iframe {
        width: 100%;
        height: 100%;
        border: 0;
    }


/* ===== CALL TO ACTION SECTION ===== */
.cta-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #8a9198, #5d6469);
    color: white;
    text-align: center;
}

.cta-content h2 {
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
}

.cta-content p {
    font-size: 1.2rem;
    margin-bottom: 2.5rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    opacity: 0.9;
}

.cta-buttons {
  background: linear-gradient(135deg, #1a1a1a, #666465);
  color: #fff;
  border: none;
  font-size: 14px;
  font-weight: 500;
  padding: 8px 16px;        /* reduced height */
  border-radius: 8px;
  cursor: pointer;
  transition: 0.3s ease;
  width: 40%;               /* narrower width */
  max-width: 220px;         /* keeps it small */
  font-style: italic;
  display: block;
  margin: 0 auto;           /* centers button */
}

.cta-buttons:hover {
  background: linear-gradient(135deg, #666465, #1a1a1a);
  transform: translateY(-1px);
}


    /* Responsive */
    @media (max-width: 900px) {
        .cards {
            flex-direction: column;
            align-items: center;
        }

        .card {
            flex: 1 1 100%;
            width: 90%;
        }
    }
/*footer*/
/* Footer Styles */
.footer {
  background: #7a8289;
  color: #ecf0f1;
  padding: 50px 20px 20px;
  font-family: Arial, sans-serif;
}

.footer-container {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 30px;
  max-width: 1200px;
  margin: auto;
}

.footer-col h3 {
  font-size: 18px;
  margin-bottom: 15px;
  color: #fff;
  border-bottom: 2px solid #585d5c;
  display: inline-block;
  padding-bottom: 5px;
  font-style: italic;
}

.footer-col p, 
.footer-col a {
  font-size: 14px;
  color: #ffffff;
  line-height: 1.6;
  font-style: italic;
}

.footer-col a {
  text-decoration: none;
  transition: color 0.3s;
}

.footer-col a:hover {
  color: #222323;
}

.footer-col ul {
  list-style: none;
  padding: 0;
}

.footer-col ul li {
  margin-bottom: 8px;
}

hr {
  border: 0;
  border-top: 1px solid #2e2e2e;
  margin: 30px 0 20px;
}

.footer-bottom {
  text-align: center;
  font-size: 14px;
  line-height: 1.6;
  font-style: italic;
}

.footer-bottom .designer {
  margin-top: 10px;
  color: #070707;
  font-weight: bold;
}

/* Responsive */
@media (max-width: 992px) {
  .footer-container {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 600px) {
  .footer-container {
    grid-template-columns: 1fr;
    text-align: center;
  }
  .footer-col h3 {
    border: none;
  }
}

/* ===== HERO ===== */
.page-header {
  opacity: 0;
  transform: translateY(-50px);
  animation: fadeDown 1.2s ease forwards;
}
@keyframes fadeDown {
  0% {opacity:0; transform:translateY(-50px);}
  100% {opacity:1; transform:translateY(0);}
}

/* ===== CARDS ===== */
.card {
  opacity: 0;
  transform: translateY(60px);
}
.card.show {
  animation: popUp 1s ease forwards;
}
@keyframes popUp {
  0% {opacity:0; transform:translateY(60px);}
  100% {opacity:1; transform:translateY(0);}
}

/* ===== CONTACT FORM ===== */
.contact-form {
  opacity: 0;
  transform: translateX(-60px);
}
.contact-form.show {
  animation: slideInLeft 1s ease forwards;
}
@keyframes slideInLeft {
  0% {opacity:0; transform:translateX(-60px);}
  100% {opacity:1; transform:translateX(0);}
}

/* ===== MAP ===== */
.map-container {
  opacity: 0;
  transform: scale(0.8);
}
.map-container.show {
  animation: zoomIn 1s ease forwards;
}
@keyframes zoomIn {
  0% {opacity:0; transform:scale(0.8);}
  100% {opacity:1; transform:scale(1);}
}



/* ===== FOOTER ===== */
.footer {
  opacity: 0;
  transform: translateY(80px);
}
.footer.show {
  animation: slideUp 1.2s ease forwards;
}
@keyframes slideUp {
  0% {opacity:0; transform:translateY(80px);}
  100% {opacity:1; transform:translateY(0);}
}

</style>
<body>

     <!-- Main Navigation -->


<header class="main-header" style="font-style: italic; font-weight: bold;">
  <nav class="navbar">
    <!-- Logo -->
    <div class="logo">
      <img src="/ACMS_PROJECT/IMAGES/logo.png" alt="Amfus Logo">
      <span class="school-name">Amfus School</span>
    </div>

    <!-- Nav Links -->
    <ul class="nav-links" id="navLinks">
      <li><a href="index.php">Home</a></li>

      <li class="dropdown">
        <button class="dropdown-toggle" style="font-style: italic; font-weight: bold;">About Us <span class="arrow">▾</span></button>
        <ul class="dropdown-menu">
          <li><a href="about.php">Overview</a></li>
          <li><a href="team.php">Our Team</a></li>
        </ul>
      </li>


      <li><a href="gallery.php">Gallery</a></li>
      <li><a href="news.php">news</a></li>
      <li><a href="contact.php" class="active">Contacts</a></li>

      <!-- Mobile Action Buttons -->
      <li class="mobile-actions" style="display:none;">
        <a class="btn btn-apply" href="/ACMS_PROJECT/Amfus_Admission_Requirements (2).pdf">🎓 Apply</a>
      </li>
    </ul>

    <!-- Desktop Action Buttons -->
    <div class="action-buttons">
      <a class="btn btn-apply" href="/ACMS_PROJECT/Amfus_Admission_Requirements (2).pdf">🎓 Apply Now</a>
    </div>

    <!-- Hamburger -->
    <button id="menuToggle" class="menu-toggle" aria-label="Toggle menu" aria-expanded="false">☰</button>
  </nav>
</header>
 <script>
(function(){
  const menuToggle = document.getElementById('menuToggle');
  const navLinks = document.getElementById('navLinks');
  const dropdowns = document.querySelectorAll('.dropdown');
  const mobileActions = document.querySelectorAll('.mobile-actions');

  const isMobile = () => window.matchMedia('(max-width:920px)').matches;

  // Toggle main menu (mobile)
  menuToggle.addEventListener('click', e => {
    e.stopPropagation();
    const shown = navLinks.classList.toggle('show');
    menuToggle.setAttribute('aria-expanded', shown);
    mobileActions.forEach(el => el.style.display = (shown && isMobile()) ? 'flex' : 'none');
  });

  // Dropdown toggle (mobile only)
  dropdowns.forEach(drop => {
    const btn = drop.querySelector('.dropdown-toggle');
    btn.addEventListener('click', e => {
      if (!isMobile()) return; // desktop is handled by hover
      e.preventDefault();
      e.stopPropagation();
      drop.classList.toggle('open');
    });
  });

  // Close menu after clicking a link (mobile)
  navLinks.querySelectorAll('a').forEach(a => {
    a.addEventListener('click', () => {
      if (isMobile()) {
        navLinks.classList.remove('show');
        menuToggle.setAttribute('aria-expanded','false');
        mobileActions.forEach(el => el.style.display = 'none');
        dropdowns.forEach(d => d.classList.remove('open'));
      }
    });
  });

  // Clicking outside closes menu (mobile)
  document.addEventListener('click', () => {
    if (isMobile()) {
      navLinks.classList.remove('show');
      menuToggle.setAttribute('aria-expanded','false');
      mobileActions.forEach(el => el.style.display = 'none');
      dropdowns.forEach(d => d.classList.remove('open'));
    }
  });

  navLinks.addEventListener('click', e => e.stopPropagation());
})();
</script>

    <!-- Page Header -->
    <section class="page-header" style="font-style: italic; font-weight: bold;">
        <div class="page-header-content">
            <div class="breadcrumb">
                <a href="index.php">Home</a> &gt; <span>Contact Us</span>
            </div>
            <h1>Contact Us</h1>
        </div>

        <!-- decorative shapes (optional) -->
        <div class="shape s1" aria-hidden="true"></div>
        <div class="shape s2" aria-hidden="true"></div>
    </section>

<div class="container">

    <!-- Cards -->
    <div class="cards">
        <div class="card">
            <i class="fas fa-map-marker-alt"></i>
            <h3>Address</h3>
            <p>Amfus Comprehensive Model School<br>No. 1491/1492 Na’ibawa Gabas<br>Off Dan Hassan Road, Zaria Road, Kano, Nigeria</p>
        </div>
        <div class="card">
            <i class="fas fa-phone-alt"></i>
            <h3>Phone</h3>
            <p>+234 80 23715680 <br> +234 70 69009799 <br> +234 80 32834234</p>
        </div>
        <div class="card">
            <i class="fas fa-envelope"></i>
            <h3>Email</h3>
            <p><a href="mailto:amfuscomprehensive@gmail.com">amfuscomprehensive@gmail.com</a></p>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="contact-form">
        <h2>Send a Message</h2>
        <form id="contactForm" action="" method="post">
    <input type="hidden" name="contact_submit" value="1">
            <input type="text" name="name" placeholder="Your Full Name" required>
            <input type="email" name="email" placeholder="Your Email Address" required>
            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
            <button type="submit" name="contact">Send Message</button>
        </form>
    </div>

    <!-- Google Map -->
    <div class="map-container">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3925.929236774161!2d8.567980775912272!3d11.938704492104122!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x11b33e914d128f3b%3A0x95f0b2f2e3c64c36!2sAmfus%20Comprehensive%20Model%20School!5e0!3m2!1sen!2sng!4v1695000000000!5m2!1sen!2sng" 
            allowfullscreen="" 
            loading="lazy">
        </iframe>
    </div>
</div>

 <!-- Call to Action Section -->
    <section class="cta-section" style="font-style: italic; font-weight: bold;">
        <div class="container">
            <div class="cta-content">
                <h2 style="color: #070707;">Suggestion Box</h2>
                <p>Your opinions matter to us! We encourage students, parents, and staff to share their 
                  suggestions, ideas, or concerns. Together, we can make our school a better place for 
                  learning, growth, and success.</p>
                <div class="cta-buttons">
                    <a href="suggestion.php" class="btn btn-primary">Suggestion Box</a>
                </div>
            </div>
        </div>
    </section>
 <!-- Footer Section -->
<footer class="footer">
  <div class="footer-container">
    <!-- Contact Information -->
    <div class="footer-col">
      <h3>Contact Information</h3>
      <p><strong>Address:</strong><br>
       Amfus Comprehensive Model School<br>No. 1491/1492 Na’ibawa Gabas<br>Off Dan Hassan Road, Zaria Road, Kano, Nigeria</p>
      <p><strong>Phone:</strong> 0909 999 0256</p>
      <p><strong>Email:</strong> info@ACMS-school.edu.ng</p>
    </div>

    <!-- Quick Links -->
    <div class="footer-col">
      <h3>Quick Links</h3>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Photo Gallery</a></li>
        <li><a href="#">School news</a></li>
        <li><a href="#">Contact Us</a></li>
      </ul>
    </div>

    <!-- School Hours -->
    <div class="footer-col">
      <h3>School Hours</h3>
      <p><strong>Monday - Friday:</strong><br>7:30 AM – 2:00 PM</p>
      <p><strong>Saturday:</strong><br>Closed</p>
      <p><strong>Sunday:</strong><br>Closed</p>
      <p><strong>Office Hours:</strong><br>8:00 AM – 4:00 PM (Mon-Fri)</p>
    </div>

    <!-- Student Resources -->
    <div class="footer-col">
      <h3>Student Resources</h3>
      <ul>
        <li><a href="#">Library Access</a></li>
        <li><a href="#">Exam Results</a></li>
        <li><a href="#">Student Portal</a></li>
        <li><a href="#">E-Learning</a></li>
        <li><a href="#">Support Services</a></li>
      </ul>
    </div>
  </div>

  <hr>

  <!-- Bottom Footer -->
  <div class="footer-bottom">
    <p>© 2025 Amfus Comprehensive School. All rights reserved. | Quality Education for Future Leaders</p>
  <a href="https://github.com/AlamiinBabayo">  <p class="designer">Designed by <strong>Al-Amin Babayo </p></a>
  </div>
</footer>

<script>
  // Smooth animation trigger when elements enter viewport
const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add("show");
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.2 });

// Observe target sections
document.querySelectorAll(".card, .contact-form, .map-container, .footer")
  .forEach(el => observer.observe(el));

</script>
</body>
</html>