<?php

include('./includes/connect.php');


$news_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($news_id <= 0) {
    header('Location: news.php');
    exit;
}


$sql = "SELECT id, title, category, author, publication_date, featured_image, content, views 
        FROM news 
        WHERE id = ? AND is_published = 1";

$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $news_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    header('Location: news.php');
    exit;
}

$news = mysqli_fetch_assoc($result);


$update_views = "UPDATE news SET views = views + 1 WHERE id = ?";
$update_stmt = mysqli_prepare($con, $update_views);
mysqli_stmt_bind_param($update_stmt, "i", $news_id);
mysqli_stmt_execute($update_stmt);


$date = date('F j, Y', strtotime($news['publication_date']));


$defaultImage = './IMAGES/sch.jpg';

$imagePath = './admin/uploads/news/' . basename($news['featured_image']);

if (!empty($news['featured_image']) && file_exists($imagePath)) {
    $displayImage = $imagePath;
} else {
    $displayImage = $defaultImage;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($news['title']); ?> | Amfus School</title>
<style>
:root{
  --highlight: #ff4b5c;
  --bg: #fff;
  --text: #111;
}

*{box-sizing:border-box;margin:0;padding:0}
body {
  font-family: system-ui, Arial, Helvetica, sans-serif;
  margin: 0;
  background: #f5f5f5;
  color: #333;
  line-height: 1.6;
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

@media (min-width:921px){
  .dropdown:hover > .dropdown-menu{ display:block }
}

.dropdown.open > .dropdown-menu{ display:block }
.arrow{transition:transform .25s}
.dropdown.open .arrow{ transform:rotate(180deg) }

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
.btn:hover{filter:brightness(.95)}

.menu-toggle{display:none;background:none;border:0;font-size:26px;cursor:pointer}

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

@media (max-width:420px){
  .school-name{ display:none }
}

/* ===== Hero Banner ===== */
.hero {
  position: relative;
  height: 320px;
  background: linear-gradient(135deg, #7a8289, #5a6269);
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  overflow: hidden;
}

.hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,144C960,149,1056,139,1152,128C1248,117,1344,107,1392,101.3L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
  background-size: cover;
}

.hero-content {
  position: relative;
  z-index: 2;
  color: #fff;
  max-width: 800px;
  padding: 0 20px;
}

.hero-content h1 {
  font-size: 38px;
  margin-bottom: 15px;
  letter-spacing: 0.5px;
  font-weight: 700;
  font-style: italic;
  line-height: 1.3;
}

.hero-content p {
  font-size: 15px;
  opacity: 0.95;
  font-style: italic;
}

/* ===== News Detail Card ===== */
.news-wrapper {
  position: relative;
  max-width: 900px;
  margin: -80px auto 60px;
  padding: 0 20px;
}

.news-detail-card {
  background: #fff;
  border-radius: 14px;
  padding: 40px;
  box-shadow: 0 6px 25px rgba(0,0,0,0.08);
  position: relative;
  overflow: hidden;
}

.category-badge {
  display: inline-block;
  padding: 6px 16px;
  background: var(--highlight);
  color: white;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  margin-bottom: 15px;
}

.news-detail-card img {
  width: 100%;
  border-radius: 12px;
  margin-bottom: 25px;
  max-height: 450px;
  object-fit: cover;
}

.meta {
  font-size: 14px;
  color: #777;
  margin-bottom: 20px;
  font-style: italic;
  padding-bottom: 15px;
  border-bottom: 1px solid #eee;
}

.news-detail-card h2 {
  font-size: 32px;
  margin-bottom: 20px;
  color: #222;
  line-height: 1.4;
  font-style: italic;
  font-weight: 800;
}

.news-content {
  font-size: 16px;
  line-height: 1.8;
  color: #444;
  font-style: italic;
}

.news-content p {
  margin-bottom: 20px;
}

.news-content h3 {
  font-size: 22px;
  margin: 30px 0 15px;
  color: #111;
  font-weight: 700;
}

.news-content ul, .news-content ol {
  margin: 15px 0 20px 30px;
}

.news-content li {
  margin-bottom: 10px;
}

.news-actions {
  margin-top: 30px;
  padding-top: 20px;
  border-top: 1px solid #eee;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 15px;
}

.back-link {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: #7a8289;
  color: #fff;
  padding: 12px 24px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 600;
  transition: 0.3s ease;
  box-shadow: 0 3px 8px rgba(0,0,0,0.1);
  font-style: italic;
}

.back-link:hover {
  background: #5a6269;
  transform: translateY(-2px);
  box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}

.share-buttons {
  display: flex;
  gap: 10px;
}

.share-btn {
  padding: 10px 15px;
  border-radius: 8px;
  text-decoration: none;
  color: #fff;
  font-size: 14px;
  transition: 0.3s ease;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

.share-btn.facebook { background: #3b5998; }
.share-btn.twitter { background: #1da1f2; }
.share-btn.whatsapp { background: #25d366; }

.share-btn:hover {
  transform: translateY(-2px);
  opacity: 0.9;
}

/* ===== Footer ===== */
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

/* ===== Responsive ===== */
@media (max-width: 992px) {
  .footer-container { 
    grid-template-columns: repeat(2, 1fr); 
  }
}

@media (max-width: 768px) {
  .hero {
    height: 250px;
    padding: 0 15px;
  }

  .hero-content h1 {
    font-size: 26px;
  }

  .hero-content p {
    font-size: 14px;
  }

  .news-detail-card {
    padding: 25px 20px;
    margin-top: -60px;
  }

  .news-detail-card h2 {
    font-size: 24px;
  }

  .news-content {
    font-size: 15px;
  }

  .news-actions {
    flex-direction: column;
    align-items: stretch;
  }

  .back-link, .share-buttons {
    width: 100%;
    justify-content: center;
  }
  
  .footer-container {
    grid-template-columns: 1fr;
    text-align: center;
  }
}

@media (max-width: 600px) {
  .share-buttons {
    flex-wrap: wrap;
  }
}

/* Animations */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.news-detail-card {
  animation: fadeIn 0.6s ease-out;
}
</style>
</head>
<body>

<!-- Main Navigation -->
<header class="main-header" style="font-style: italic; font-weight: bold;">
  <nav class="navbar">
    <div class="logo">
      <img src="/IMAGES/logo.jpg" alt="Amfus Logo">
      <span class="school-name">Amfus School</span>
    </div>

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
      <li><a href="news.php" class="active">News</a></li>
      <li><a href="contact.php">Contacts</a></li>
      <li class="mobile-actions" style="display:none;">
        <a class="btn btn-apply" href="apply.html">🎓 Apply</a>
      </li>
    </ul>

    <div class="action-buttons">
      <a class="btn btn-apply" href="apply.html">🎓 Apply Now</a>
    </div>

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

  menuToggle.addEventListener('click', e => {
    e.stopPropagation();
    const shown = navLinks.classList.toggle('show');
    menuToggle.setAttribute('aria-expanded', shown);
    mobileActions.forEach(el => el.style.display = (shown && isMobile()) ? 'flex' : 'none');
  });

  dropdowns.forEach(drop => {
    const btn = drop.querySelector('.dropdown-toggle');
    btn.addEventListener('click', e => {
      if (!isMobile()) return;
      e.preventDefault();
      e.stopPropagation();
      drop.classList.toggle('open');
    });
  });

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

<!-- Hero Section -->
<div class="hero">
  <div class="hero-content">
    <h1><?php echo htmlspecialchars($news['title']); ?></h1>
    <p>📅 <?php echo $date; ?> • ✍️ <?php echo htmlspecialchars($news['author']); ?></p>
  </div>
</div>

<!-- News Detail Card Section -->
<div class="news-wrapper">
  <div class="news-detail-card">
    <span class="category-badge"><?php echo htmlspecialchars($news['category']); ?></span>
    
    <div class="meta">
      By <?php echo htmlspecialchars($news['author']); ?> | <?php echo $date; ?> | 
      👁️ <?php echo number_format($news['views']); ?> views
    </div>
    
    <img src="<?php echo htmlspecialchars($displayImage); ?>" 
         alt="<?php echo htmlspecialchars($news['title']); ?>"
         onerror="this.src='<?php echo htmlspecialchars($defaultImage); ?>';">

    <h2><?php echo htmlspecialchars($news['title']); ?></h2>

    <div class="news-content">
      <?php echo nl2br(htmlspecialchars($news['content'])); ?>
    </div>

    <div class="news-actions">
      <a href="news.php" class="back-link">← Back to News</a>
      
      <div class="share-buttons">
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
           target="_blank" 
           class="share-btn facebook">
          📘 Share
        </a>
        <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($news['title']); ?>&url=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
           target="_blank" 
           class="share-btn twitter">
          🐦 Tweet
        </a>
        <a href="https://wa.me/?text=<?php echo urlencode($news['title'] . ' - http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
           target="_blank" 
           class="share-btn whatsapp">
          💬 WhatsApp
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="footer">
  <div class="footer-container">
    <div class="footer-col">
      <h3>Contact Information</h3>
      <p><strong>Address:</strong><br>
       Amfus Comprehensive Model School<br>No. 1491/1492 Na'ibawa Gabas<br>Off Dan Hassan Road, Zaria Road, Kano, Nigeria</p>
      <p><strong>Phone:</strong> 0909 999 0256</p>
      <p><strong>Email:</strong> info@ACMS-school.edu.ng</p>
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
    <p class="designer">Designed by <strong>Al-Amin Babayo</strong></p>
  </div>
</footer>

</body>
</html>

<?php
mysqli_close($con);
?>