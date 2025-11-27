<?php
session_start();


if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true || !isset($_SESSION['admin_id'])) {
    session_destroy();
    header("Location: admin_login.php");
    exit();
}


$_SESSION['login_time'] = time();


$admin_username = $_SESSION['admin_username'] ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard - Amfus School</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
:root{--primary:#ff4b5c;--secondary:#4169e1;--dark:#1a1a2e;--sidebar-bg:#16213e;--sidebar-hover:#0f3460}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#f8f9fc;overflow-x:hidden}


.sidebar{position:fixed;top:0;left:0;height:100vh;width:260px;background:var(--sidebar-bg);z-index:1000;transition:all 0.3s;overflow-y:auto;scrollbar-width:none;-ms-overflow-style:none}
.sidebar::-webkit-scrollbar{display:none}
.sidebar.collapsed{width:80px}
.sidebar.mobile-collapsed{transform:translateX(-100%)}
.sidebar-header{padding:24px 20px;border-bottom:1px solid rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:space-between}
.sidebar-brand{color:white;font-size:20px;font-weight:700;display:flex;align-items:center;gap:12px}
.sidebar-brand i{font-size:28px;color:var(--primary)}
.sidebar-toggle{background:transparent;border:none;color:white;font-size:20px;cursor:pointer;padding:8px}
.sidebar-nav{padding:20px 0}
.nav-link{color:rgba(255,255,255,0.7);padding:14px 24px;display:flex;align-items:center;gap:12px;transition:all 0.3s;border-left:3px solid transparent;text-decoration:none;font-size:15px;cursor:pointer}
.nav-link:hover{background:var(--sidebar-hover);color:white}
.nav-link.active{background:var(--sidebar-hover);color:white;border-left-color:var(--primary)}
.nav-link i{font-size:18px;width:24px;text-align:center}
.sidebar.collapsed .nav-link span{display:none}
.sidebar-footer{position:absolute;bottom:0;width:100%;padding:20px;border-top:1px solid rgba(255,255,255,0.1)}


.mobile-toggle{display:none;background:var(--secondary);color:white;border:none;padding:10px 16px;border-radius:8px;font-size:18px;position:fixed;top:20px;left:20px;z-index:1001}


.main-content{margin-left:260px;transition:margin-left 0.3s;min-height:100vh;padding:40px}
.sidebar.collapsed~.main-content{margin-left:80px}


.page-header{background:white;padding:30px;border-radius:16px;margin-bottom:30px;box-shadow:0 2px 10px rgba(0,0,0,0.05)}
.page-header h1{font-size:32px;font-weight:700;color:var(--dark);margin-bottom:8px}
.page-header p{color:#6c757d;font-size:16px;margin:0}


.stat-card{background:white;border-radius:16px;padding:24px;box-shadow:0 2px 10px rgba(0,0,0,0.05);transition:transform 0.3s,box-shadow 0.3s;border:1px solid rgba(0,0,0,0.05);height:100%}
.stat-card:hover{transform:translateY(-5px);box-shadow:0 8px 25px rgba(0,0,0,0.1)}
.stat-icon{width:56px;height:56px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:24px;margin-bottom:16px}
.stat-card h3{font-size:14px;color:#6c757d;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;font-weight:600}
.stat-number{font-size:32px;font-weight:700;color:var(--dark)}
.stat-change{font-size:13px;margin-top:8px}


.content-card{background:white;border-radius:16px;box-shadow:0 2px 10px rgba(0,0,0,0.05);margin-bottom:30px;border:1px solid rgba(0,0,0,0.05)}
.card-body-custom{padding:30px}


.table-custom{margin:0}
.table-custom thead{background:#f8f9fc}
.table-custom th{padding:16px;font-size:13px;font-weight:600;color:#6c757d;text-transform:uppercase;letter-spacing:0.5px;border:none}
.table-custom td{padding:16px;vertical-align:middle;border-top:1px solid rgba(0,0,0,0.05)}


.add-btn-container{text-align:right;margin-bottom:20px}
.btn-add{background:var(--secondary);color:white;padding:12px 24px;border:none;border-radius:8px;font-weight:600;transition:all 0.3s}
.btn-add:hover{background:#3557c7;transform:translateY(-2px)}
.action-btn{padding:8px 12px;border:none;border-radius:6px;cursor:pointer;font-size:12px;transition:all 0.3s;margin-right:4px}
.btn-edit{background:#2196F3;color:white}
.btn-delete{background:#F44336;color:white}
.btn-view{background:#FF9800;color:white}
.action-btn:hover{transform:scale(1.05)}

.status-badge{padding:6px 12px;border-radius:20px;font-size:11px;font-weight:600;text-transform:uppercase}
.badge-success{background:rgba(76,175,80,0.2);color:#4CAF50}
.badge-warning{background:rgba(255,193,7,0.2);color:#FF9800}
.badge-danger{background:rgba(244,67,54,0.2);color:#F44336}
.badge-info{background:rgba(33,150,243,0.2);color:#2196F3}


.form-container{display:none}
.form-container.active{display:block}
.file-upload-wrapper{position:relative;overflow:hidden;display:inline-block;width:100%}
.file-upload-wrapper input[type=file]{font-size:100px;position:absolute;left:0;top:0;opacity:0;cursor:pointer}
.file-upload-label{display:block;padding:12px;border:2px dashed #dee2e6;border-radius:8px;text-align:center;cursor:pointer;transition:all 0.3s}
.file-upload-label:hover{border-color:var(--secondary);background:#f8f9fc}
.file-upload-label i{font-size:32px;color:var(--secondary);margin-bottom:8px}

.content-section{display:none}
.content-section.active{display:block;animation:fadeIn 0.4s ease}
@keyframes fadeIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}


.alert{display:none;padding:12px 20px;border-radius:8px;margin-bottom:20px}
.alert.show{display:block;animation:slideIn 0.3s ease}
.alert-success{background:rgba(76,175,80,0.1);color:#4CAF50;border:1px solid rgba(76,175,80,0.3)}
.alert-error{background:rgba(244,67,54,0.1);color:#F44336;border:1px solid rgba(244,67,54,0.3)}
@keyframes slideIn{from{transform:translateY(-20px);opacity:0}to{transform:translateY(0);opacity:1}}


.modal{display:none;position:fixed;z-index:2000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.7);overflow-y:auto}
.modal.show{display:flex;align-items:center;justify-content:center}
.modal-content{background:white;margin:20px;padding:30px;border-radius:16px;width:90%;max-width:600px;max-height:90vh;overflow-y:auto}
.modal-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;padding-bottom:15px;border-bottom:1px solid #e0e0e0}
.modal-title{font-size:24px;font-weight:700;color:var(--dark)}
.close{background:none;border:none;font-size:28px;cursor:pointer;color:#999}
.close:hover{color:var(--primary)}

/* Responsive */
@media(max-width:991px){
.sidebar{transform:translateX(-100%)}
.sidebar.show{transform:translateX(0)}
.main-content{margin-left:0;padding:20px}
.mobile-toggle{display:block}
.page-header h1{font-size:24px}
}
</style>
</head>
<body>

<button class="mobile-toggle" id="mobileToggle"><i class="bi bi-list"></i></button>

<aside class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <div class="sidebar-brand"><i class="bi bi-mortarboard-fill"></i><span>Amfus Admin</span></div>
    <button class="sidebar-toggle d-none d-lg-block" id="sidebarToggle"><i class="bi bi-list"></i></button>
  </div>
  <nav class="sidebar-nav">
    <a class="nav-link active" onclick="showSection('overview')"><i class="bi bi-speedometer2"></i><span>Dashboard</span></a>
    <a class="nav-link" onclick="showSection('messages')"><i class="bi bi-chat-dots"></i><span>Messages</span></a>
    <a class="nav-link" onclick="showSection('news')"><i class="bi bi-newspaper"></i><span>News Management</span></a>
    <a class="nav-link" onclick="showSection('gallery')"><i class="bi bi-images"></i><span>Gallery</span></a>
    <a class="nav-link" onclick="showSection('team')"><i class="bi bi-people"></i><span>Staffs</span></a>
    <a class="nav-link" onclick="showSection('settings')"><i class="bi bi-gear"></i><span>Settings</span></a>
  </nav>
  <div class="sidebar-footer">
    <a href="logout.php" class="btn btn-danger w-100"><i class="bi bi-box-arrow-left me-2"></i><span>Logout</span></a>
  </div>
</aside>

<main class="main-content" id="mainContent">
  

  <div class="content-section active" id="overview">
    <div class="page-header">
      <h1>Dashboard Overview</h1>
      <p>Welcome back, <?php echo htmlspecialchars($admin_username); ?>. Here's a summary of your school management system.</p>
    </div>
    <div class="row g-4 mb-4">
      <div class="col-xl-3 col-md-6">
        <div class="stat-card">
          <div class="stat-icon" style="background:rgba(255,75,92,0.1);color:var(--primary)"><i class="bi bi-chat-dots-fill"></i></div>
          <h3>Messages</h3>
          <div class="stat-number" id="total-messages">0</div>
          <div class="stat-change text-warning"><span id="unread-messages">0</span> unread</div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="stat-card">
          <div class="stat-icon" style="background:rgba(65,105,225,0.1);color:var(--secondary)"><i class="bi bi-newspaper"></i></div>
          <h3>Published News</h3>
          <div class="stat-number" id="total-news">0</div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="stat-card">
          <div class="stat-icon" style="background:rgba(255,193,7,0.1);color:#ffc107"><i class="bi bi-people-fill"></i></div>
          <h3>Staffs</h3>
          <div class="stat-number" id="total-team">0</div>
        </div>
      </div>
    </div>
  </div>

  
  <div class="content-section" id="messages">
    <div class="page-header">
      <h1>Messages & Suggestions</h1>
      <p>View and respond to contact messages and suggestions from parents, students, and applicants.</p>
    </div>
    
    <div class="alert alert-success" id="message-success">Message action completed successfully!</div>
    <div class="alert alert-error" id="message-error">Error processing message.</div>
    
    <div class="content-card">
      <div class="card-body-custom">
        <h2 class="h5 fw-bold mb-4">All Messages</h2>
        <div id="messages-container">
          <p class="text-center text-muted py-4">Loading messages...</p>
        </div>
      </div>
    </div>
  </div>

  
  <div class="content-section" id="news">
    <div class="page-header">
      <h1>News Management</h1>
      <p>Create, edit, and publish news articles for your school website.</p>
    </div>
    <div class="add-btn-container">
      <button class="btn btn-add" onclick="openNewsModal()"><i class="bi bi-plus-circle me-2"></i>Add New Article</button>
    </div>
    
    <div class="alert alert-success" id="news-success">News article saved successfully!</div>
    <div class="alert alert-error" id="news-error">Error saving news article.</div>
    
    <div class="content-card form-container" id="newsFormContainer">
      <div class="card-body-custom">
        <h2 class="h5 fw-bold mb-4">Add/Edit Article</h2>
        <form id="newsForm" enctype="multipart/form-data">
          <input type="hidden" id="news-id" name="news_id">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label fw-semibold">Article Title *</label>
              <input type="text" id="news-title" name="title" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Category *</label>
              <select id="news-category" name="category" class="form-select" required>
                <option value="">Select Category</option>
                <option>Events</option>
                <option>Academics</option>
                <option>Sports</option>
                <option>Announcements</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Author</label>
              <input type="text" id="news-author" name="author" class="form-control" value="Admin User">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Publication Date *</label>
              <input type="date" id="news-date" name="publication_date" class="form-control" required>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Featured Image</label>
              <div class="file-upload-wrapper">
                <input type="file" id="news-image" name="featured_image" accept="image/*">
                <div class="file-upload-label">
                  <i class="bi bi-cloud-upload d-block"></i>
                  <p class="mb-0">Click to upload image</p>
                </div>
              </div>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Article Content *</label>
              <textarea id="news-content" name="content" class="form-control" rows="10" required></textarea>
            </div>
            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="news-published" name="is_published" checked>
                <label class="form-check-label">Published</label>
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Save Article</button>
              <button type="button" class="btn btn-outline-secondary ms-2" onclick="closeNewsForm()">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    
    <div class="content-card">
      <div class="card-body-custom">
        <h2 class="h5 fw-bold mb-4">Published Articles</h2>
        <div class="table-responsive">
          <table class="table table-custom">
            <thead><tr><th>Title</th><th>Category</th><th>Author</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody id="news-table">
              <tr><td colspan="5" class="text-center">Loading news articles...</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


  <div class="content-section" id="gallery">
    <div class="page-header">
      <h1>Gallery Management</h1>
      <p>Upload and organize photos for your school gallery.</p>
    </div>
    <div class="add-btn-container">
      <button class="btn btn-add" onclick="openGalleryModal()"><i class="bi bi-plus-circle me-2"></i>Upload New Image</button>
    </div>
    
    <div class="alert alert-success" id="gallery-success">Gallery item saved successfully!</div>
    <div class="alert alert-error" id="gallery-error">Error saving gallery item.</div>
    
    <div class="content-card form-container" id="galleryFormContainer">
      <div class="card-body-custom">
        <h2 class="h5 fw-bold mb-4">Upload Image</h2>
        <form id="galleryForm" enctype="multipart/form-data">
          <input type="hidden" id="gallery-id" name="gallery_id">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label fw-semibold">Select Image *</label>
              <div class="file-upload-wrapper">
                <input type="file" id="gallery-image" name="gallery_image" accept="image/*" required>
                <div class="file-upload-label">
                  <i class="bi bi-images d-block"></i>
                  <p class="mb-0">Click to upload image</p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Title *</label>
              <input type="text" id="gallery-title" name="image_title" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Category *</label>
              <select id="gallery-category" name="image_category" class="form-select" required>
                <option value="">Select Category</option>
                <option value="academics">Academics</option>
                <option value="events">Events</option>
                <option value="sports">Sports</option>
                <option value="facilities">Facilities</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Description</label>
              <textarea id="gallery-description" name="image_description" class="form-control" rows="3"></textarea>
            </div>
            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gallery-active" name="is_active" checked>
                <label class="form-check-label">Active</label>
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary"><i class="bi bi-upload me-2"></i>Upload</button>
              <button type="button" class="btn btn-outline-secondary ms-2" onclick="closeGalleryForm()">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    
    <div class="content-card">
      <div class="card-body-custom">
        <h2 class="h5 fw-bold mb-4">Gallery Images</h2>
        <div class="row g-3" id="gallery-grid">
          <p class="text-center text-muted py-4">Loading gallery images...</p>
        </div>
      </div>
    </div>
  </div>

  <div class="content-section" id="team">
    <div class="page-header">
      <h1>Team Management</h1>
      <p>Add and manage your school's faculty and staff members.</p>
    </div>
    <div class="add-btn-container">
      <button class="btn btn-add" onclick="openTeamModal()"><i class="bi bi-plus-circle me-2"></i>Add Team Member</button>
    </div>
    
    <div class="alert alert-success" id="team-success">Team member saved successfully!</div>
    <div class="alert alert-error" id="team-error">Error saving team member.</div>
    
    <div class="content-card form-container" id="teamFormContainer">
      <div class="card-body-custom">
        <h2 class="h5 fw-bold mb-4">Add/Edit Team Member</h2>
        <form id="teamForm" enctype="multipart/form-data">
          <input type="hidden" id="team-id" name="team_id">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Full Name *</label>
              <input type="text" id="team-name" name="full_name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Position *</label>
              <input type="text" id="team-position" name="position" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Email *</label>
              <input type="email" id="team-email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Phone *</label>
              <input type="tel" id="team-phone" name="phone" class="form-control" required>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Profile Photo</label>
              <div class="file-upload-wrapper">
                <input type="file" id="team-photo" name="profile_photo" accept="image/*" class="form-input">
                <div class="file-upload-label">
                  <i class="bi bi-person-circle d-block"></i>
                  <p class="mb-0">Click to upload photo</p>
                </div>
              </div>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Biography</label>
              <textarea id="team-biography" name="biography" class="form-control" rows="4"></textarea>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Facebook URL</label>
              <input type="url" id="team-facebook" name="facebook_url" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Twitter URL</label>
              <input type="url" id="team-twitter" name="twitter_url" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">LinkedIn URL</label>
              <input type="url" id="team-linkedin" name="linkedin_url" class="form-control">
            </div>
            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="team-active" name="is_active" checked>
                <label class="form-check-label">Active</label>
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary"><i class="bi bi-person-plus me-2"></i>Save</button>
              <button type="button" class="btn btn-outline-secondary ms-2" onclick="closeTeamForm()">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    
    <div class="content-card">
      <div class="card-body-custom">
        <h2 class="h5 fw-bold mb-4">Team Members</h2>
        <div class="table-responsive">
          <table class="table table-custom">
            <thead><tr><th>Name</th><th>Position</th><th>Email</th><th>Phone</th><th>Actions</th></tr></thead>
            <tbody id="team-table">
              <tr><td colspan="5" class="text-center">Loading team members...</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


  <div class="content-section" id="applications">
    <div class="page-header">
      <h1>Student Applications</h1>
      <p>Review and manage student applications.</p>
    </div>
    
    <div class="alert alert-success" id="application-success">Application updated successfully!</div>
    <div class="alert alert-error" id="application-error">Error updating application.</div>
    
    <div class="content-card">
      <div class="card-body-custom">
        <h2 class="h5 fw-bold mb-4">Recent Applications</h2>
        <div class="table-responsive">
          <table class="table table-custom">
            <thead><tr><th>Student Name</th><th>Parent/Guardian</th><th>Class</th><th>Date Applied</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody id="applications-table">
              <tr><td colspan="6" class="text-center">Loading applications...</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


  <div class="content-section" id="settings">
    <div class="page-header">
      <h1>Settings</h1>
      <p>Manage your account settings and school information.</p>
    </div>
    
    <div class="row g-4">
      <div class="col-lg-6">
        <div class="content-card">
          <div class="card-body-custom">
            <h2 class="h5 fw-bold mb-4">Change Password</h2>
            
            <div class="alert alert-success" id="password-success">Password updated successfully!</div>
            <div class="alert alert-error" id="password-error">Error updating password.</div>
            
            <form id="passwordForm">
              <div class="mb-3">
                <label class="form-label fw-semibold">Current Password *</label>
                <input type="password" id="current-password" name="current_password" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">New Password *</label>
                <input type="password" id="new-password" name="new_password" class="form-control" minlength="6" required>
                <small class="text-muted">Minimum 6 characters</small>
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Confirm New Password *</label>
                <input type="password" id="confirm-password" name="confirm_password" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary"><i class="bi bi-shield-check me-2"></i>Update Password</button>
            </form>
          </div>
        </div>
      </div>
      
      <div class="col-lg-6">
        <div class="content-card">
          <div class="card-body-custom">
            <h2 class="h5 fw-bold mb-4">School Information</h2>
            
            <div class="alert alert-success" id="settings-success">Settings updated successfully!</div>
            <div class="alert alert-error" id="settings-error">Error updating settings.</div>
            
            <form id="settingsForm">
              <div class="mb-3">
                <label class="form-label fw-semibold">School Name</label>
                <input type="text" id="school-name" name="school_name" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">School Email</label>
                <input type="email" id="school-email" name="school_email" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Phone</label>
                <input type="tel" id="school-phone" name="school_phone" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Address</label>
                <textarea id="school-address" name="school_address" class="form-control" rows="3"></textarea>
              </div>
              <button type="submit" class="btn btn-secondary"><i class="bi bi-save me-2"></i>Save Changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</main>


<div id="messageModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">Message Details</h2>
      <button class="close" onclick="closeModal('messageModal')">&times;</button>
    </div>
    <div id="message-details"></div>
  </div>
</div>


<div id="applicationModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">Application Details</h2>
      <button class="close" onclick="closeModal('applicationModal')">&times;</button>
    </div>
    <div id="application-details"></div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>

let currentSection = 'overview';


document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard initializing...');
    initializeMobileNavigation();
    loadDashboardStats();
    loadMessages();
    setupFormHandlers();
    

    document.getElementById('news-date').value = new Date().toISOString().split('T')[0];
});


function initializeMobileNavigation() {
    const mobileToggle = document.getElementById('mobileToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    mobileToggle.addEventListener('click', function() {
        sidebar.classList.toggle('show');
    });

    sidebarToggle.addEventListener('click', function() {
        if (window.innerWidth > 991) {
            sidebar.classList.toggle('collapsed');
            mainContent.style.marginLeft = sidebar.classList.contains('collapsed') ? '80px' : '260px';
        } else {
            sidebar.classList.toggle('show');
        }
    });

 
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 991) {
                sidebar.classList.remove('show');
            }
        });
    });
}


function showSection(sectionId) {
    document.querySelectorAll('.content-section').forEach(section => {
        section.classList.remove('active');
    });
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
    });
    
    const targetSection = document.getElementById(sectionId);
    if (targetSection) {
        targetSection.classList.add('active');
    }
    
    event.target.closest('.nav-link').classList.add('active');
    currentSection = sectionId;
    
    
    switch(sectionId) {
        case 'overview':
            loadDashboardStats();
            break;
        case 'messages':
            loadMessages();
            break;
        case 'news':
            loadNews();
            break;
        case 'gallery':
            loadGallery();
            break;
        case 'team':
            loadTeam();
            break;
        case 'applications':
            loadApplications();
            break;
        case 'settings':
            loadSettings();
            break;
    }
}


function loadDashboardStats() {
    fetch('admin_handler.php?action=get_stats')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('total-messages').textContent = data.stats.messages || 0;
                document.getElementById('unread-messages').textContent = data.stats.unread_messages || 0;
                document.getElementById('total-news').textContent = data.stats.news || 0;
                document.getElementById('total-applications').textContent = data.stats.applications || 0;
                document.getElementById('pending-applications').textContent = data.stats.pending_applications || 0;
                document.getElementById('total-team').textContent = data.stats.team || 0;
            }
        })
        .catch(error => console.error('Error loading stats:', error));
}


function loadMessages() {
    fetch('admin_handler.php?action=get_messages')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const container = document.getElementById('messages-container');
                if (data.messages.length === 0) {
                    container.innerHTML = '<p class="text-center text-muted py-4">No messages found.</p>';
                    return;
                }
                
                container.innerHTML = data.messages.map(msg => `
                    <div class="message-card" style="background:#f8f9fc;border-left:4px solid var(--primary);padding:20px;border-radius:8px;margin-bottom:16px">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <div style="font-weight:600;color:var(--dark);font-size:15px">${msg.name}</div>
                                <div style="font-size:12px;color:var(--secondary);font-weight:600;text-transform:uppercase">${msg.message_type}</div>
                            </div>
                            <div class="text-end">
                                <div style="font-size:13px;color:#6c757d">${new Date(msg.created_at).toLocaleDateString()}</div>
                                <span class="status-badge ${msg.is_read == 1 ? 'badge-success' : 'badge-warning'}">${msg.is_read == 1 ? 'Read' : 'Unread'}</span>
                            </div>
                        </div>
                        <div style="color:#495057;line-height:1.8;margin-bottom:10px">
                            <strong>Email:</strong> ${msg.email}<br>
                            ${msg.phone ? `<strong>Phone:</strong> ${msg.phone}<br>` : ''}
                            ${msg.subject ? `<strong>Subject:</strong> ${msg.subject}<br>` : ''}
                            <strong>Message:</strong> ${msg.message.substring(0, 150)}${msg.message.length > 150 ? '...' : ''}
                        </div>
                        <div>
                            <button class="action-btn btn-view" onclick="viewMessage(${msg.id})"><i class="bi bi-eye me-1"></i>View</button>
                            ${msg.is_read == 0 ? `<button class="action-btn btn-edit" onclick="markMessageRead(${msg.id})"><i class="bi bi-check2 me-1"></i>Mark Read</button>` : ''}
                            <button class="action-btn btn-delete" onclick="deleteMessage(${msg.id})"><i class="bi bi-trash me-1"></i>Delete</button>
                        </div>
                    </div>
                `).join('');
            }
        })
        .catch(error => console.error('Error loading messages:', error));
}


