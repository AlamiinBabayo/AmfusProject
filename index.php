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
<title>Amfus School</title>
<style>
  *{margin:0;padding:0;box-sizing:border-box}
  body{font-family: Arial, sans-serif;color:#fff;overflow-x:hidden}

  .hero{
    position:relative;
    width:100%;
    height:100vh; /* always fill the screen */
    overflow:hidden;
    background:#000;
  }

  .slide{
    position:absolute;
    inset:0;
    opacity:0;
    transition:opacity 1s ease-in-out;
  }
  .slide.active{
    opacity:1;
  }

  .slide img{
    width:100%;
    height:100%;
    object-fit:cover; /* fills the page fully */
    display:block;
  }

  .overlay{
    position:absolute;
    inset:0;
    background:rgba(0,0,0,0.35);
    z-index:1;
  }

  .content{
    position:absolute;
    top:50%;
    left:8%;
    transform:translateY(-50%);
    z-index:2;
    max-width:500px;
    text-align:left;
    color: #eee;
    font-style: italic;
  }
  .content h1{
    font-size:2.5rem;
    font-weight:900;
    margin-bottom:1rem;
    text-transform:uppercase;
     color: #eee;
    font-style: italic;
  }
  .content p{
    font-size:1.1rem;
    margin-bottom:1.5rem;
    line-height:1.6;
     color: #eee;
    font-style: italic;
  }

  /* Hero button */
  .btn-about{
    display:inline-block;
    padding:12px 22px;
    border:2px solid #ff4b5c;
    border-radius:10px;
    text-decoration:none;
    color:#fff;
    font-weight:600;
    transition:.3s ease;
  }
  .btn-about:hover{
    background:#ff4b5c;
    transform:translateY(-2px);
  }

  .dots{
    position:absolute;
    bottom:20px;
    left:8%;
    display:flex;
    gap:10px;
    z-index:3;
  }
  .dot{
    width:12px;height:12px;border-radius:50%;
    background:rgba(255,255,255,0.5);
    cursor:pointer;
    transition:.3s;
  }
  .dot.active{
    background:#fff;
    transform:scale(1.2);
  }

  @media(max-width:768px){
    .content h1{font-size:1.8rem}
    .content p{font-size:1rem}
  }

  /* Navbar container */
  :root{
    --highlight: #ff4b5c;
    --jobs: #4169e1;
    --bg: #fff;
    --text: #111;
  }

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

  /* Action Buttons */
  .btn{
    padding:8px 16px;
    border-radius:8px;
    text-decoration:none;
    font-weight:600;
    color:#fff;
    display:inline-flex;
    align-items:center;
    gap:8px;
    transition:0.3s ease;
  }
  .btn-apply{ background: var(--highlight); }
  .btn-jobs{ background: var(--jobs); }

  /* Hover effects for navbar buttons */
  .btn-apply:hover{
    background:#e04352;
    transform:translateY(-2px);
  }
  .btn-jobs:hover{
    background:#365dcf;
    transform:translateY(-2px);
  }

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

  /* ===== ABOUT SECTION ===== */
.about {
    padding: 100px 8%;
    background: #f9fafc;
}

.about .section-title {
    font-size: 2.5rem;
    font-weight: 800;
    text-align: center;
    color: #0a0a0a;
    margin-bottom: 60px;
    position: relative;
    font-style: italic;
}
.about .section-title::after {
    content: "";
    position: absolute;
    bottom: -12px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: #3b414e;
    border-radius: 2px;
}

.about-content {
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    gap: 60px;
    align-items: center;
}

.about-text h3 {
    font-size: 2rem;
    color: #000000;
    margin-bottom: 20px;
    font-style: italic;
}

.about-text p {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #353535;
    margin-bottom: 18px;
    font-style: italic;
}

.about-text p:last-child {
    margin-bottom: 0;
}

.about-text .btn{
    margin-top: 20px;
    color:#000000;
    border:2px solid #404f5b;
    display:inline-block;
    padding:12px 22px;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
    transition:.3s;
}
.about-text .btn:hover{
    background:#000000;
    color:#fff;
}

.about-image {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    background: #e8f4f8;
}

.about-image img {
    width: 100%;
    height: 130%;
    max-height: 450px;
    object-fit: cover;
    display: block;
    transition: transform 0.6s ease;
}
.about-image:hover img {
    transform: scale(1.05);
}

/* Responsive */
@media(max-width: 920px){
    .about-content {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    .about .section-title {
        font-size: 2rem;
    }
}

/* ===== MISSION & VISION SECTION ===== */
.mission-vision {
    padding: 100px 8%;
    background: linear-gradient(135deg, #e6e6e6);
    color: #0e0e0e;
    text-align: center;
}

.mission-vision .section-header {
    margin-bottom: 50px;
}

.mission-vision .section-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 10px;
    color: #000000;
    position: relative;
}
.mission-vision .section-title::after {
    content: "";
    position: absolute;
    bottom: -12px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: #060606;
    border-radius: 2px;
}
.mission-vision .section-subtitle {
    font-size: 1.1rem;
    color: #323e4b;
    margin-top: 20px;
}

.mission-vision-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
}

.mission-vision-card {
    background: #fff;
    padding: 40px 30px;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(44, 59, 67, 0.15);
    transition: all 0.3s ease;
    border-top: 6px solid #080808;
}
.mission-vision-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 58, 13, 0.25);
}

