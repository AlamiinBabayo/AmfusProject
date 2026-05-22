<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Learn about Amfus Comprehensive Model School - Our history, mission, vision, values and commitment to excellence in education">
  <meta name="keywords" content="about amfus school, international school, education excellence, school history, mission vision">
  <title>About Us - Amfus Comprehensive Model School</title>
  <link rel="stylesheet" href="/CSS/main.css">
</head>

<style>
/* =========================================================
   ✅ SAME NAV SYSTEM: One desktop login dropdown + mobile login button
   ========================================================= */
:root{
  --highlight:#ff4b5c;
  --jobs:#4169e1;
  --bg:#fff;
  --text:#111;
  --accent:#0d0e0d;
  --dark-bg:#0b0c0d;
}

/* Reset */
*{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:system-ui,Arial,Helvetica,sans-serif;color:var(--text);line-height:1.6;margin:0}
img{max-width:100%;height:auto;display:block}

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
.logo{display:flex;align-items:center;gap:10px}
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

/* Desktop right buttons */
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

/* ✅ DESKTOP LOGIN = dropdown like About, but blue button */
.action-buttons .dropdown{ position:relative; }
.action-buttons .dropdown > .dropdown-toggle{
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
.action-buttons .dropdown > .dropdown-toggle:hover{
  background:#365dcf;
  transform:translateY(-1px);
}
.action-buttons .dropdown > .dropdown-toggle:focus,
.action-buttons .dropdown > .dropdown-toggle:focus-visible,
.action-buttons .dropdown > .dropdown-toggle:active{
  outline:none !important;
  box-shadow:none !important;
  border:none !important;
}
.action-buttons .dropdown > .dropdown-toggle::-moz-focus-inner{ border:0 !important; }
.action-buttons .dropdown-menu{ left:auto; right:0; } /* align right */

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
  .nav-links button.dropdown-toggle{
    width:100%;
    padding:12px 18px;
  }

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

  /* ✅ Mobile Login as BUTTON */
  .mobile-login-wrap{
    padding:10px 18px 6px;
    width:100%;
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

/* =========================================================
   Your page styles (kept)
   ========================================================= */
.container{max-width:1200px;margin:0 auto;padding:0 20px}

/* Buttons */
.btn-primary{background:#0c0c0c;color:#fff}
.btn-primary:hover{background:#0b0b0b;transform:translateY(-2px);box-shadow:0 5px 15px rgba(0,59,29,.4)}
.btn-secondary{background:transparent;color:#0b0b0b;border:2px solid #9b9c9b}
.btn-secondary:hover{background:#2c3e50;color:#fff;transform:translateY(-2px)}

/* Section titles */
.section-title{text-align:center;font-size:2.5rem;margin-bottom:1rem;color:#2c3e50;position:relative}
.section-title::after{content:'';display:block;width:60px;height:3px;background:linear-gradient(135deg,#626362,#313231);margin:15px auto}
.section-subtitle{text-align:center;font-size:1.1rem;color:#666;max-width:600px;margin:0 auto 3rem}
.section-header{margin-bottom:4rem}

/* ===== PAGE HEADER ===== */
.page-header{
  position:relative;
  background:#eef5fb;
  text-align:center;
  padding:100px 20px;
  overflow:hidden;
  opacity:0;
  transform:translateY(-50px);
  transition:opacity 1.2s ease-out, transform 1.2s ease-out;
}
.page-header.animate{opacity:1;transform:translateY(0)}
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

/* ===== SCHOOL OVERVIEW ===== */
.school-overview{padding:80px 0;background:#fff}
.overview-grid{display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center}
.overview-text{opacity:0;transform:translateX(-50px);transition:opacity 1s ease-out, transform 1s ease-out}
.overview-text.animate{opacity:1;transform:translateX(0)}
.overview-text h2{font-size:2.5rem;color:#050805;margin-bottom:2rem}
.overview-text p{font-size:1.1rem;line-height:1.8;color:#000;margin-bottom:1.5rem}
.overview-image{position:relative;border-radius:15px;overflow:hidden;box-shadow:0 20px 40px rgba(0,0,0,0.1);opacity:0;transform:translateX(50px);transition:opacity 1s ease-out, transform 1s ease-out}
.overview-image.animate{opacity:1;transform:translateX(0)}
.overview-image img{width:100%;height:400px;object-fit:cover}

/* ===== MISSION & VISION ===== */
.mission-vision{padding:80px 0;background:#e7e8ea;color:#0e0e0e}
.mission-vision-grid{display:grid;grid-template-columns:1fr 1fr;gap:40px}
.mission-vision-card{
  background:#fff;
  padding:40px;
  border-radius:15px;
  box-shadow:0 10px 30px rgba(0,0,0,0.1);
  text-align:center;
  transition:transform .3s ease;
  opacity:0;
  transform:scale(.8);
}
.mission-vision-card.animate{opacity:1;transform:scale(1)}
.mission-vision-card:hover{transform:translateY(-10px)}
.card-icon{font-size:3rem;margin-bottom:1.5rem}
.mission-vision-card h3{font-size:2rem;color:#000;margin-bottom:1.5rem}
.mission-vision-card p{font-size:1.1rem;line-height:1.8;color:#0d0e0d}

/* ===== CORE VALUES ===== */
.core-values{padding:80px 0;background:#fff}
.values-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:30px}
.value-card{
  background:#fff;
  padding:30px;
  border-radius:15px;
  box-shadow:0 5px 20px rgba(0,0,0,0.1);
  text-align:center;
  transition:all .3s ease;
  border-top:4px solid #000;
  opacity:0;
  transform:translateY(40px);
}
.value-card.animate{opacity:1;transform:translateY(0)}
.value-card:hover{transform:translateY(-5px);box-shadow:0 15px 30px rgba(0,0,0,0.15)}
.value-icon{font-size:2.5rem;margin-bottom:1rem}
.value-card h4{font-size:1.3rem;color:#2c3e50;margin-bottom:1rem}
.value-card p{color:#666;line-height:1.6}

/* ===== WHY CHOOSE US ===== */
.why-choose-us{padding:80px 0;background:#e2e2e2}
.features-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:40px}
.feature-item{
  display:flex;gap:20px;align-items:flex-start;
  padding:30px;background:#fff;border-radius:15px;
  box-shadow:0 5px 20px rgba(0,60,8,0.1);
  transition:transform .3s ease;
  opacity:0;transform:translateY(50px);
}
.feature-item.animate{opacity:1;transform:translateY(0)}
.feature-item:hover{transform:translateY(-5px)}
.feature-number{
  background:linear-gradient(135deg,#0d0d0d);
  color:#fff;width:60px;height:60px;border-radius:50%;
  display:flex;align-items:center;justify-content:center;
  font-weight:bold;font-size:1.2rem;flex-shrink:0;
}
.feature-item h4{font-size:1.3rem;color:#070707;margin-bottom:.5rem}
.feature-item p{color:#000;line-height:1.6}

/* ===== TEAM ===== */
.team-section{padding:60px 5%;background:#fff}
.team-grid{
  display:grid;
  grid-template-columns:repeat(3,260px);
  gap:50px;
  justify-content:center;
  align-items:start;
}
.team-card{
  background:rgba(0,0,0,0.08);
  border-radius:20px;
  padding:20px;
  text-align:center;
  backdrop-filter:blur(14px);
  -webkit-backdrop-filter:blur(14px);
  border:1px solid rgba(255,255,255,0.15);
  transition:transform .4s ease, box-shadow .4s ease, border .4s;
  width:260px;
  box-sizing:border-box;
  justify-self:center;
  opacity:0;
  transform:scale(.7);
}
.team-card.animate{opacity:1;transform:scale(1)}
.team-card:hover{transform:translateY(-12px) scale(1.03);box-shadow:0 15px 35px rgba(0,0,0,0.4);border:1px solid #090909}
.team-card img{width:100%;height:280px;border-radius:15px;object-fit:cover;object-position:top center;margin-bottom:15px}
.team-card h3{margin:10px 0 5px;font-size:20px;color:#000;font-style:italic}
.team-card p{margin:0 0 15px;color:#363738;font-style:italic}
.socials{display:flex;justify-content:center;gap:15px}
.socials a{color:#141414;font-size:18px;transition:color .3s, transform .3s}
.socials a:hover{color:#3e4853;transform:scale(1.2)}
@media (max-width:992px){.team-grid{grid-template-columns:repeat(2,260px)}}
@media (max-width:600px){.team-grid{grid-template-columns:repeat(1,260px)}}

.view-more-container{text-align:center;margin-top:30px;font-style:italic}
.view-more-btn{
  display:inline-block;
  padding:12px 28px;
  background:#333;
  color:#fff;
  font-size:16px;
  font-weight:500;
  border-radius:25px;
  text-decoration:none;
  transition:all .3s ease;
}
.view-more-btn:hover{background:#555;transform:translateY(-3px);box-shadow:0 6px 18px rgba(0,0,0,0.2)}

/* ===== CTA ===== */
.cta-section{
  padding:80px 0;
  background:linear-gradient(135deg,#8a9198,#5d6469);
  color:#fff;
  text-align:center;
  opacity:0;
  transform:translateY(50px);
  transition:opacity 1s ease-out, transform 1s ease-out;
}
.cta-section.animate{opacity:1;transform:translateY(0)}
.cta-content h2{font-size:2.5rem;margin-bottom:1.5rem}
.cta-content p{font-size:1.2rem;margin-bottom:2.5rem;max-width:600px;margin-left:auto;margin-right:auto;opacity:.9}
.cta-buttons{display:flex;gap:20px;justify-content:center}

/* Footer */
.footer{
  background:#7a8289;
  color:#ecf0f1;
  padding:50px 20px 20px;
  font-family:Arial,sans-serif;
  opacity:0;
  transform:translateY(60px);
  transition:opacity 1s ease-out, transform 1s ease-out;
}
.footer.animate{opacity:1;transform:translateY(0)}
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
.footer-col p,.footer-col a{
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
@media (max-width:992px){.footer-container{grid-template-columns:repeat(2,1fr)}}
@media (max-width:600px){.footer-container{grid-template-columns:1fr;text-align:center}.footer-col h3{border:none}}

/* Page responsive grids */
@media (max-width:768px){
  .overview-grid,.mission-vision-grid,.features-grid{grid-template-columns:1fr;gap:30px}
  .values-grid{grid-template-columns:repeat(2,1fr);gap:20px}
  .cta-buttons{flex-direction:column;align-items:center}
}
@media (max-width:480px){
  .container{padding:0 15px}
  .values-grid{grid-template-columns:1fr}
  .feature-item{flex-direction:column;text-align:center}
  .cta-content h2{font-size:2rem}
}
/* ✅ FINAL OVERRIDE: put this at the BOTTOM of the CSS (last lines) */
.team-section .team-grid{
  display:grid;
  grid-template-columns: repeat(3, 260px) !important;
  gap:50px !important;
  justify-content:center !important;
  align-items:start !important;
}

.team-section .team-card{
  width:260px !important;
  height:430px !important;   /* same card height */
  max-width:none !important;
  min-width:0 !important;

  display:flex !important;
  flex-direction:column !important;
  justify-content:flex-start !important;

  padding:20px !important;
  border-radius:20px !important;
  box-sizing:border-box !important;
}

.team-section .team-card img{
  width:100% !important;
  height:260px !important;   /* same image height */
  object-fit:cover !important;
  object-position:top center !important;
  border-radius:15px !important;
  margin-bottom:15px !important;
}

.team-section .team-card .socials{
  margin-top:auto !important; /* pushes socials to bottom */
}

@media (max-width:992px){
  .team-section .team-grid{ grid-template-columns: repeat(2, 260px) !important; }
}
@media (max-width:600px){
  .team-section .team-grid{ grid-template-columns: repeat(1, 260px) !important; }
}

</style>

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
        <button class="dropdown-toggle" type="button" style="font-style: italic; font-weight: bold;">
          About Us <span class="arrow">▾</span>
        </button>
        <ul class="dropdown-menu">
          <li><a href="about.php" class="active">Overview</a></li>
          <li><a href="team.php">Our Team</a></li>
        </ul>
      </li>

      <li><a href="gallery.php">Gallery</a></li>
      <li><a href="news.php">News</a></li>
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

      <!-- Mobile Apply -->
      <li class="mobile-actions" style="display:none;">
        <a class="btn btn-apply" href="/Amfus_Admission_Requirements (2).pdf">🎓 Apply</a>
      </li>
    </ul>

    <!-- ✅ DESKTOP: ONE LOGIN + APPLY -->
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

<!-- Page Header -->
<section class="page-header" style="font-style: italic; font-weight: bold;">
  <div class="page-header-content">
    <div class="breadcrumb">
      <a href="index.php">Home</a> &gt; <span>About Us</span>
    </div>
    <h1>About Us</h1>
    <p>Discover our journey, values, and commitment to excellence in education</p>
  </div>
  <div class="shape s1" aria-hidden="true"></div>
  <div class="shape s2" aria-hidden="true"></div>
</section>

<!-- School Overview -->
<section class="school-overview" style="font-style: italic; font-weight: bold;">
  <div class="container">
    <div class="overview-grid">
      <div class="overview-text">
        <h2>Our Story</h2>
        <p>Amfus Comprehensive Model School is dedicated to providing quality education built on discipline, knowledge, and good character. Since its establishment, the school has grown into a center of academic excellence where students are guided to reach their full potential.</p>
        <p>Guided by the motto <i>“Knowledge is Light,”</i> Amfus continues to inspire and equip students with the skills and values needed to succeed and make a positive impact in society.</p>
        <p>With a team of passionate teachers, modern facilities, and a supportive learning environment, Amfus remains committed to shaping confident, responsible, and future-ready students.</p>
      </div>
      <div class="overview-image">
        <img src="/IMAGES/graduation (1).jpg" alt="Amfus School Building">
      </div>
    </div>
  </div>
</section>

<!-- Mission & Vision -->
<section class="mission-vision" style="font-style: italic; font-weight: bold;">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Our Mission & Vision</h2>
      <p class="section-subtitle">Guiding principles that drive our commitment to educational excellence</p>
    </div>
    <div class="mission-vision-grid">
      <div class="mission-vision-card">
        <div class="card-icon">🎯</div>
        <h3>Our Mission</h3>
        <p>TO EFFECTIVELY IMPLEMENT THE NATIONAL CURRICULUM OF EDUCATION THROUGH DEPLOYMENT OF QUALIFIED TEACHING PERSONNEL AND OTHER RESOURCES IN A CONDUCIVE AND FRIENDLY LEARNING ENVIRONMENT.</p>
      </div>
      <div class="mission-vision-card">
        <div class="card-icon">🌟</div>
        <h3>Our Vision</h3>
        <p>EMPOWER STUDENTS TO ACQUIRE KNOWLEDGE, SKILLS AND MORAL DISCIPLINE THAT WILL ENABLE THEM PLAY KEY ROLES IN NATION BUILDING.</p>
      </div>
    </div>
  </div>
</section>

<!-- Core Values -->
<section class="core-values" style="font-style: italic; font-weight: bold;">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Our Core Values</h2>
      <p class="section-subtitle">The fundamental principles that shape our educational approach</p>
    </div>
    <div class="values-grid">
      <div class="value-card">
        <div class="value-icon">🎓</div>
        <h4>Academic Excellence</h4>
        <p>We maintain the highest standards of academic achievement through innovative teaching methods and rigorous curriculum.</p>
      </div>
      <div class="value-card">
        <div class="value-icon">🤝</div>
        <h4>Integrity</h4>
        <p>We foster honesty, transparency, and ethical behavior in all aspects of school life and learning.</p>
      </div>
      <div class="value-card">
        <div class="value-icon">🌍</div>
        <h4>Global Citizenship</h4>
        <p>We prepare students to be responsible global citizens who understand and respect cultural diversity.</p>
      </div>
      <div class="value-card">
        <div class="value-icon">🚀</div>
        <h4>Innovation</h4>
        <p>We embrace creativity and innovation in teaching, learning, and problem-solving approaches.</p>
      </div>
      <div class="value-card">
        <div class="value-icon">❤️</div>
        <h4>Care & Support</h4>
        <p>We provide a nurturing environment where every student feels valued, supported, and encouraged to grow.</p>
      </div>
      <div class="value-card">
        <div class="value-icon">🏆</div>
        <h4>Excellence</h4>
        <p>We strive for excellence in all endeavors, continuously improving and setting new standards.</p>
      </div>
    </div>
  </div>
</section>

<!-- Why Choose Us -->
<section class="why-choose-us" style="font-style: italic; font-weight: bold;">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title" style="color:#111;">Why Choose Amfus Comprehensive Model School?</h2>
      <p class="section-subtitle">Discover what makes us the preferred choice for quality education</p>
    </div>

    <div class="features-grid">
      <div class="feature-item">
        <div class="feature-number">01</div>
        <div>
          <h4>International Curriculum</h4>
          <p>We (offer) globally recognized curricula that prepare students for international universities and careers worldwide.</p>
        </div>
      </div>

      <div class="feature-item">
        <div class="feature-number">02</div>
        <div>
          <h4>Qualified Faculty</h4>
          <p>Our experienced teachers bring expertise and passion for education to every classroom.</p>
        </div>
      </div>

      <div class="feature-item">
        <div class="feature-number">03</div>
        <div>
          <h4>Small Class Sizes</h4>
          <p>With low student-to-teacher ratios, we ensure personalized attention for every student's unique needs.</p>
        </div>
      </div>

      <div class="feature-item">
        <div class="feature-number">04</div>
        <div>
          <h4>Modern Facilities</h4>
          <p>State-of-the-art classrooms, laboratories, library, and sports facilities support comprehensive learning.</p>
        </div>
      </div>

      <div class="feature-item">
        <div class="feature-number">05</div>
        <div>
          <h4>Holistic Development</h4>
          <p>We focus on developing the whole child - academically, socially, emotionally, and physically.</p>
        </div>
      </div>

      <div class="feature-item">
        <div class="feature-number">06</div>
        <div>
          <h4>Cultural Diversity</h4>
          <p>Our diverse student body creates a rich multicultural environment that prepares students for global citizenship.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Team -->
<section class="team-section">
  <h2 class="section-title" style="font-style: italic; color:#111;">Our Leadership Team</h2>
  <p class="section-subtitle" style="font-style: italic;">Meet the dedicated professionals leading our educational mission</p>

  <div class="team-grid">
    <div class="team-card">
      <img src="/IMAGES/propertor.png" alt="Proprietress">
      <h3>Dr. Sa'adatu Sani Hanga</h3>
      <p>Proprietress</p>
      <div class="socials">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>

    <div class="team-card">
      <img src="/IMAGES/sectertary.png" alt="Secretary">
      <h3>Mr Umar Farouk Yola</h3>
      <p>Secretary</p>
      <div class="socials">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>

    <div class="team-card">
      <img src="/IMAGES/vice principal 2.png" alt="Vice Principal">
      <h3>Mr Abubakar Bello</h3>
      <p>Vice Principal</p>
      <div class="socials">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>
  </div>

  <div class="view-more-container">
    <a href="team.php" class="view-more-btn">View More</a>
  </div>
</section>

<!-- CTA -->
<section class="cta-section" style="font-style: italic; font-weight: bold;">
  <div class="container">
    <div class="cta-content">
      <h2>Ready to Join Our Community?</h2>
      <p>Discover how Amfus Comprehensive Model School can provide your child with the foundation for lifelong success through quality education and character development.</p>
      <div class="cta-buttons">
        <a href="/Amfus_Admission_Requirements (2).pdf" class="btn btn-primary">Start Application</a>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="footer-container">
    <div class="footer-col">
      <h3>Contact Information</h3>
      <p><strong>Address:</strong><br>
        Amfus Comprehensive Model School<br>No. 1491/1492 Na’ibawa Gabas<br>Off Dan Hassan Road, Zaria Road, Kano, Nigeria</p>
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
/* ✅ NAV + DROPDOWNS (same behavior as your updated pages) */
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

/* ✅ Your page animations (unchanged behavior) */
document.addEventListener("DOMContentLoaded", () => {
  const sections = document.querySelectorAll(
    ".page-header, .overview-text, .overview-image, .mission-vision-card, .value-card, .feature-item, .team-card, .cta-section, .footer"
  );

  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate");
        obs.unobserve(entry.target);
      }
    });
  }, { threshold: 0.2 });

  sections.forEach((el) => observer.observe(el));
});
</script>

</body>
</html>