function loadNews() {
    fetch('admin_handler.php?action=get_news')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tbody = document.getElementById('news-table');
                if (data.news.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center">No news articles found.</td></tr>';
                    return;
                }
                
                tbody.innerHTML = data.news.map(news => `
                    <tr>
                        <td><strong>${news.title}</strong></td>
                        <td><span class="status-badge badge-info">${news.category}</span></td>
                        <td>${news.author}</td>
                        <td>${new Date(news.publication_date).toLocaleDateString()}</td>
                        <td>
                            <button class="action-btn btn-edit" onclick="editNews(${news.id})"><i class="bi bi-pencil"></i></button>
                            <button class="action-btn btn-delete" onclick="deleteNews(${news.id})"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                `).join('');
            }
        })
        .catch(error => console.error('Error loading news:', error));
}

function loadGallery() {
    fetch('admin_handler.php?action=get_gallery')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const grid = document.getElementById('gallery-grid');
                if (data.gallery.length === 0) {
                    grid.innerHTML = '<p class="text-center text-muted py-4">No gallery images found.</p>';
                    return;
                }
                
                grid.innerHTML = data.gallery.map(item => `
                    <div class="col-md-3">
                        <div class="card">
                            <img src="${item.image_path}" class="card-img-top" alt="${item.image_title}" style="height:200px;object-fit:cover">
                            <div class="card-body">
                                <span class="status-badge badge-info mb-2">${item.image_category}</span>
                                <p class="card-text small mb-2">${item.image_title}</p>
                                <button class="btn btn-sm btn-outline-primary me-1" onclick="editGallery(${item.id})"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteGallery(${item.id})"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                `).join('');
            }
        })
        .catch(error => console.error('Error loading gallery:', error));
}