.card-icon {
    font-size: 3.2rem;
    margin-bottom: 20px;
    color: #000000;
}

.mission-vision-card h3 {
    font-size: 1.8rem;
    margin-bottom: 15px;
    color: #111;
}

.mission-vision-card p {
    font-size: 1.05rem;
    line-height: 1.8;
    color: #444;
}

/* Responsive */
@media(max-width: 920px){
    .mission-vision-grid {
        grid-template-columns: 1fr;
    }
    .mission-vision .section-title {
        font-size: 2rem;
    }
}
/* ===== GALLERY STYLING ===== */
.gallery {
  padding: 80px 4%;
  background: #ffffff;
  width: 100%;
}

.gallery .section-title {
  font-size: 2.5rem;
  font-weight: 800;
  text-align: center;
  margin-bottom: 20px;
  color: #0a0a0a;
  position: relative;
  font-style: italic;
}
.gallery .section-title::after {
  content: "";
  position: absolute;
  bottom: -12px;
  left: 50%;
  transform: translateX(-50%);
  width: 80px;
  height: 4px;
  background: #3b414e;
  border-radius: 2px;
  font-style: italic;
}

.gallery-grid {
  margin-top: 60px;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 25px;
  width: 100%;
}

.gallery-item {
  position: relative;
  border-radius: 15px;
  overflow: hidden;
  cursor: pointer;
  box-shadow: 0 8px 20px rgba(0,0,0,0.08);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  background: #fff;
}
.gallery-item:hover {
  transform: translateY(-6px) scale(1.02);
  box-shadow: 0 15px 35px rgba(0,0,0,0.15);
  font-style: italic;
}

.gallery-item img {
  width: 100%;
  height: 280px;
  object-fit: cover;
  display: block;
  transition: transform 0.5s ease;
}
.gallery-item:hover img {
  transform: scale(1.08);
}

.gallery-overlay {
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0, 0, 0, 0.55);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.4s ease;
}
.gallery-item:hover .gallery-overlay {
  opacity: 1;
}

.gallery-overlay span {
  color: #fff;
  font-size: 1.3rem;
  font-weight: 600;
  text-align: center;
  padding: 8px 16px;
  border-radius: 8px;
}

