<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'amfus_school'; 
    private $username = 'root'; 
    private $password = ''; 
    private $con;
    
    public function connect() {
        $this->con = null;
        try {
            $this->con = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            error_log("Database Connection error: " . $e->getMessage());
            return false;
        }
        return $this->con;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_images') {
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    
    try {
        $database = new Database();
        $db = $database->connect();
        
        if (!$db) {
            throw new Exception('Database connection failed');
        }
        
     
        $category = isset($_GET['category']) ? trim($_GET['category']) : 'all';
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? min(50, max(1, (int)$_GET['limit'])) : 12;
        $offset = ($page - 1) * $limit;
        
       
        $whereClause = "WHERE is_active = 1";
        $params = [];
        
       
        if ($category !== 'all' && !empty($category)) {
            $whereClause .= " AND image_category = :category";
            $params[':category'] = $category;
        }
        
        
        $countQuery = "SELECT COUNT(*) as total FROM gallery " . $whereClause;
        $countStmt = $db->prepare($countQuery);
        $countStmt->execute($params);
        $totalRecords = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
        
     
        $query = "SELECT id, image_title, image_path, image_category, image_description, sort_order, created_at 
                  FROM gallery " . $whereClause . " 
                  ORDER BY sort_order ASC, created_at DESC 
                  LIMIT :limit OFFSET :offset";
        $stmt = $db->prepare($query);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
       
        $totalPages = ceil($totalRecords / $limit);
        
        echo json_encode([
            'success' => true,
            'images' => $images,
            'pagination' => [
                'current_page' => (int)$page,
                'total_pages' => (int)$totalPages,
                'total_records' => (int)$totalRecords,
                'per_page' => (int)$limit,
                'has_next' => $page < $totalPages,
                'has_prev' => $page > 1
            ]
        ]);
        
    } catch (Exception $e) {
        error_log("Gallery API Error: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_categories') {
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    
    try {
        $database = new Database();
        $db = $database->connect();
        
        if (!$db) {
            throw new Exception('Database connection failed');
        }
        
        $query = "SELECT DISTINCT image_category 
                  FROM gallery 
                  WHERE is_active = 1 
                    AND image_category IS NOT NULL 
                    AND image_category != '' 
                  ORDER BY image_category";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        echo json_encode([
            'success' => true,
            'categories' => $categories
        ]);
        
    } catch (Exception $e) {
        error_log("Categories API Error: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Gallery - Amfus Comprehensive Model School</title>

<style>
:root{
  --highlight: #ff4b5c;
  --jobs: #4169e1;
  --bg: #fff;
  --text: #111;
}

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

/* ===== GALLERY ===== */
.gallery {padding: 60px 5%;text-align: center;}
.filters {margin-bottom: 30px;display:flex;justify-content:center;flex-wrap:wrap;gap:12px;}
.filters button {
  padding: 10px 20px;
  border: 2px solid #333;
  background: transparent;
  color: #333;
  cursor: pointer;
  border-radius: 25px;
  transition: 0.3s;
  font-style: italic;
  font-weight: 600;
  text-transform: uppercase;
  font-size: 12px;
  letter-spacing: 1px;
}
.filters button:hover,.filters button.active {
  background: var(--highlight);
  color: #fff;
  border-color: var(--highlight);
  transform: translateY(-2px);
}

.gallery-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill,minmax(250px,1fr));
  gap: 20px;
}
.gallery-item {
  position: relative;
  overflow: hidden;
  border-radius: 8px;
  cursor: pointer;
  background: #f5f5f5;
  aspect-ratio: 4/3;
  opacity: 0;
  animation: fadeInUp 0.6s ease-out forwards;
}
.gallery-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform .3s;
}
.gallery-item:hover img {transform: scale(1.05);}

.gallery-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, rgba(255, 75, 92, 0.85), rgba(255, 75, 92, 0.95));
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.3s ease;
  padding: 20px;
  text-align: center;
}

.gallery-item:hover .gallery-overlay {
  opacity: 1;
}

.gallery-item-title {
  color: white;
  font-size: 16px;
  font-weight: bold;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin-bottom: 8px;
}

.gallery-item-category {
  color: white;
  font-size: 12px;
  opacity: 0.9;
  text-transform: uppercase;
  letter-spacing: 1px;
}

/* Loading & Messages */
.loading {
  grid-column: 1 / -1;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 200px;
}

.loading-spinner {
  width: 50px;
  height: 50px;
  border: 3px solid rgba(255, 75, 92, 0.3);
  border-top: 3px solid var(--highlight);
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

.no-results, .error-message {
  grid-column: 1 / -1;
  text-align: center;
  padding: 60px 20px;
}

.no-results h3, .error-message h3 {
  font-size: 24px;
  margin-bottom: 10px;
  color: var(--highlight);
}

/* Lightbox */
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
  top: 20px;
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

/* Footer */
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
}