function loadTeam() {
    fetch('admin_handler.php?action=get_team')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tbody = document.getElementById('team-table');
                if (data.team.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center">No team members found.</td></tr>';
                    return;
                }
                
                tbody.innerHTML = data.team.map(member => `
                    <tr>
                        <td>${member.full_name}</td>
                        <td>${member.position}</td>
                        <td>${member.email}</td>
                        <td>${member.phone}</td>
                        <td>
                            <button class="action-btn btn-edit" onclick="editTeam(${member.id})"><i class="bi bi-pencil"></i></button>
                            <button class="action-btn btn-delete" onclick="deleteTeam(${member.id})"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                `).join('');
            }
        })
        .catch(error => console.error('Error loading team:', error));
}


function loadApplications() {
    fetch('admin_handler.php?action=get_applications')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tbody = document.getElementById('applications-table');
                if (data.applications.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center">No applications found.</td></tr>';
                    return;
                }
                
                tbody.innerHTML = data.applications.map(app => `
                    <tr>
                        <td>${app.student_name}</td>
                        <td>${app.parent_guardian}</td>
                        <td>${app.class_applying}</td>
                        <td>${new Date(app.created_at).toLocaleDateString()}</td>
                        <td>
                            <span class="status-badge ${app.application_status === 'approved' ? 'badge-success' : app.application_status === 'rejected' ? 'badge-danger' : 'badge-warning'}">
                                ${app.application_status}
                            </span>
                        </td>
                        <td>
                            <button class="action-btn btn-view" onclick="viewApplication(${app.id})"><i class="bi bi-eye"></i></button>
                            ${app.application_status === 'pending' ? `
                                <button class="action-btn btn-edit" onclick="updateApplicationStatus(${app.id}, 'approved')"><i class="bi bi-check-circle"></i></button>
                                <button class="action-btn btn-delete" onclick="updateApplicationStatus(${app.id}, 'rejected')"><i class="bi bi-x-circle"></i></button>
                            ` : ''}
                            <button class="action-btn btn-delete" onclick="deleteApplication(${app.id})"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                `).join('');
            }
        })
        .catch(error => console.error('Error loading applications:', error));
}