/* Responsive adjustments */
@media(max-width:768px){
  .gallery .section-title{font-size:2rem}
  .gallery-grid{gap:20px}
  .gallery-item img{height:240px}
}
@media(max-width:480px){
  .gallery .section-title{font-size:1.8rem}
  .gallery-item img{height:200px}
}
.lightbox {
  display: none;
  position: fixed;
  z-index: 2000;
  inset: 0;
  background: rgba(0, 0, 0, 0.9);
  align-items: center;
  justify-content: center;
}
.lightbox img {
  max-width: 90%;
  max-height: 80vh;
  border-radius: 8px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.5);
}
.lightbox .close,
.lightbox .prev,
.lightbox .next {
  position: absolute;
  top: 20px;
  font-size: 2rem;
  color: #fff;
  cursor: pointer;
  padding: 10px;
  border-radius: 50%;
  transition: 0.3s;
  user-select: none;
}
.lightbox .close {
  right: 20px;
}
.lightbox .prev {
  left: 20px;
  top: 50%;
  transform: translateY(-50%);
}
.lightbox .next {
  right: 20px;
  top: 50%;
  transform: translateY(-50%);
}
.lightbox .close:hover,
.lightbox .prev:hover,
.lightbox .next:hover {
  background: rgba(255, 255, 255, 0.2);
}
    /* Team Grid */
    .team-section {
      padding: 60px 5%;
      background-color: #d8d8d8;
    }

    .team-grid {
      display: grid;
      grid-template-columns: repeat(3, 260px); /* exactly 3 fixed columns */
      gap: 50px;
      justify-content: center;
      align-items: start;
    }

    .team-card {
      background: rgba(0, 0, 0, 0.08);
      border-radius: 20px;
      padding: 20px;
      text-align: center;
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
      border: 1px solid rgba(255, 255, 255, 0.15);
      transition: transform 0.4s ease, box-shadow 0.4s ease, border 0.4s;
      width: 260px; /* ✅ fixed width always */
      box-sizing: border-box;
      justify-self: center;
    }

    .team-card:hover {
      transform: translateY(-12px) scale(1.03);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
      border: 1px solid #090909;
    }

    .team-card img {
      width: 100%;
      height: 280px;
      border-radius: 15px;
      object-fit: cover;
      object-position: top center;
      margin-bottom: 15px;
    }

    .team-card h3 {
      margin: 10px 0 5px;
      font-size: 20px;
      color: #000000;
      font-style: italic;
    }

    .team-card p {
      margin: 0 0 15px;
      color: #2d3137;
      font-style: italic;
    }

    /* Social icons */
    .socials {
      display: flex;
      justify-content: center;
      gap: 15px;
    }
    .socials a {
      color: #141414;
      font-size: 18px;
      transition: color 0.3s, transform 0.3s;
    }
    .socials a:hover {
      color: #3e4853;
      transform: scale(1.2);
    }

   @media (max-width: 992px) {
  .team-grid {
    grid-template-columns: repeat(2, 260px);
  }
}

@media (max-width: 600px) {
  .team-grid {
    grid-template-columns: repeat(1, 260px);
  }
}

  /* Center Button */
.team-btn-container {
  text-align: center;
  margin-top: 40px;
}

.btn-view-more {
  display: inline-block;
  padding: 14px 36px;
  background: linear-gradient(135deg, #000000);
  color: #fff;
  font-weight: 700;
  font-size: 1.1rem;
  border-radius: 50px;
  text-decoration: none;
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4);
  transition: all 0.4s ease;
}

.btn-view-more:hover {
  background: linear-gradient(135deg, #394454);
  transform: translateY(-4px) scale(1.05);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.6);
}
/* Only Our Team Header */
.team-title {
  text-align: center;
  font-size: 40px;
  font-style: italic;
  font-weight: bold;
  color: #222;
  margin-bottom: 40px;
  position: relative;
}

.team-title::after {
  content: "";
  display: block;
  width: 80px;         /* underline length */
  height: 3px;         /* underline thickness */
  background: #333;    /* underline color */
  margin: 8px auto 0;  /* centers underline */
  border-radius: 2px;
}

.team-card {
  flex: 1 1 300px;   /* flex-grow, flex-shrink, base width */
  max-width: 300px;  /* keeps card size same on larger screens */
  min-width: 220px;  /* allows card to shrink slightly on very small screens */
  height: 420px;     /* fixed height */
}

.view-more-container {
  text-align: center;
  margin-top: 30px;
  font-style: italic;
}

.view-more-btn {
  display: inline-block;
  padding: 12px 28px;
  background: #333;
  color: #fff;
  font-size: 16px;
  font-weight: 500;
  border-radius: 25px;
  text-decoration: none;
  transition: all 0.3s ease;
}

