<?php
include('./includes/connect.php'); 

if (isset($_POST['suggestion_submit'])) {

    $name  = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);
    $message_type = 'suggestion';

    if (empty($name) || empty($email) || empty($message)) {
        echo "<script>alert('Please fill all fields.'); window.history.back();</script>";
        exit();
    }

    $query = "INSERT INTO messages (name, email, message, message_type) 
              VALUES ('$name', '$email', '$message', '$message_type')";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo "<script>alert('Thank you! Your suggestion has been submitted successfully.'); window.location.href='suggestion.php';</script>";
    } else {
        echo "<script>alert('Error submitting your suggestion. Please try again later.'); window.history.back();</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Suggestion Box - Amfus Comprehensive Model School</title>

<style>
:root{
  --highlight:#ff4b5c;
  --jobs:#4169e1;
  --bg:#fff;
  --text:#111;
}

/* Reset */
*{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%}
body{
  font-family:system-ui,Arial,Helvetica,sans-serif;
  color:var(--text);
  background:var(--bg);
  -webkit-font-smoothing:antialiased;
  -moz-osx-font-smoothing:grayscale;
  line-height:1.5;
}

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
.logo{display:flex;align-items:center;gap:10px;}
.logo img{height:48px;width:auto;display:block}
.school-name{font-weight:700;font-size:20px;line-height:1;display:flex;align-items:center}

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

/* About dropdown */
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

@media (min-width:921px){
  .dropdown:hover > .dropdown-menu{ display:block }
}
.dropdown.open > .dropdown-menu{ display:block }
.arrow{transition:transform .25s}
.dropdown.open .arrow{ transform:rotate(180deg) }

/* ===== ACTION BUTTONS (DESKTOP RIGHT) ===== */
.action-buttons{display:flex;align-items:center;gap:12px}
.btn{
  padding:8px 16px;
  border-radius:8px;
  text-decoration:none;
  font-weight:600;
  color:#fff;
  display:inline-flex;
  align-items:center;
  gap:8px;
  transition:.3s ease;
}
.btn-apply{background:var(--highlight)}
.btn:hover{filter:brightness(.95);transform:translateY(-1px)}

/* âœ… DESKTOP LOGIN: behaves like About dropdown, but blue button */
.action-buttons .dropdown{ position:relative; }
.action-buttons .dropdown > .dropdown-toggle{
  background: var(--jobs);
  color:#fff;
  padding:10px 18px;
  border-radius:8px;
  font-weight:700;
  font-size:15px;
  border:0;
  outline:none;
  box-shadow:none;
}
.action-buttons .dropdown > .dropdown-toggle:hover{
  background:#365dcf;
  color:#fff;
  transform:translateY(-1px);
}
.action-buttons .dropdown > .dropdown-toggle:focus,
.action-buttons .dropdown > .dropdown-toggle:focus-visible,
.action-buttons .dropdown > .dropdown-toggle:active{
  outline:none !important;
  box-shadow:none !important;
  border:0 !important;
}
.action-buttons .dropdown > .dropdown-toggle::-moz-focus-inner{ border:0 !important; }
.action-buttons .dropdown-menu{ left:auto; right:0; } /* align menu to the right */

/* Hamburger */
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

  .mobile-actions{
    display:flex;
    gap:10px;
    justify-content:center;
    padding:12px 18px;
    width:100%;
  }
  .mobile-actions .btn{ flex:1; justify-content:center }

  /* âœ… Mobile Login button + stacked menu */
  .mobile-login-wrap{
    padding:10px 18px 6px;
    width:100%;
    display:block;
  }
  .mobile-login-wrap .login-btn{
    width:100%;
    justify-content:center;
    background: var(--jobs);
    color:#fff;
    border:none;
    padding:10px 18px;
    border-radius:8px;
    font-weight:700;
    font-size:15px;
    cursor:pointer;
    display:inline-flex;
    align-items:center;
    gap:6px;
    transition:.3s ease;
    outline:none;
    box-shadow:none;
  }
  .mobile-login-wrap .login-btn:hover{ background:#365dcf; transform:translateY(-1px); }
  .mobile-login-wrap .login-btn:focus,
  .mobile-login-wrap .login-btn:focus-visible,
  .mobile-login-wrap .login-btn:active{
    outline:none !important;
    box-shadow:none !important;
    border:none !important;
  }
  .mobile-login-wrap .login-btn::-moz-focus-inner{ border:0 !important; }

  .mobile-login-wrap .login-menu{
    position:static;
    width:100%;
    min-width:0;
    border-radius:10px;
    margin-top:10px;
    background:#fff;
    box-shadow:0 8px 18px rgba(0,0,0,0.10);
    padding:8px 0;
    list-style:none;
    display:none;
  }
  .mobile-login-wrap .login-menu a{
    display:block;
    padding:12px 18px;
    font-size:15px;
    color:#333;
    text-decoration:none;
  }
  .mobile-login-wrap .login-menu a:hover{ background:#f5f5f5; }
  .mobile-login-wrap .login-dropdown.open .login-menu{ display:block; }
}

/* Hide mobile login on desktop */
@media (min-width:921px){
  .mobile-login-wrap{ display:none; }
}

@media (max-width:420px){
  .school-name{
    display:block;
    font-size:20px;
    text-align:center;
    white-space:nowrap;
  }
  .nav-links a,
  .nav-links button.dropdown-toggle{ font-size:15px; }
}

/* ===== PAGE HEADER ===== */
.page-header{
  position:relative;
  background:#eef5fb;
  text-align:center;
  padding:100px 20px;
  overflow:hidden;
  opacity:0;
  animation: fadeDownScale 1s ease-out forwards;
}
.page-header::before{
  content:"Amfus";
  position:absolute;
  top:50%;
  left:50%;
  transform:translate(-50%,-50%);
  font-size:clamp(60px,15vw,180px);
  font-weight:900;
  color:rgba(11,23,38,0.06);
  white-space:nowrap;
  pointer-events:none;
  z-index:0;
}
.page-header-content{position:relative;z-index:2}
.breadcrumb{margin-bottom:15px;color:#666;font-size:15px}
.breadcrumb a{color:var(--highlight);text-decoration:none}
.page-header h1{font-size:40px;font-weight:800;color:#111;margin-bottom:8px}
.page-header p{font-size:18px;color:#444}
.page-header .shape{position:absolute;border-radius:50%;z-index:1;opacity:.9}
.page-header .shape.s1{width:140px;height:140px;bottom:10px;left:8%;background:linear-gradient(180deg,#f7e6cf,#f2dcc1)}
.page-header .shape.s2{width:220px;height:220px;top:12px;right:6%;background:linear-gradient(90deg,#dbeffa,#cfe6f6);clip-path:ellipse(85% 55% at 50% 50%);opacity:.7}
@media (max-width:768px){
  .page-header{padding:70px 15px}
  .page-header::before{top:48%}
  .page-header h1{font-size:28px}
  .page-header p{font-size:16px}
}
@keyframes fadeDownScale{
  from{opacity:0;transform:translateY(-60px) scale(.95)}
  to{opacity:1;transform:translateY(0) scale(1)}
}

/* ===== SUGGESTION BOX ===== */
.suggestion-box{
  max-width:650px;
  margin:70px auto;
  padding:55px 50px;
  background:#fff;
  border-radius:24px;
  box-shadow:0 20px 60px rgba(0,0,0,0.1);
  text-align:center;
  animation: fadeIn 0.9s ease forwards;
  transition: all 0.4s ease;
}
@keyframes fadeIn{
  from{opacity:0;transform:translateY(40px)}
  to{opacity:1;transform:translateY(0)}
}
.suggestion-box::before{
  content:"ðŸ’¬ Suggestion Box";
  display:block;
  font-size:28px;
  font-weight:700;
  margin-bottom:8px;
  color:#111;
  font-style:italic;
}
.suggestion-box::after{
  content:"Share your ideas to help us improve.";
  display:block;
  font-size:15px;
  color:#666;
  margin-bottom:35px;
  font-style:italic;
}
.suggestion-box form{
  display:flex;
  flex-direction:column;
  align-items:center;
  gap:20px;
}
.suggestion-box input,
.suggestion-box textarea{
  width:100%;
  padding:14px 16px;
  border:1.5px solid #d1d5db;
  border-radius:12px;
  font-size:15px;
  outline:none;
  background:#fafafa;
  font-style:italic;
  transition:all .3s ease;
}
.suggestion-box input:focus,
.suggestion-box textarea:focus{
  border-color:#4e4f50ff;
  background:#fff;
  box-shadow:0 0 10px rgba(59,130,246,0.15);
  transform:scale(1.01);
}
.suggestion-box textarea{min-height:130px;resize:none}

/* Keep your ash gradient button */
.suggestion-box button{
  background:linear-gradient(135deg,#1a1a1a,#666465);
  border:none;
  color:#fff;
  font-size:17px;
  font-weight:600;
  padding:14px;
  border-radius:12px;
  cursor:pointer;
  transition:.3s;
  width:100%;
  font-style:italic;
}
.suggestion-box button:hover{
  transform:translateY(-2px);
  background:linear-gradient(135deg,#666465,#1a1a1a);
}
@media (max-width:700px){
  .suggestion-box{padding:35px 25px;border-radius:18px}
  .suggestion-box::before{font-size:24px}
  .suggestion-box::after{font-size:14px;margin-bottom:25px}
}

/* ===== FOOTER ===== */
.footer{
  background:#7a8289;
  color:#ecf0f1;
  padding:50px 20px 20px;
  font-family: Arial, sans-serif;
  margin-top:60px;
}
.footer-container{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:30px;
  max-width:1200px;
  margin:auto;
}
.footer-col h3{
  font-size:18px;
  margin-bottom:15px;
  color:#fff;
  border-bottom:2px solid #585d5c;
  display:inline-block;
  padding-bottom:5px;
  font-style:italic;
}
.footer-col p, .footer-col a{
  font-size:14px;
  color:#fff;
  line-height:1.6;
  font-style:italic;
}
.footer-col a{text-decoration:none;transition:color .3s}
.footer-col a:hover{color:#222323}
.footer-col ul{list-style:none;padding:0}
.footer-col ul li{margin-bottom:8px}
hr{border:0;border-top:1px solid #2e2e2e;margin:30px 0 20px}
.footer-bottom{text-align:center;font-size:14px;line-height:1.6;font-style:italic}
.footer-bottom .designer{margin-top:10px;color:#070707;font-weight:bold}

@media (max-width:992px){
  .footer-container{grid-template-columns:repeat(2,1fr)}
}
@media (max-width:600px){
  .footer-container{grid-template-columns:1fr;text-align:center}
  .footer-col h3{border:none}
}
</style>
</head>

<body>

<header class="main-header" style="font-style: italic; font-weight: bold;">
  <nav class="navbar" aria-label="Main navigation">
    <div class="logo">
      <img src="/IMAGES/logo.png" alt="Amfus Logo">
      <span class="school-name">Amfus School</span>
    </div>

    <ul class="nav-links" id="navLinks">
      <li><a href="index.php">Home</a></li>

      <li class="dropdown">
        <button class="dropdown-toggle" style="font-style: italic; font-weight: bold;">
          About Us <span class="arrow">â–¾</span>
        </button>
        <ul class="dropdown-menu" aria-label="About submenu">
          <li><a href="about.php">Overview</a></li>
          <li><a href="team.php">Our Team</a></li>
        </ul>
      </li>

      <li><a href="gallery.php">Gallery</a></li>
      <li><a href="news.php">News</a></li>
      <li><a href="contact.php">Contacts</a></li>

      <!-- âœ… MOBILE LOGIN (BUTTON + STACKED MENU) -->
      <li class="mobile-login-wrap">
        <div class="login-dropdown" id="mobileLoginDropdown">
          <button class="login-btn" type="button">
            Login <span class="arrow">â–¾</span>
          </button>
          <ul class="login-menu">
            <li><a href="https://nersapp.com/s/amfus/auth/">Student Portal</a></li>
            <li><a href="https://amfuscomprehensivemodelschool.com.ng/admin/admin_login.php">Admin Dashboard</a></li>
          </ul>
        </div>
      </li>

      <!-- Mobile Action Buttons -->
      <li class="mobile-actions" style="display:none;">
        <a class="btn btn-apply" href="/Amfus_Admission_Requirements (2).pdf">ðŸŽ“ Apply</a>
      </li>
    </ul>

    <!-- âœ… DESKTOP: ONE LOGIN + APPLY -->
    <div class="action-buttons">
      <div class="dropdown" id="loginDropdown">
        <button class="dropdown-toggle" type="button">
          Login <span class="arrow">â–¾</span>
        </button>
        <ul class="dropdown-menu">
          <li><a href="https://nersapp.com/s/amfus/auth/">Student Portal</a></li>
          <li><a href="https://amfuscomprehensivemodelschool.com.ng/admin/admin_login.php">Admin Dashboard</a></li>
        </ul>
      </div>

      <a class="btn btn-apply" href="/Amfus_Admission_Requirements (2).pdf">ðŸŽ“ Apply Now</a>
    </div>

    <button id="menuToggle" class="menu-toggle" aria-label="Toggle menu" aria-expanded="false">â˜°</button>
  </nav>
</header>

<!-- Page Header -->
<section class="page-header" style="font-style: italic; font-weight: bold;">
  <div class="page-header-content">
    <div class="breadcrumb">
      <a href="index.php">Home</a> &gt; <span>Suggestion</span>
    </div>
    <h1>Suggestion Box</h1>
    <p>We would love to hear from you.</p>
  </div>
  <div class="shape s1" aria-hidden="true"></div>
  <div class="shape s2" aria-hidden="true"></div>
</section>

<!-- Suggestion Box -->
<div class="suggestion-box">
  <form action="" method="post">
    <input type="hidden" name="suggestion_submit" value="1">
    <input type="text" name="name" placeholder="Your Full Name" required>
    <input type="email" name="email" placeholder="Your Email Address" required>
    <textarea name="message" rows="5" placeholder="Your Suggestion" required></textarea>
    <button type="submit">Submit Suggestion</button>
  </form>
</div>

<!-- Footer -->
<footer class="footer">
  <div class="footer-container">
    <div class="footer-col">
      <h3>Contact Information</h3>
      <p><strong>Address:</strong><br>
       Amfus Comprehensive Model School<br>No. 1491/1492 Na'ibawa Gabas<br>Off Dan Hassan Road, Zaria Road, Kano, Nigeria</p>
      <p><strong>Phone:</strong> +234 80 32834234</p>
      <p><strong>Email:</strong> amfuscomprehensive@gmail.com</p>
    </div>

    <div class="footer-col">
      <h3>Quick Links</h3>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="gallery.php">Photo Gallery</a></li>
        <li><a href="news.php">School News</a></li>
        <li><a href="contact.php">Contact Us</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h3>School Hours</h3>
      <p><strong>Monday - Friday:</strong><br>7:30 AM â€“ 2:00 PM</p>
      <p><strong>Saturday:</strong><br>Closed</p>
      <p><strong>Sunday:</strong><br>Closed</p>
      <p><strong>Office Hours:</strong><br>8:00 AM â€“ 4:00 PM (Mon-Fri)</p>
    </div>

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

  <div class="footer-bottom">
    <p>Â© 2025 Amfus Comprehensive School. All rights reserved. | Quality Education for Future Leaders</p>
    <a href="https://github.com/AlamiinBabayo"><p class="designer">Designed by <strong>Al-Amin Babayo</strong></p></a>
  </div>
</footer>

<script>
(function(){
  const menuToggle = document.getElementById('menuToggle');
  const navLinks = document.getElementById('navLinks');
  const dropdowns = document.querySelectorAll('.nav-links .dropdown'); // About only
  const mobileActions = document.querySelectorAll('.mobile-actions');

  const mobileLoginDropdown = document.getElementById('mobileLoginDropdown');
  const desktopLoginDropdown = document.getElementById('loginDropdown');

  const isMobile = () => window.matchMedia('(max-width:920px)').matches;

  // Toggle main menu (mobile)
  menuToggle.addEventListener('click', e => {
    e.stopPropagation();
    const shown = navLinks.classList.toggle('show');
    menuToggle.setAttribute('aria-expanded', shown);
    mobileActions.forEach(el => el.style.display = (shown && isMobile()) ? 'flex' : 'none');

    if (isMobile() && mobileLoginDropdown) mobileLoginDropdown.classList.remove('open');
    if (isMobile() && desktopLoginDropdown) desktopLoginDropdown.classList.remove('open');
  });

  // About dropdown toggle (mobile only)
  dropdowns.forEach(drop => {
    const btn = drop.querySelector('.dropdown-toggle');
    if (!btn) return;
    btn.addEventListener('click', e => {
      if (!isMobile()) return;
      e.preventDefault();
      e.stopPropagation();
      drop.classList.toggle('open');
    });
  });

  // Mobile login toggle
  if (mobileLoginDropdown) {
    const btn = mobileLoginDropdown.querySelector('.login-btn');
    if (btn) {
      btn.addEventListener('click', e => {
        if (!isMobile()) return;
        e.preventDefault();
        e.stopPropagation();
        mobileLoginDropdown.classList.toggle('open');
      });
    }
  }

  // Desktop login toggle ONLY on mobile (desktop uses hover)
  if (desktopLoginDropdown) {
    const btn = desktopLoginDropdown.querySelector('.dropdown-toggle');
    if (btn) {
      btn.addEventListener('click', e => {
        if (!isMobile()) return;
        e.preventDefault();
        e.stopPropagation();
        desktopLoginDropdown.classList.toggle('open');
      });
    }
  }

  // Close menu after clicking a link (mobile)
  navLinks.querySelectorAll('a').forEach(a => {
    a.addEventListener('click', () => {
      if (isMobile()) {
        navLinks.classList.remove('show');
        menuToggle.setAttribute('aria-expanded','false');
        mobileActions.forEach(el => el.style.display = 'none');
        dropdowns.forEach(d => d.classList.remove('open'));
        if (mobileLoginDropdown) mobileLoginDropdown.classList.remove('open');
        if (desktopLoginDropdown) desktopLoginDropdown.classList.remove('open');
      }
    });
  });

  // Clicking outside closes everything (mobile)
  document.addEventListener('click', () => {
    if (!isMobile()) return;
    navLinks.classList.remove('show');
    menuToggle.setAttribute('aria-expanded','false');
    mobileActions.forEach(el => el.style.display = 'none');
    dropdowns.forEach(d => d.classList.remove('open'));
    if (mobileLoginDropdown) mobileLoginDropdown.classList.remove('open');
    if (desktopLoginDropdown) desktopLoginDropdown.classList.remove('open');
  });

  navLinks.addEventListener('click', e => e.stopPropagation());
  if (mobileLoginDropdown) mobileLoginDropdown.addEventListener('click', e => e.stopPropagation());
  if (desktopLoginDropdown) desktopLoginDropdown.addEventListener('click', e => e.stopPropagation());
})();
</script>

</body>
</html>