/* Animations */
.page-header {
  opacity: 0;
  transform: translateY(-60px) scale(0.95);
  animation: heroFadeDown 1s ease-out forwards;
}
@keyframes heroFadeDown {
  from { opacity: 0; transform: translateY(-60px) scale(0.95); }
  to   { opacity: 1; transform: translateY(0) scale(1); }
}

@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(30px); }
  to   { opacity: 1; transform: translateY(0); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

@media(max-width:768px){
  .gallery-grid{gap:20px;grid-template-columns: repeat(auto-fill,minmax(220px,1fr));}
}
@media(max-width:480px){
  .gallery-grid{grid-template-columns: 1fr;}
}
</style>
</head>
<body>

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
          <li><a href="team.php">Our Team</a></li>
        </ul>
      </li>
      <li><a href="gallery.php" class="active">Gallery</a></li>
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

<section class="page-header" style="font-style: italic; font-weight: bold;">
    <div class="page-header-content">
        <div class="breadcrumb">
            <a href="index.php">Home</a> &gt; <span>Gallery</span>
        </div>
        <h1>Gallery</h1>
    </div>
    <div class="shape s1" aria-hidden="true"></div>
    <div class="shape s2" aria-hidden="true"></div>
</section>

<section class="gallery">
  <div class="filters" id="filterButtons">
    <button class="active" data-filter="all">ALL</button>
  </div>
  <div class="gallery-grid" id="galleryGrid">
    <div class="loading" id="loading">
      <div class="loading-spinner"></div>
    </div>
  </div>
  
  <div class="no-results" id="noResults" style="display: none;">
    <h3>No Images Found</h3>
    <p>No images available in this category yet. Please check back later.</p>
  </div>
  
  <div class="error-message" id="errorMessage" style="display: none;">
    <h3>Error Loading Images</h3>
    <p>Unable to load gallery images. Please try again later.</p>
  </div>
</section>

<div class="lightbox" id="lightbox">
  <span class="close" id="closeBtn">&times;</span>
  <span class="prev" id="prevBtn">&#10094;</span>
  <img id="lightboxImg" src="" alt="Expanded">
  <span class="next" id="nextBtn">&#10095;</span>
</div>

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
        <li><a href="news.php">School news</a></li>
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
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="gallery.php">Photo Gallery</a></li>
        <li><a href="news.php">School news</a></li>
        <li><a href="contact.php">Contact Us</a></li>
      </ul>
    </div>
  </div>

  <hr>

  <div class="footer-bottom">
    <p>© 2025 Amfus Comprehensive School. All rights reserved. | Quality Education for Future Leaders</p>
  <a href="https://github.com/AlamiinBabayo">  <p class="designer">Designed by <strong>Al-Amin Babayo </p></a>
  </div>
</footer>

<script>
// Navigation menu toggle
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

// Gallery Manager
class GalleryManager {
    constructor() {
        this.currentFilter = 'all';
        this.isLoading = false;
        this.allImages = [];
        this.currentLightboxIndex = 0;
        
        this.galleryGrid = document.getElementById('galleryGrid');
        this.filterButtons = document.getElementById('filterButtons');
        this.loading = document.getElementById('loading');
        this.noResults = document.getElementById('noResults');
        this.errorMessage = document.getElementById('errorMessage');
        this.lightbox = document.getElementById('lightbox');
        this.lightboxImg = document.getElementById('lightboxImg');
        this.closeBtn = document.getElementById('closeBtn');
        this.prevBtn = document.getElementById('prevBtn');
        this.nextBtn = document.getElementById('nextBtn');
        
        this.init();
    }
    
    async init() {
        await this.loadCategories();
        await this.loadImages();
        this.setupEventListeners();
    }
    
    async loadCategories() {
        try {
            const url = new URL(window.location.href);
            url.search = '';
            url.searchParams.set('action', 'get_categories');
            
            const response = await fetch(url.toString());
            const data = await response.json();
            
            if (data.success && data.categories && data.categories.length > 0) {
                this.renderFilterButtons(data.categories);
            }
        } catch (error) {
            console.error('Error loading categories:', error);
        }
    }
    
    renderFilterButtons(categories) {
        let buttonsHTML = '<button class="active" data-filter="all">ALL</button>';
        
        categories.forEach(category => {
            if (category && category.trim()) {
                const displayName = category.toUpperCase();
                buttonsHTML += `<button data-filter="${this.escapeHtml(category)}">${displayName}</button>`;
            }
        });
        
        this.filterButtons.innerHTML = buttonsHTML;
        
        this.filterButtons.querySelectorAll('button').forEach(button => {
            button.addEventListener('click', (e) => this.handleFilterClick(e));
        });
    }
    
    async loadImages() {
        if (this.isLoading) return;
        
        this.isLoading = true;
        this.showLoading();
        
        try {
            const url = new URL(window.location.href);
            url.search = '';
            url.searchParams.set('action', 'get_images');
            url.searchParams.set('category', this.currentFilter);
            url.searchParams.set('limit', '100');
            
            const response = await fetch(url.toString());
            const data = await response.json();
            
            if (data.success) {
                this.hideMessages();
                if (data.images && data.images.length > 0) {
                    this.allImages = data.images;
                    this.renderImages(data.images);
                } else {
                    this.showNoResults();
                }
            } else {
                this.showError(data.error || 'Failed to load images');
            }
        } catch (error) {
            console.error('Error loading images:', error);
            this.showError('Failed to load images. Please check your database connection.');
        } finally {
            this.isLoading = false;
        }
    }
    
    renderImages(images) {
        this.galleryGrid.innerHTML = '';
        
        if (!images || images.length === 0) {
            this.showNoResults();
            return;
        }
        
        images.forEach((image, index) => {
            const galleryItem = this.createGalleryItem(image, index);
            galleryItem.style.animationDelay = `${index * 0.1}s`;
            this.galleryGrid.appendChild(galleryItem);
        });
    }
    
    createGalleryItem(image, index) {
        const div = document.createElement('div');
        div.className = 'gallery-item';
        
        const imgSrc = this.getImagePath(image.image_path);
        const altText = image.image_alt_text || image.image_title || 'Gallery image';
        const title = image.image_title || 'Untitled';
        const category = image.image_category ? image.image_category.toUpperCase() : 'UNCATEGORIZED';
        
        div.innerHTML = `
            <img src="${imgSrc}" alt="${this.escapeHtml(altText)}" loading="lazy" 
                 onerror="this.src='https://via.placeholder.com/400x300?text=Image+Not+Found';">
            <div class="gallery-overlay">
                <div class="gallery-item-title">${this.escapeHtml(title)}</div>
                <div class="gallery-item-category">${this.escapeHtml(category)}</div>
            </div>
        `;
        
        div.addEventListener('click', () => this.openLightbox(index));
        
        return div;
    }
    
    getImagePath(imagePath) {
        if (!imagePath) {
            return 'https://via.placeholder.com/400x300?text=No+Image';
        }
        
        if (imagePath.startsWith('http')) {
            return imagePath;
        }
        
        // The admin stores images as 'uploads/gallery/filename.jpg'
        // We need to prepend '../admin/' to access from main folder
        let finalPath;
        
        if (imagePath.startsWith('uploads/')) {
            finalPath = `./admin/${imagePath}`;
        } else {
            const cleanPath = imagePath.replace(/^\/+/, '');
            finalPath = `./admin/uploads/gallery/${cleanPath}`;
        }
        
        return finalPath;
    }
    
    handleFilterClick(e) {
        const button = e.target;
        const filter = button.getAttribute('data-filter');
        
        this.filterButtons.querySelectorAll('button').forEach(btn => 
            btn.classList.remove('active'));
        button.classList.add('active');
        
        this.currentFilter = filter;
        this.loadImages();
    }
    
    openLightbox(index) {
        this.currentLightboxIndex = index;
        this.showLightboxImage();
        this.lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    
    showLightboxImage() {
        if (this.allImages[this.currentLightboxIndex]) {
            const imgSrc = this.getImagePath(this.allImages[this.currentLightboxIndex].image_path);
            this.lightboxImg.src = imgSrc;
        }
    }
    
    closeLightbox() {
        this.lightbox.style.display = 'none';
        document.body.style.overflow = 'auto';
        this.lightboxImg.src = '';
    }
    
    showNextImage() {
        this.currentLightboxIndex = (this.currentLightboxIndex + 1) % this.allImages.length;
        this.showLightboxImage();
    }
    
    showPrevImage() {
        this.currentLightboxIndex = (this.currentLightboxIndex - 1 + this.allImages.length) % this.allImages.length;
        this.showLightboxImage();
    }
    
    showLoading() {
        this.hideMessages();
        this.loading.style.display = 'flex';
    }
    
    showNoResults() {
        this.hideMessages();
        this.noResults.style.display = 'block';
    }
    
    showError(message) {
        this.hideMessages();
        this.errorMessage.style.display = 'block';
        const errorP = this.errorMessage.querySelector('p');
        if (errorP) {
            errorP.textContent = message || 'An error occurred while loading images.';
        }
    }
    
    hideMessages() {
        this.loading.style.display = 'none';
        this.noResults.style.display = 'none';
        this.errorMessage.style.display = 'none';
    }
    
    escapeHtml(unsafe) {
        if (!unsafe) return '';
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
    
    setupEventListeners() {
        this.closeBtn.addEventListener('click', () => this.closeLightbox());
        this.prevBtn.addEventListener('click', () => this.showPrevImage());
        this.nextBtn.addEventListener('click', () => this.showNextImage());
        
        this.lightbox.addEventListener('click', (e) => {
            if (e.target === this.lightbox) {
                this.closeLightbox();
            }
        });
        
        document.addEventListener('keydown', (e) => {
            if (this.lightbox.style.display === 'flex') {
                if (e.key === 'Escape') {
                    this.closeLightbox();
                } else if (e.key === 'ArrowLeft') {
                    this.showPrevImage();
                } else if (e.key === 'ArrowRight') {
                    this.showNextImage();
                }
            }
        });
    }
}

// Initialize gallery when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new GalleryManager();
});
</script>

</body>
</html>