function loadSettings() {
    fetch('admin_handler.php?action=get_site_settings')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('school-name').value = data.settings.school_name || '';
                document.getElementById('school-email').value = data.settings.school_email || '';
                document.getElementById('school-phone').value = data.settings.school_phone || '';
                document.getElementById('school-address').value = data.settings.school_address || '';
            }
        })
        .catch(error => console.error('Error loading settings:', error));
}


function setupFormHandlers() {

    document.getElementById('newsForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const newsId = document.getElementById('news-id').value;
        formData.append('action', newsId ? 'update_news' : 'add_news');
        
        fetch('admin_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('news-success', data.message);
                closeNewsForm();
                loadNews();
                loadDashboardStats();
            } else {
                showAlert('news-error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('news-error', 'An error occurred');
        });
    });

    // Gallery Form
    document.getElementById('galleryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const galleryId = document.getElementById('gallery-id').value;
        formData.append('action', galleryId ? 'update_gallery' : 'add_gallery');
        
        fetch('admin_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('gallery-success', data.message);
                closeGalleryForm();
                loadGallery();
                loadDashboardStats();
            } else {
                showAlert('gallery-error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('gallery-error', 'An error occurred');
        });
    });

    // Team Form
    document.getElementById('teamForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const teamId = document.getElementById('team-id').value;
        formData.append('action', teamId ? 'update_team' : 'add_team');
        
        fetch('admin_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('team-success', data.message);
                closeTeamForm();
                loadTeam();
                loadDashboardStats();
            } else {
                showAlert('team-error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('team-error', 'An error occurred');
        });
    });

    // Password Form
    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const newPass = document.getElementById('new-password').value;
        const confirmPass = document.getElementById('confirm-password').value;
        
        if (newPass !== confirmPass) {
            showAlert('password-error', 'Passwords do not match');
            return;
        }
        
        const formData = new FormData(this);
        formData.append('action', 'change_password');
        
        fetch('admin_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('password-success', data.message);
                this.reset();
            } else {
                showAlert('password-error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('password-error', 'An error occurred');
        });
    });

    // Settings Form
    document.getElementById('settingsForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'update_site_settings');
        
        fetch('admin_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('settings-success', data.message);
            } else {
                showAlert('settings-error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('settings-error', 'An error occurred');
        });
    });
}