.view-more-btn:hover {
  background: #555;
  transform: translateY(-3px);
  box-shadow: 0 6px 18px rgba(0,0,0,0.2);
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
  color: #ffffffff;
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

/* ===== ANIMATION HERO ===== */
@keyframes heroFadeLeft {
  0% {opacity:0; transform: translateX(-60px) scale(0.95);}
  100% {opacity:1; transform: translateX(0) scale(1);}
}
@keyframes heroFadeRight {
  0% {opacity:0; transform: translateX(60px) scale(0.95);}
  100% {opacity:1; transform: translateX(0) scale(1);}
}
@keyframes heroPulse {
  0%,100% {transform: scale(1);}
  50% {transform: scale(1.08);}
}

/* HERO elements */
.hero .content h1 {animation: heroFadeLeft 1.2s ease forwards; opacity:0;}
.hero .content p {animation: heroFadeRight 1.4s ease forwards; opacity:0; animation-delay:0.2s;}
.hero .btn-about {animation: heroPulse 1.5s ease infinite;}

/* ===== ABOUT ===== */
@keyframes aboutRise {
  0% {opacity:0; transform: translateY(60px);}
  100% {opacity:1; transform: translateY(0);}
}
.about-section, #about, .about {
  opacity:0;
  animation: aboutRise 1.3s ease forwards;
}

/* ===== MISSION & VISION ===== */
.mission-vision-card {
  opacity: 0;
  transform: translateY(30px);
  animation: missionFadeUp 1s ease-out forwards;
}

.mission-vision-card:nth-child(1) {
  animation-delay: 0.3s; /* Mission comes first */
}

.mission-vision-card:nth-child(2) {
  animation-delay: 0.3s; /* Vision comes after */
}

@keyframes missionFadeUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}




/* ===== GALLERY ===== */
@keyframes galleryFlip {
  0% {opacity:0; transform: scale(0.6) rotate(-8deg);}
  100% {opacity:1; transform: scale(1) rotate(0);}
}
.gallery-item {opacity:0; animation: galleryFlip 1s ease forwards;}
.gallery-item:nth-child(1){animation-delay:0.2s;}
.gallery-item:nth-child(2){animation-delay:0.4s;}
.gallery-item:nth-child(3){animation-delay:0.6s;}
.gallery-item:nth-child(4){animation-delay:0.8s;}

/* ===== TEAM ===== */
@keyframes teamPop {
  0% {opacity:0; transform: translateY(80px) scale(0.9);}
  100% {opacity:1; transform: translateY(0) scale(1);}
}
.team-card {opacity:0; animation: teamPop 0.6s ease forwards;}
.team-card:nth-child(1){animation-delay:0.2s;}
.team-card:nth-child(2){animation-delay:0.4s;}
.team-card:nth-child(3){animation-delay:0.6s;}
.team-card:nth-child(4){animation-delay:0.8s;}

/* ===== FOOTER ===== */
@keyframes footerUp {
  0% {opacity:0; transform: translateY(80px);}
  100% {opacity:1; transform: translateY(0);}
}
.footer {opacity:0; animation: footerUp 0.6s ease forwards;}

@keyframes typewriter {
  from {width: 0;}
  to {width: 100%;}
}
.footer p.reserved {
  display: inline-block;
  white-space: nowrap;
  overflow: hidden;
  border-right: 2px solid #fff;
  animation: typewriter 4s steps(40, end) 1s forwards;
}

</style>
</head>
<body>

<header class="main-header" style="font-style: italic; font-weight: bold;">
  <nav class="navbar">
    <!-- Logo -->
    <div class="logo">
      <img src="/ACMS_PROJECT/IMAGES/logo.png" alt="Amfus Logo">
      <span class="school-name">Amfus School</span>
    </div>

    <!-- Nav Links -->
    <ul class="nav-links" id="navLinks">
      <li><a href="index.php" class="active">Home</a></li>

      <li class="dropdown">
        <button class="dropdown-toggle"style="font-style: italic; font-weight: bold;">About Us <span class="arrow">▾</span></button>
        <ul class="dropdown-menu">
          <li><a href="about.php">Overview</a></li>
          <li><a href="team.php">Our Team</a></li>
        </ul>
      </li>

      <li><a href="gallery.php">Gallery</a></li>
      <li><a href="news.php">news</a></li>
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

<section class="hero">
  <div class="slide active">
    <img src="/ACMS_PROJECT/IMAGES/schoolview.png" alt="School">
     <div class="content">
    <h1>Welcome to Amfus Comprehensive Model School</h1>
