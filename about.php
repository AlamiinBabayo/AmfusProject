<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Learn about Yandutse International School - Our history, mission, vision, values and commitment to excellence in education">
    <meta name="keywords" content="about yandutse school, international school, education excellence, school history, mission vision">
    <title>About Us - Amfus Comprehensive Model School</title>
    <link rel="stylesheet" href="/CSS/main.css">
</head>
<style>
  :root{
  --accent: #0d0e0d;  /* green tone */
  --dark-bg: #0b0c0d;
}

/* Global */
html { scroll-behavior: smooth; }
body { font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; color: #181818; margin:0; }

/* Topbar */
.topbar {
  background: var(--accent);
  color: #fff;
  font-size: 0.95rem;
}
.topbar .link-light { color: rgba(255,255,255,.95); text-decoration:none; }
.topbar .vr { opacity: .35; margin: 0 .5rem; }

/* About */
#about img { max-height: 420px; object-fit: cover; }

/* Mission cards */
.mission-card { border: 0; }
.mission-card .card-title { color: var(--accent); }

/* CTA cards */
.cta-card .icon-wrap { width:64px; height:64px; display:grid; place-items:center; border-radius:12px; background: rgba(15, 15, 15, 0.08); color:var(--accent); font-size:1.6rem; margin:auto; }

/* Gallery */
.gallery-grid img { height:160px; object-fit:cover; width:100%; display:block; border-radius:8px; transition: transform .25s ease, filter .25s ease; }
.gallery-grid a:hover img { transform: scale(1.03); filter:brightness(.95); }

/* Team */
.team-card { padding:20px; border-radius:12px; background:#fff; }
.team-card .staff-img { width:110px; height:110px; object-fit:cover; border:6px solid #fff; box-shadow: 0 6px 20px rgba(0,0,0,.08); }
.team-card h6 { margin-bottom: 5px; }
.team-card .socials a { color:var(--accent); }

/* Footer */
footer { background: #0f1416; color: #ddd; }
footer a { color: #ddd; text-decoration:none; }
footer a:hover { color: #fff; }

/* Small screens */
@media (max-width: 767.98px) {
  .hero-img { height: 50vh; }
  .carousel-caption { top: 18%; }
  .gallery-grid img { height:120px; }
  .team-card { padding:16px; }
}

/* Minor utilities */
.text-accent { color: var(--accent); }
.accent { background: var(--accent); color: #fff; }

/* ===== CSS RESET AND BASE STYLES ===== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #333;
}

img {
    max-width: 100%;
    height: auto;
    display: block;
}

/* ===== UTILITY CLASSES ===== */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.btn {
    display: inline-block;
    padding: 12px 30px;
    text-decoration: none;
    border-radius: 25px;
    transition: all 0.3s ease;
    font-weight: 600;
    text-align: center;
    font-size: 14px;
    cursor: pointer;
    border: none;
}

.btn-primary {
    background: #0c0c0c;
    color: white;
}

.btn-primary:hover {
    background: #0b0b0b;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 59, 29, 0.4);
}

.btn-secondary {
    background: transparent;
    color: #0b0b0b;
    border: 2px solid #9b9c9b;
}

.btn-secondary:hover {
    background: #2c3e50;
    color: white;
    transform: translateY(-2px);
}

.btn-apply {
    background: #e74c3c;
    color: white;
}

.btn-apply:hover {
    background: #c0392b;
    transform: translateY(-2px);
}

.btn-jobs {
    background: #3498db;
    color: white;
}

.btn-jobs:hover {
    background: #2980b9;
    transform: translateY(-2px);
}

.section-title {
    text-align: center;
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: #2c3e50;
    position: relative;
}

.section-title::after {
    content: '';
    display: block;
    width: 60px;
    height: 3px;
    background: linear-gradient(135deg, #626362, #313231);
    margin: 15px auto;
}

.section-subtitle {
    text-align: center;
    font-size: 1.1rem;
    color: #666;
    max-width: 600px;
    margin: 0 auto 3rem;
}

.section-header {
    margin-bottom: 4rem;
}


/* ===== SCHOOL OVERVIEW SECTION ===== */
.school-overview {
    padding: 80px 0;
    background: white;
}

.overview-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.overview-text h2 {
    font-size: 2.5rem;
    color: #050805;
    margin-bottom: 2rem;
}

.overview-text p {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #000000;
    margin-bottom: 1.5rem;
}

.overview-image {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.overview-image img {
    width: 100%;
    height: 400px;
    object-fit: cover;
}

/* ===== MISSION & VISION SECTION ===== */
.mission-vision {
    padding: 80px 0;
    background: #e7e8ea;
    color: #0e0e0e;
}

.mission-vision-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
}

.mission-vision-card {
    background: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease;
}

.mission-vision-card:hover {
    transform: translateY(-10px);
}

.card-icon {
    font-size: 3rem;
    margin-bottom: 1.5rem;
}

.mission-vision-card h3 {
    font-size: 2rem;
    color: #000000;
    margin-bottom: 1.5rem;
}

.mission-vision-card p {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #0d0e0d;
}

/* ===== CORE VALUES SECTION ===== */
.core-values {
    padding: 80px 0;
    background: white;
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.value-card {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: all 0.3s ease;
    border-top: 4px solid #000000;
}

.value-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
}

.value-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.value-card h4 {
    font-size: 1.3rem;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.value-card p {
    color: #666;
    line-height: 1.6;
}

/* ===== WHY CHOOSE US SECTION ===== */
.why-choose-us {
    padding: 80px 0;
    background: #e2e2e2;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 40px;
}

.feature-item {
    display: flex;
    gap: 20px;
    align-items: flex-start;
    padding: 30px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 60, 8, 0.1);
    transition: transform 0.3s ease;
}

.feature-item:hover {
    transform: translateY(-5px);
}

.feature-number {
    background: linear-gradient(135deg,  #0d0d0d);
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.feature-item h4 {
    font-size: 1.3rem;
    color: #070707;
    margin-bottom: 0.5rem;
}

.feature-item p {
    color: #000000;
    line-height: 1.6;
}

/* ===== LEADERSHIP TEAM SECTION ===== */
/* Team Grid */
    .team-section {
      padding: 60px 5%;
      background-color: #ffffff;
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
      color: #363738;
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
    display: flex;
    gap: 20px;
    justify-content: center;
}

.cta-buttons .btn-secondary {
    background: transparent;
    color: white;
    border: 2px solid white;
}

.cta-buttons .btn-primary:hover {
    background: white;
    color: #010101;
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

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 768px) {
    .top-header-content {
        flex-direction: column;
        gap: 15px;
    }

    .contact-info {
        flex-direction: column;
        gap: 10px;
    }

    .menu-toggle {
        display: block;
    }

    .nav-links {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background: white;
        flex-direction: column;
        padding: 20px 0;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .nav-links.active {
        display: flex;
    }

    .action-buttons {
        flex-direction: column;
        width: 100%;
        gap: 10px;
    }

    .page-header-content h1 {
        font-size: 2.5rem;
    }

    .section-title {
        font-size: 2rem;
    }

    .overview-grid,
    .mission-vision-grid,
    .team-grid,
    .features-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .values-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .stats-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .accreditation-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .team-member {
        flex-direction: column;
        text-align: center;
    }

    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }

    .footer-content {
        grid-template-columns: 1fr;
        gap: 30px;
    }
}

@media (max-width: 480px) {
    .container {
        padding: 0 15px;
    }

    .page-header-content h1 {
        font-size: 2rem;
    }

    .section-title {
        font-size: 1.8rem;
    }

    .values-grid,
    .stats-grid,
    .accreditation-grid {
        grid-template-columns: 1fr;
    }

    .feature-item {
        flex-direction: column;
        text-align: center;
    }

    .cta-content h2 {
        font-size: 2rem;
    }
}




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

/* ===== HERO (Page Header) ===== */
.page-header {
  opacity: 0;
  transform: translateY(-50px);
  transition: opacity 1.2s ease-out, transform 1.2s ease-out;
}
.page-header.animate {
  opacity: 1;
  transform: translateY(0);
}


/* ===== ABOUT / STORY ===== */
.overview-text {
  opacity: 0;
  transform: translateX(-50px);
  transition: opacity 1s ease-out, transform 1s ease-out;
}
.overview-text.animate {
  opacity: 1;
  transform: translateX(0);
}

.overview-image {
  opacity: 0;
  transform: translateX(50px);
  transition: opacity 1s ease-out, transform 1s ease-out;
}
.overview-image.animate {
  opacity: 1;
  transform: translateX(0);
}

/* ===== MISSION & VISION ===== */
.mission-vision-card {
  opacity: 0;
  transform: scale(0.8);
  transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}
.mission-vision-card.animate {
  opacity: 1;
  transform: scale(1);
}

/* ===== CORE VALUES ===== */
.value-card {
  opacity: 0;
  transform: translateY(40px);
  transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}
.value-card.animate {
  opacity: 1;
  transform: translateY(0);
}

/* ===== WHY CHOOSE US ===== */
.feature-item {
  opacity: 0;
  transform: translateY(50px);
  transition: opacity 1s ease-out, transform 1s ease-out;
}
.feature-item.animate {
  opacity: 1;
  transform: translateY(0);
}

/* ===== TEAM ===== */
.team-card {
  opacity: 0;
  transform: scale(0.7);
  transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}
.team-card.animate {
  opacity: 1;
  transform: scale(1);
}

/* ===== CTA ===== */
.cta-section {
  opacity: 0;
  transform: translateY(50px);
  transition: opacity 1s ease-out, transform 1s ease-out;
}
.cta-section.animate {
  opacity: 1;
  transform: translateY(0);
}

/* ===== FOOTER ===== */
.footer {
  opacity: 0;
  transform: translateY(60px);
  transition: opacity 1s ease-out, transform 1s ease-out;
}
.footer.animate {
  opacity: 1;
  transform: translateY(0);
}



</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
  const sections = document.querySelectorAll(
    ".page-header, .overview-text, .overview-image, .mission-vision-card, .value-card, .feature-item, .team-card, .cta-section, .footer"
  );

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("animate");
          observer.unobserve(entry.target); // Run once
        }
      });
    },
    { threshold: 0.2 }
  );

  sections.forEach((el) => observer.observe(el));
});

</script>
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
        <button class="dropdown-toggle" class="active" style="font-style: italic; font-weight: bold;">About Us <span class="arrow">▾</span></button>
        <ul class="dropdown-menu">
          <li><a href="about.php" class="active">Overview</a></li>
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

    <!-- Page Header -->
    <section class="page-header" style="font-style: italic; font-weight: bold;">
        <div class="page-header-content">
            <div class="breadcrumb">
                <a href="index.php">Home</a> &gt; <span>About Us</span>
            </div>
            <h1>About Us</h1>
            <p>Discover our journey, values, and commitment to excellence in education</p>
        </div>

        <!-- decorative shapes (optional) -->
        <div class="shape s1" aria-hidden="true"></div>
        <div class="shape s2" aria-hidden="true"></div>
    </section>

    <!-- School Overview Section -->
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
                    <img src="/ACMS_PROJECT/IMAGES/graduation (1).jpg" alt="Yandutse School Building">
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
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

    <!-- Core Values Section -->
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

    <!-- Why Choose Us Section -->
    <section class="why-choose-us" style="font-style: italic; font-weight: bold;">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" style="color: #111;">Why Choose Amfus Comprehensive Model School?</h2>
                <p class="section-subtitle">Discover what makes us the preferred choice for quality education</p>
            </div>
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-number">01</div>
                    <h4>International Curriculum</h4>
                    <p>We offer globally recognized curricula that prepare students for international universities and careers worldwide.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-number">02</div>
                    <h4>Qualified Faculty</h4>
                    <p>Our experienced teachers bring international expertise and passion for education to every classroom.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-number">03</div>
                    <h4>Small Class Sizes</h4>
                    <p>With low student-to-teacher ratios, we ensure personalized attention for every student's unique needs.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-number">04</div>
                    <h4>Modern Facilities</h4>
                    <p>State-of-the-art classrooms, laboratories, library, and sports facilities support comprehensive learning.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-number">05</div>
                    <h4>Holistic Development</h4>
                    <p>We focus on developing the whole child - academically, socially, emotionally, and physically.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-number">06</div>
                    <h4>Cultural Diversity</h4>
                    <p>Our diverse student body creates a rich multicultural environment that prepares students for global citizenship.</p>
                </div>
            </div>
        </div>
    </section>

             <!-- TEAM GRID -->
  <section class="team-section">
    <h2 class="section-title" style="font-style: italic; color: #111;">Our Leadership Team</h2>
    <p class="section-subtitle"style="font-style: italic;" >Meet the dedicated professionals leading our educational mission</p>
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
        </div>
    </section>


    <!-- Call to Action Section -->
    <section class="cta-section" style="font-style: italic; font-weight: bold;">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Join Our Community?</h2>
                <p>Discover how Amfus Comprehensive Model School can provide your child with the foundation for lifelong success through quality education and character development.</p>
                <div class="cta-buttons">
                    <a href="/ACMS_PROJECT/Amfus_Admission_Requirements (2).pdf" class="btn btn-primary">Start Application</a>
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
      <p><strong>Phone:</strong> +234 80 32834234</p>
      <p><strong>Email:</strong> amfuscomprehensive@gmail.com</p>
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


    <!-- JavaScript -->
 
</body>
</html>