// Modal and Form Functions
function openNewsModal() {
    document.getElementById('newsFormContainer').classList.add('active');
    document.getElementById('newsForm').reset();
    document.getElementById('news-id').value = '';
    document.getElementById('news-date').value = new Date().toISOString().split('T')[0];
}

function closeNewsForm() {
    document.getElementById('newsFormContainer').classList.remove('active');
}

function openGalleryModal() {
    document.getElementById('galleryFormContainer').classList.add('active');
    document.getElementById('galleryForm').reset();
    document.getElementById('gallery-id').value = '';
}

function closeGalleryForm() {
    document.getElementById('galleryFormContainer').classList.remove('active');
}

function openTeamModal() {
    document.getElementById('teamFormContainer').classList.add('active');
    document.getElementById('teamForm').reset();
    document.getElementById('team-id').value = '';
}

function closeTeamForm() {
    document.getElementById('teamFormContainer').classList.remove('active');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('show');
}

// CRUD Functions
function editNews(id) {
    fetch(`admin_handler.php?action=get_news_item&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const news = data.news_item;
                document.getElementById('news-id').value = news.id;
                document.getElementById('news-title').value = news.title;
                document.getElementById('news-category').value = news.category;
                document.getElementById('news-author').value = news.author;
                document.getElementById('news-date').value = news.publication_date;
                document.getElementById('news-content').value = news.content;
                document.getElementById('news-published').checked = news.is_published == 1;
                openNewsModal();
            }
        })
        .catch(error => console.error('Error:', error));
}

function deleteNews(id) {
    if (confirm('Are you sure you want to delete this news article?')) {
        fetch('admin_handler.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `action=delete_news&id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNews();
                loadDashboardStats();
                showAlert('news-success', data.message);
            } else {
                showAlert('news-error', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function editGallery(id) {
    fetch(`admin_handler.php?action=get_gallery_item&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = data.gallery_item;
                document.getElementById('gallery-id').value = item.id;
                document.getElementById('gallery-title').value = item.image_title;
                document.getElementById('gallery-category').value = item.image_category;
                document.getElementById('gallery-description').value = item.image_description || '';
                document.getElementById('gallery-active').checked = item.is_active == 1;
                document.getElementById('gallery-image').required = false;
                openGalleryModal();
            }
        })
        .catch(error => console.error('Error:', error));
}

function deleteGallery(id) {
    if (confirm('Are you sure you want to delete this image?')) {
        fetch('admin_handler.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `action=delete_gallery&id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadGallery();
                loadDashboardStats();
                showAlert('gallery-success', data.message);
            } else {
                showAlert('gallery-error', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function editTeam(id) {
    fetch(`admin_handler.php?action=get_team_member&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const member = data.team_member;
                document.getElementById('team-id').value = member.id;
                document.getElementById('team-name').value = member.full_name;
                document.getElementById('team-position').value = member.position;
                document.getElementById('team-email').value = member.email;
                document.getElementById('team-phone').value = member.phone;
                document.getElementById('team-biography').value = member.biography || '';
                document.getElementById('team-facebook').value = member.facebook_url || '';
                document.getElementById('team-twitter').value = member.twitter_url || '';
                document.getElementById('team-linkedin').value = member.linkedin_url || '';
                document.getElementById('team-active').checked = member.is_active == 1;
                openTeamModal();
            }
        })
        .catch(error => console.error('Error:', error));
}

function deleteTeam(id) {
    if (confirm('Are you sure you want to delete this team member?')) {
        fetch('admin_handler.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `action=delete_team&id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadTeam();
                loadDashboardStats();
                showAlert('team-success', data.message);
            } else {
                showAlert('team-error', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function viewMessage(id) {
    fetch(`admin_handler.php?action=get_message&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const msg = data.message;
                document.getElementById('message-details').innerHTML = `
                    <div style="padding:20px">
                        <p><strong>Name:</strong> ${msg.name}</p>
                        <p><strong>Email:</strong> ${msg.email}</p>
                        ${msg.phone ? `<p><strong>Phone:</strong> ${msg.phone}</p>` : ''}
                        ${msg.subject ? `<p><strong>Subject:</strong> ${msg.subject}</p>` : ''}
                        <p><strong>Type:</strong> ${msg.message_type}</p>
                        <p><strong>Date:</strong> ${new Date(msg.created_at).toLocaleString()}</p>
                        <hr>
                        <p><strong>Message:</strong></p>
                        <p>${msg.message}</p>
                    </div>
                `;
                document.getElementById('messageModal').classList.add('show');
            }
        })
        .catch(error => console.error('Error:', error));
}

function markMessageRead(id) {
    fetch('admin_handler.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `action=mark_message_read&id=${id}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadMessages();
            loadDashboardStats();
        }
    })
    .catch(error => console.error('Error:', error));
}

function deleteMessage(id) {
    if (confirm('Are you sure you want to delete this message?')) {
        fetch('admin_handler.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `action=delete_message&id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadMessages();
                loadDashboardStats();
                showAlert('message-success', data.message);
            } else {
                showAlert('message-error', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function viewApplication(id) {
    fetch(`admin_handler.php?action=get_application&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const app = data.application;
                document.getElementById('application-details').innerHTML = `
                    <div style="padding:20px">
                        <p><strong>Student Name:</strong> ${app.student_name}</p>
                        <p><strong>Parent/Guardian:</strong> ${app.parent_guardian}</p>
                        <p><strong>Parent Email:</strong> ${app.parent_email}</p>
                        <p><strong>Parent Phone:</strong> ${app.parent_phone}</p>
                        <p><strong>Class Applying For:</strong> ${app.class_applying}</p>
                        ${app.previous_school ? `<p><strong>Previous School:</strong> ${app.previous_school}</p>` : ''}
                        ${app.date_of_birth ? `<p><strong>Date of Birth:</strong> ${new Date(app.date_of_birth).toLocaleDateString()}</p>` : ''}
                        ${app.address ? `<p><strong>Address:</strong> ${app.address}</p>` : ''}
                        ${app.additional_info ? `<p><strong>Additional Info:</strong> ${app.additional_info}</p>` : ''}
                        <p><strong>Application Status:</strong> <span class="status-badge ${app.application_status === 'approved' ? 'badge-success' : app.application_status === 'rejected' ? 'badge-danger' : 'badge-warning'}">${app.application_status}</span></p>
                        <p><strong>Date Applied:</strong> ${new Date(app.created_at).toLocaleString()}</p>
                    </div>
                `;
                document.getElementById('applicationModal').classList.add('show');
            }
        })
        .catch(error => console.error('Error:', error));
}

function updateApplicationStatus(id, status) {
    const confirmMsg = status === 'approved' ? 'approve' : 'reject';
    if (confirm(`Are you sure you want to ${confirmMsg} this application?`)) {
        fetch('admin_handler.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `action=update_application_status&id=${id}&application_status=${status}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadApplications();
                loadDashboardStats();
                showAlert('application-success', data.message);
            } else {
                showAlert('application-error', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function deleteApplication(id) {
    if (confirm('Are you sure you want to delete this application?')) {
        fetch('admin_handler.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `action=delete_application&id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadApplications();
                loadDashboardStats();
                showAlert('application-success', data.message);
            } else {
                showAlert('application-error', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

// Utility Functions
function showAlert(alertId, message) {
    const alert = document.getElementById(alertId);
    if (alert) {
        alert.textContent = message;
        alert.classList.add('show');
        setTimeout(() => {
            alert.classList.remove('show');
        }, 5000);
    }
}

// Auto-refresh dashboard stats every 30 seconds
setInterval(() => {
    if (currentSection === 'overview') {
        loadDashboardStats();
    }
}, 30000);

console.log('Amfus Admin Dashboard loaded successfully');
</script>
</body>
</html>