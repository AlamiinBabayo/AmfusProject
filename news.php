<?php

include('./includes/connect.php');

$sql = "SELECT id, title, category, author, publication_date, featured_image, content, views
        FROM news
        WHERE is_published = 1
        ORDER BY publication_date DESC, created_at DESC";

$result = mysqli_query($con, $sql);

if (!$result) {
    die("Database query failed: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>School News - Amfus Comprehensive Model School</title>

<style>
:root{
  --highlight: #ff4b5c;
  --jobs: #4169e1;
  --bg: #fff;
  --text: #111;
}

*{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%}
body{
  font-family: system-ui, Arial, Helvetica, sans-serif;
  color:var(--text);
  background: var(--bg);
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

/* ✅ DESKTOP LOGIN: same dropdown behavior as About Us, but blue button */
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

/* right align login menu */
.action-buttons .dropdown-menu{ left:auto; right:0; }

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

  .dropdown-menu{
    position:static;
    box-shadow:none;
    border-radius:0;
    padding:0;
    margin:0;
    display:none;
  }
  .dropdown.open > .dropdown-menu{ display:block }
  .dropdown-menu a{ padding-left:30px }

  /* hide desktop action buttons */
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

  /* ✅ Mobile Login button + stacked menu */
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
  .nav-links button.dropdown-toggle { font-size: 15px; }
}

/* ===== PAGE HEADER ===== */
.page-header {
  position: relative;
  background: #eef5fb;
  text-align: center;
  padding: 100px 20px;
  overflow: hidden;
}
.page-header::before {
  content: "Amfus";
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: clamp(60px, 15vw, 180px);
  font-weight: 900;
  color: rgba(11,23,38,0.06);
  white-space: nowrap;
  pointer-events: none;
  z-index: 0;
}
.page-header-content { position: relative; z-index: 2; }
.breadcrumb { margin-bottom: 15px; color: #666; font-size: 15px; }
.breadcrumb a { color: var(--highlight); text-decoration: none; }
.page-header h1 { font-size: 40px; font-weight: 800; color: #111; margin-bottom: 8px; }
.page-header p { font-size: 18px; color: #444; }
.page-header .shape { position: absolute; border-radius: 50%; z-index: 1; opacity: .9; }
.page-header .shape.s1 { width: 140px; height: 140px; bottom: 10px; left: 8%; background: linear-gradient(180deg,#f7e6cf,#f2dcc1); }
.page-header .shape.s2 { width: 220px; height: 220px; top: 12px; right: 6%; background: linear-gradient(90deg,#dbeffa,#cfe6f6); clip-path: ellipse(85% 55% at 50% 50%); opacity: .7; }
@media (max-width:768px){
  .page-header { padding: 70px 15px; }
  .page-header h1 { font-size: 28px; }
  .page-header p { font-size: 16px; }
}

/* ===== NEWS SECTION ===== */
.news-container {
  max-width: 1200px;
  margin: 50px auto;
  padding: 0 20px;
}

.search-bar {
  max-width: 450px;
  margin: 0 auto 45px;
  position: relative;
}

.search-bar input {
  width: 100%;
  padding: 14px 20px;
  border-radius: 30px;
  border: 1px solid #ccc;
  outline: none;
  font-size: 15px;
  transition: 0.3s;
  font-style: italic;
}

.search-bar input:focus {
  border-color: var(--highlight);
  box-shadow: 0 0 6px rgba(255, 75, 92, 0.25);
}

.news-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 30px;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 15px;
}

.news-card {
  display: flex;
  flex-direction: column;
  background: #fff;
  border-radius: 14px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0,0,0,0.08);
  transition: all 0.4s ease;
  height: 100%;
  animation: slideUp 0.6s ease-out forwards;
}

.news-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 30px rgba(0,0,0,0.15);
}

.news-card img {
  width: 100%;
  height: 220px;
  object-fit: cover;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.news-card-content {
  padding: 25px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  flex-grow: 1;
}

.meta {
  font-size: 13px;
  color: #777;
  margin-bottom: 12px;
  font-style: italic;
}

.category-badge {
  display: inline-block;
  padding: 4px 12px;
  background: var(--highlight);
  color: white;
  border-radius: 12px;
  font-size: 11px;
  font-weight: 600;
  text-transform: uppercase;
  margin-bottom: 10px;
}

.news-card-content h3 {
  font-size: 20px;
  margin-bottom: 12px;
  line-height: 1.4;
  color: #111;
  font-style: italic;
  font-weight: 700;
}

.news-card-content p {
  flex-grow: 1;
  font-size: 15px;
  color: #555;
  margin-bottom: 15px;
  line-height: 1.6;
  font-style: italic;
}

.read-more {
  margin-top: 12px;
  align-self: flex-start;
  font-weight: 600;
  text-decoration: none;
  background: #7a8289;
  color: #fff;
  padding: 12px 24px;
  border-radius: 8px;
  transition: all 0.3s ease;
  font-style: italic;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.read-more:hover {
  transform: translateY(-2px);
  background: #5a6269;
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.empty-message {
  text-align: center;
  padding: 80px 20px;
  font-size: 18px;
  color: #666;
  font-style: italic;
  grid-column: 1 / -1;
}

.empty-message h3 {
  font-size: 24px;
  margin-bottom: 10px;
  color: var(--highlight);
}

/* ===== FOOTER ===== */
.footer {
  background: #7a8289;
  color: #ecf0f1;
  padding: 50px 20px 20px;
  margin-top: 60px;
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

.footer-col p, .footer-col a {
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

@media (max-width: 992px) {
  .footer-container { grid-template-columns: repeat(2, 1fr); }
  .news-grid { grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; }
}

@media (max-width: 768px) {
  .news-card img { height: 180px; }
  .news-card-content h3 { font-size: 18px; }
  .news-card-content p { font-size: 14px; }
}

@media (max-width: 600px) {
  .footer-container { grid-template-columns: 1fr; text-align: center; }
  .news-grid { grid-template-columns: 1fr; }
}

/* ===== ANIMATIONS ===== */
@keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@keyframes slideUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
.page-header { animation: fadeIn 0.8s ease-out forwards; }
.news-card:nth-child(1){animation-delay:0.1s;}
.news-card:nth-child(2){animation-delay:0.2s;}
.news-card:nth-child(3){animation-delay:0.3s;}
.news-card:nth-child(4){animation-delay:0.4s;}
.news-card:nth-child(5){animation-delay:0.5s;}
.news-card:nth-child(6){animation-delay:0.6s;}
.news-card:nth-child(n+7){animation-delay:0.7s;}
</style>
</head>
<body>

<header class="main-header" style="font-style: italic; font-weight: bold;">
  <nav class="navbar">
    <div class="logo">
      <img src="/IMAGES/logo.png" alt="Amfus Logo">
      <span class="school-name">Amfus School</span>
    </div>

    <ul class="nav-links" id="navLinks">
      <li><a href="index.php">Home</a></li>

      <li class="dropdown">
        <button class="dropdown-toggle" style="font-style: italic; font-weight: bold;">
          About Us <span class="arrow">▾</span>
        </button>
        <ul class="dropdown-menu">
          <li><a href="about.php">Overview</a></li>
          <li><a href="team.php">Our Team</a></li>
        </ul>
      </li>

      <li><a href="gallery.php">Gallery</a></li>
      <li><a href="news.php" class="active">News</a></li>
      <li><a href="contact.php">Contacts</a></li>

      <!-- ✅ MOBILE LOGIN (BUTTON + STACKED MENU) -->
      <li class="mobile-login-wrap">
        <div class="login-dropdown" id="mobileLoginDropdown">
          <button class="login-btn" type="button">
            Login <span class="arrow">▾</span>
          </button>
          <ul class="login-menu">
            <li><a href="https://nersapp.com/s/amfus/auth/">Student Portal</a></li>
            <li><a href="https://amfuscomprehensivemodelschool.com.ng/admin/admin_login.php">Admin Dashboard</a></li>
          </ul>
        </div>
      </li>

      <!-- Mobile Action Buttons -->
      <li class="mobile-actions" style="display:none;">
        <a class="btn btn-apply" href="/Amfus_Admission_Requirements (2).pdf">🎓 Apply</a>
      </li>
    </ul>

    <!-- ✅ DESKTOP: ONE LOGIN + APPLY (removed duplicate) -->
    <div class="action-buttons">
      <div class="dropdown" id="loginDropdown">
        <button class="dropdown-toggle" type="button">
          Login <span class="arrow">▾</span>
        </button>
        <ul class="dropdown-menu">
          <li><a href="https://nersapp.com/s/amfus/auth/">Student Portal</a></li>
          <li><a href="https://amfuscomprehensivemodelschool.com.ng/admin/admin_login.php">Admin Dashboard</a></li>
        </ul>
      </div>

      <a class="btn btn-apply" href="/Amfus_Admission_Requirements (2).pdf">🎓 Apply Now</a>
    </div>

    <button id="menuToggle" class="menu-toggle" aria-label="Toggle menu" aria-expanded="false">☰</button>
  </nav>
</header>

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

  // Desktop login toggle ONLY on mobile (desktop uses hover like About Us)
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

<!-- Page Header -->
<section class="page-header">
  <div class="page-header-content" style="font-weight: bold; font-style: italic;">
    <div class="breadcrumb">
      <a href="index.php">Home</a> › <span>News</span>
    </div>
    <h1>School News & Updates</h1>
    <p>Stay up-to-date with the latest happenings at Amfus School.</p>
  </div>
  <div class="shape s1"></div>
  <div class="shape s2"></div>
</section>

<!-- News Section -->
<div class="news-container">
  <div class="search-bar">
    <input type="text" id="searchNews" placeholder="Search news...">
  </div>

  <div class="news-grid">
    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while ($news = mysqli_fetch_assoc($result)):

        $imagePath = './admin/uploads/news/' . basename($news['featured_image']);
        $defaultImage = 'https://via.placeholder.com/400x220/4169e1/ffffff?text=Amfus+News';

        if (!empty($news['featured_image']) && file_exists($imagePath)) {
            $displayImage = $imagePath;
        } else {
            $displayImage = $defaultImage;
        }

        $excerpt = strip_tags($news['content']);
        $excerpt = substr($excerpt, 0, 150) . '...';

        $date = date('F j, Y', strtotime($news['publication_date']));
      ?>
        <div class="news-card"
             data-title="<?php echo htmlspecialchars($news['title']); ?>"
             data-content="<?php echo htmlspecialchars($excerpt); ?>">
          <img
            src="<?php echo htmlspecialchars($displayImage); ?>"
            alt="<?php echo htmlspecialchars($news['title']); ?>"
            loading="lazy"
            onerror="this.src='<?php echo htmlspecialchars($defaultImage); ?>';">

          <div class="news-card-content">
            <span class="category-badge"><?php echo htmlspecialchars($news['category']); ?></span>
            <div class="meta">
              📅 <?php echo $date; ?> •
              ✍️ <?php echo htmlspecialchars($news['author']); ?> •
              👁️ <?php echo number_format($news['views']); ?> views
            </div>
            <h3><?php echo htmlspecialchars($news['title']); ?></h3>
            <p><?php echo htmlspecialchars($excerpt); ?></p>
            <a href="news-detail.php?id=<?php echo $news['id']; ?>" class="read-more">
              Read More →
            </a>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="empty-message">
        <h3>No News Available</h3>
        <p>Check back soon for the latest updates and announcements.</p>
      </div>
    <?php endif; ?>
  </div>
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
      <p><strong>Monday - Friday:</strong><br>7:30 AM – 2:00 PM</p>
      <p><strong>Saturday:</strong><br>Closed</p>
      <p><strong>Sunday:</strong><br>Closed</p>
      <p><strong>Office Hours:</strong><br>8:00 AM – 4:00 PM (Mon-Fri)</p>
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
    <p>© 2025 Amfus Comprehensive School. All rights reserved. | Quality Education for Future Leaders</p>
  <a href="https://github.com/AlamiinBabayo"><p class="designer">Designed by <strong>Al-Amin Babayo</strong></p></a>
  </div>
</footer>

<script>
/* Search functionality */
const searchInput = document.getElementById('searchNews');
const newsCards = document.querySelectorAll('.news-card');

searchInput.addEventListener('keyup', function() {
  const searchText = this.value.toLowerCase();
  newsCards.forEach(card => {
    const title = (card.getAttribute('data-title') || '').toLowerCase();
    const content = (card.getAttribute('data-content') || '').toLowerCase();
    card.style.display = (title.includes(searchText) || content.includes(searchText)) ? 'flex' : 'none';
  });
});
</script>

</body>
</html>

<?php mysqli_close($con); ?>