<p>Dedicated to academic excellence and holistic development, Amfus Comprehensive School offers a rich blend of knowledge, creativity, and leadership skills to prepare students for a brighter future.</p>
    <a href="about.php" class="btn-about">Learn More About Us</a>
  </div>
  </div>
  <div class="slide">
    <img src="/ACMS_PROJECT/IMAGES/graduation (1).jpg" alt="School 2">
     <div class="content">
    <h1>Go Online</h1>
      <p>Find everything from Results, Important notices, and Fee Payment on our digital platform.
      Web Instructions
      App Instructions</p>
    <a href="https://nersapp.com/s/amfus/auth/" class="btn-about">Go To Students Portal</a>
  </div>
  </div>
  <div class="slide">
    <img src="/ACMS_PROJECT/IMAGES/playground.png" alt="Playground">
     <div class="content">
    <h1>Welcome to Amfus Comprehensive Model School</h1>
<p>School motto: knowledge is light.</p>
    <a href="gallery.php" class="btn-about">Visit Our Gallery</a>
  </div>
  </div>
  <div class="overlay"></div>
  <div class="dots"></div>
</section>

<script>
const slides=document.querySelectorAll('.slide');
const dotsContainer=document.querySelector('.dots');
let current=0;

slides.forEach((_,i)=>{
  const dot=document.createElement('div');
  dot.classList.add('dot');
  if(i===0) dot.classList.add('active');
  dot.addEventListener('click',()=>showSlide(i));
  dotsContainer.appendChild(dot);
});

function showSlide(i){
  slides[current].classList.remove('active');
  dotsContainer.children[current].classList.remove('active');
  current=i;
  slides[current].classList.add('active');
  dotsContainer.children[current].classList.add('active');
}

// Auto play
setInterval(()=>{
  let next=(current+1)%slides.length;
  showSlide(next);
},5000);
</script>

<!-- ABOUT -->
<section class="about" style="font-style: italic; font-weight: bold;">
  <h2 class="section-title">About Amfus School</h2>
  <div class="about-content">
    <div class="about-text">
      <h3>Excellence in Education</h3>
      <p>Amfus Comprehensive Model School is committed to nurturing young minds through holistic education. With a blend of tradition and innovation, we foster a learning environment that encourages curiosity, creativity, and critical thinking.</p>
      <p>Our dedicated faculty and modern facilities empower students to excel academically, socially, and personally, preparing them to meet the challenges of the future with confidence and integrity.</p>
      <a href="about.php" class="btn">Discover More</a>
    </div>
    <div class="about-image">
      <img src="/ACMS_PROJECT/IMAGES/playground.png" alt="About Amfus School">
    </div>
  </div>
</section>

<!-- MISSION & VISION -->
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
                <p>TO EFFECTIVELY IMPLEMENT THE NATIONAL CURRICULUM OF EDUCATION THROUGH DEPLOYMENT OF QUALIFIED TEACHING PERSONNEL AND OTHER RESOURCES IN A CONDUCIVE AND FRIENDLY LEARNING ENVIRONMENT.</p>
            </div>
            <div class="mission-vision-card">
                <div class="card-icon">🌟</div>
                <h3>Our Vision</h3>
                <p>EMPOWER STUDENTS TO ACQUIRE KNOWLEDGE, SKILLS AND MORAL DISCIPLINE THAT WILL ENABLE THEM PLAY KEY ROLES IN NATION BUILDING.</p>
            </div>
        </div>
    </div>
</section>
  <!-- GALLERY SECTION -->
<section class="gallery" id="gallery">
  <div class="container">
    <h2 class="section-title">School Gallery</h2>
    <div class="gallery-grid">
      <div class="gallery-item"><img src="/ACMS_PROJECT/IMAGES/graduation (1).jpg" alt="Campus Grounds"></div>
      <div class="gallery-item"><img src="/ACMS_PROJECT/IMAGES/excursion 1.webp" alt="Science Laboratory"></div>
      <div class="gallery-item"><img src="/ACMS_PROJECT/IMAGES/students 6.jpg" alt="Sports Facilities"></div>
      <div class="gallery-item"><img src="/ACMS_PROJECT/IMAGES/graduation 3.webp" alt="Sports Facilities"></div>
      <div class="gallery-item"><img src="/ACMS_PROJECT/IMAGES/excursion 3.webp" alt="Sports Facilities"></div>
      <div class="gallery-item"><img src="/ACMS_PROJECT/IMAGES/student.webp" alt="Sports Facilities"></div>
      <div class="gallery-item"><img src="/ACMS_PROJECT/IMAGES/graduation (2).jpg" alt="Sports Facilities"></div>
      <div class="gallery-item"><img src="/ACMS_PROJECT/IMAGES/excursion 2.webp" alt="Sports Facilities"></div>



      </div>
  </div>
