<?php

include('./includes/connect.php');


$sql = "SELECT id, full_name, position, profile_photo, facebook_url, twitter_url, linkedin_url 
        FROM team_members 
        WHERE is_active = 1 
        ORDER BY created_at DESC";

$result = mysqli_query($con, $sql);


if (!$result) {
    die("Database query failed: " . mysqli_error($con));
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Our Team - Amfus Comprehensive Model School</title>

<style>
:root{
  --highlight: #ff4b5c;
  --jobs: #4169e1;
  --bg: #fff;
  --text: #111;
}

*{box-sizing:border-box;margin:0;padding:0}
body{font-family:system-ui,Arial,Helvetica,sans-serif;color:var(--text);background:#fff;}

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
  .nav-links a, .nav-links button.dropdown-toggle{ font-size:15px }
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
  .page-header h1 { font-size: 28px; }
}

/* ===== TEAM SECTION ===== */
.team-section {
  padding: 60px 5%;
  background-color: #f5f5f5;
  min-height: 400px;
}

.team-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 260px));
  gap: 40px;
  justify-content: center;
  align-items: start;
  max-width: 1400px;
  margin: 0 auto;
}

.team-card {
  background: rgba(255, 255, 255, 0.95);
  border-radius: 20px;
  padding: 20px;
  text-align: center;
  backdrop-filter: blur(14px);
  -webkit-backdrop-filter: blur(14px);
  border: 1px solid rgba(0, 0, 0, 0.08);
  transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
  width: 260px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  /* Remove initial opacity for smooth load */
  opacity: 1;
  transform: translateY(0);
}

.team-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
  border: 1px solid rgba(9, 9, 9, 0.3);
}

.team-card img {
  width: 100%;
  height: 280px;
  border-radius: 15px;
  object-fit: cover;
  object-position: center;
  margin-bottom: 15px;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  display: block;
  /* Prevent image flash */
  image-rendering: -webkit-optimize-contrast;
}

.team-card h3 {
  margin: 10px 0 5px;
  font-size: 20px;
  color: #111;
  font-style: italic;
  font-weight: 700;
}

.team-card p {
  margin: 0 0 15px;
  color: #666;
  font-style: italic;
  font-size: 14px;
}

.socials {
  display: flex;
  justify-content: center;
  gap: 15px;
  margin-top: 15px;
}
.socials a {
  color: #333;
  font-size: 18px;
  transition: all 0.3s ease;
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  background: rgba(0, 0, 0, 0.05);
}
.socials a:hover {
  color: #fff;
  background: var(--highlight);
  transform: translateY(-3px);
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

/* Loading State */
.team-section.loading {
  min-height: 400px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.loading-spinner {
  width: 50px;
  height: 50px;
  border: 3px solid rgba(255, 75, 92, 0.3);
  border-top: 3px solid var(--highlight);
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

/* ===== FOOTER ===== */
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
  .team-grid {
    gap: 30px;
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
  .team-grid {
    grid-template-columns: 1fr;
    gap: 25px;
  }
  .team-card {
    max-width: 280px;
    margin: 0 auto;
  }
}

/* ===== ANIMATIONS ===== */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes slideUp {
  from { 
    opacity: 0; 
    transform: translateY(30px);
  }
  to { 
    opacity: 1; 
    transform: translateY(0);
  }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Stagger animation for team cards */
.team-card {
  animation: slideUp 0.6s ease-out forwards;
}

.team-card:nth-child(1) { animation-delay: 0.1s; }
.team-card:nth-child(2) { animation-delay: 0.2s; }
.team-card:nth-child(3) { animation-delay: 0.3s; }
.team-card:nth-child(4) { animation-delay: 0.4s; }
.team-card:nth-child(5) { animation-delay: 0.5s; }
.team-card:nth-child(6) { animation-delay: 0.6s; }
.team-card:nth-child(n+7) { animation-delay: 0.7s; }

.page-header {
  animation: fadeIn 0.8s ease-out forwards;
}

.footer {
  animation: fadeIn 1s ease-out forwards;
}
</style>

<!-- Font Awesome for social icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- Main Navigation -->
<header class="main-header" style="font-style: italic; font-weight: bold;">
  <nav class="navbar">
    <div class="logo">
      <img src="/ACMS_PROJECT/IMAGES/logo.png" alt="Amfus Logo">
      <span class="school-name">Amfus School</span>
    </div>

    <ul class="nav-links" id="navLinks">
      <li><a href="index.php">Home</a></li>
      <li class="dropdown">
        <button class="dropdown-toggle" style="font-style: italic; font-weight: bold;">About Us <span class="arrow">▾</span></button>
        <ul class="dropdown-menu">
          <li><a href="about.php">Overview</a></li>
          <li><a href="team.php" class="active">Our Team</a></li>
        </ul>
      </li>
      <li><a href="gallery.php">Gallery</a></li>
      <li><a href="news.php">News</a></li>
      <li><a href="contact.php">Contacts</a></li>
      <!-- Mobile Action Buttons -->
      <li class="mobile-actions" style="display:none;">
        <a class="btn btn-apply" href="/ACMS_PROJECT/Amfus_Admission_Requirements (2).pdf">🎓 Apply</a>
      </li>
    </ul>

    <!-- Desktop Action Buttons -->
    <div class="action-buttons">
      <a class="btn btn-apply" href="/ACMS_PROJECT/Amfus_Admission_Requirements (2).pdf">🎓 Apply Now</a>
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


<section class="page-header" style="font-style: italic; font-weight: bold;">
    <div class="page-header-content">
        <div class="breadcrumb">
            <a href="index.php">Home</a> &gt; <span>Team</span>
        </div>
        <h1>Our Team</h1>
        <p>Meet the dedicated professionals shaping future leaders</p>
    </div>
    <div class="shape s1" aria-hidden="true"></div>
    <div class="shape s2" aria-hidden="true"></div>
</section>


<section class="team-section">
  <?php if (mysqli_num_rows($result) > 0): ?>
    <div class="team-grid">
      <?php while ($member = mysqli_fetch_assoc($result)): 

        $imagePath = './admin/uploads/team/' . basename($member['profile_photo']);
        

        $defaultImage = 'https://via.placeholder.com/280x280/4169e1/ffffff?text=' . 
                       urlencode(substr($member['full_name'], 0, 1));
        
      
        if (!empty($member['profile_photo']) && file_exists($imagePath)) {
            $displayImage = $imagePath;
        } else {
            $displayImage = $defaultImage;
        }
      ?>
        <div class="team-card">
          <img 
            src="<?php echo htmlspecialchars($displayImage); ?>" 
            alt="<?php echo htmlspecialchars($member['full_name']); ?>"
            loading="lazy"
            onerror="this.src='<?php echo htmlspecialchars($defaultImage); ?>';">
          
          <h3><?php echo htmlspecialchars($member['full_name']); ?></h3>
          <p><?php echo htmlspecialchars($member['position']); ?></p>
          
          <?php if (!empty($member['facebook_url']) || !empty($member['twitter_url']) || !empty($member['linkedin_url'])): ?>
            <div class="socials">
              <?php if (!empty($member['facebook_url'])): ?>
                <a href="<?php echo htmlspecialchars($member['facebook_url']); ?>" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   aria-label="Facebook">
                  <i class="fab fa-facebook-f"></i>
                </a>
              <?php endif; ?>
              
              <?php if (!empty($member['twitter_url'])): ?>
                <a href="<?php echo htmlspecialchars($member['twitter_url']); ?>" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   aria-label="Twitter">
                  <i class="fab fa-twitter"></i>
                </a>
              <?php endif; ?>
              
              <?php if (!empty($member['linkedin_url'])): ?>
                <a href="<?php echo htmlspecialchars($member['linkedin_url']); ?>" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   aria-label="LinkedIn">
                  <i class="fab fa-linkedin-in"></i>
                </a>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="empty-message">
      <h3>No Team Members Yet</h3>
      <p>Our team information will be available soon. Please check back later.</p>
    </div>
  <?php endif; ?>
</section>


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
  <a href="https://github.com/AlamiinBabayo">  <p class="designer">Designed by <strong>Al-Amin Babayo </p></a>
  </div>
</footer>

</body>
</html>

<?php

mysqli_close($con);
?>