</section>

<!-- LIGHTBOX -->
<div class="lightbox" id="lightbox">
  <span class="close" id="closeBtn">&times;</span>
  <span class="prev" id="prevBtn">&#10094;</span>
  <img id="lightboxImg" src="" alt="Expanded">
  <span class="next" id="nextBtn">&#10095;</span>
</div>
<script>
const galleryItems = document.querySelectorAll('.gallery-item img');
const lightbox = document.getElementById('lightbox');
const lightboxImg = document.getElementById('lightboxImg');
const closeBtn = document.getElementById('closeBtn');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
let currentIndex = 0;

function showImage(index) {
  currentIndex = index;
  lightboxImg.src = galleryItems[currentIndex].src;
  lightbox.style.display = 'flex';
}

galleryItems.forEach((img, i) => {
  img.addEventListener('click', () => showImage(i));
});

closeBtn.addEventListener('click', () => {
  lightbox.style.display = 'none';
});

prevBtn.addEventListener('click', () => {
  currentIndex = (currentIndex - 1 + galleryItems.length) % galleryItems.length;
  showImage(currentIndex);
});

nextBtn.addEventListener('click', () => {
  currentIndex = (currentIndex + 1) % galleryItems.length;
  showImage(currentIndex);
});

// Close lightbox on background click
lightbox.addEventListener('click', e => {
  if (e.target === lightbox) lightbox.style.display = 'none';
});
</script>

  <!-- TEAM GRID -->
  <section class="team-section">
     <h2 class="team-title">Our Team</h2>
    <div class="team-grid">
      
      <div class="team-card">
        <img src="/ACMS_PROJECT/IMAGES/propertor.png" alt="Principal">
        <h3>Dr. Sa'adatu Sani Hanga</h3>
        <p>Proprietress</p>
        <div class="socials">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>


      <div class="team-card">
        <img src="/ACMS_PROJECT/IMAGES/sectertary.png" alt="Admissions Officer">
        <h3>Mr Umar Farouk Yola</h3>
        <p>Secretary</p>
        <div class="socials">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>

            <div class="team-card">
        <img src="/ACMS_PROJECT/IMAGES/vice principal 2.png" alt="Academics Head">
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

  <!-- BEAUTIFUL RESPONSIVE FOOTER -->
<!-- Footer Section -->
<footer class="footer">
  <div class="footer-container">
    <!-- Contact Information -->
    <div class="footer-col">
      <h3>Contact Information</h3>
      <p><strong>Address:</strong><br>
        20 Yandutse Road<br>
        Kano, Kano State<br>
        Nigeria</p>
      <p><strong>Phone:</strong> 0909 999 0256</p>
      <p><strong>Email:</strong> info@ACMS-school.edu.ng</p>
    </div>

    <!-- Quick Links -->
    <div class="footer-col">
      <h3>Quick Links</h3>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="gallery.php">Photo Gallery</a></li>
        <li><a href="news.php">School news</a></li>
        <li><a href="contact.php">Contact Us</a></li>
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
document.addEventListener('DOMContentLoaded', () => {

  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const el = entry.target;

      // Special rule: footer should NOT have stagger
      if (el.classList.contains("footer")) {
        el.style.animationDelay = "0ms";
      } else {
        const siblings = el.parentNode ? Array.from(el.parentNode.children) : [];
        const index = siblings.indexOf(el);
        const delay = index >= 0 ? index * 150 : 0;
        el.style.animationDelay = delay + "ms";
      }

      el.style.animationPlayState = "running";
      obs.unobserve(el);
    });
  }, { threshold: 0.18 });

  const targets = document.querySelectorAll(
    ".about-section, #about, .about, \
     .mission-vision-card, .mission-card, #mission, .mission, \
     .vision-card, #vision, .vision, \
     .gallery-item, .team-card, \
     .footer"
  );

  targets.forEach(el => {
    el.style.animationPlayState = "paused";
    observer.observe(el);
  });

});
</script>


</body>
</html> 