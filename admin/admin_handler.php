<?php
session_start();

// Check authentication
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "amfus_school";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

// Get the action
$action = $_GET['action'] ?? $_POST['action'] ?? '';

// Handle different actions
switch($action) {
    case 'get_stats':
        handleGetStats($pdo);
        break;
    case 'get_news':
        handleGetNews($pdo);
        break;
    case 'get_news_item':
        handleGetNewsItem($pdo);
        break;
    case 'add_news':
        handleAddNews($pdo);
        break;
    case 'update_news':
        handleUpdateNews($pdo);
        break;
    case 'delete_news':
        handleDeleteNews($pdo);
        break;
    case 'get_gallery':
        handleGetGallery($pdo);
        break;
    case 'get_gallery_item':
        handleGetGalleryItem($pdo);
        break;
    case 'add_gallery':
        handleAddGallery($pdo);
        break;
    case 'update_gallery':
        handleUpdateGallery($pdo);
        break;
    case 'delete_gallery':
        handleDeleteGallery($pdo);
        break;
    case 'get_team':
        handleGetTeam($pdo);
        break;
    case 'get_team_member':
        handleGetTeamMember($pdo);
        break;
    case 'add_team':
        handleAddTeam($pdo);
        break;
    case 'update_team':
        handleUpdateTeam($pdo);
        break;
    case 'delete_team':
        handleDeleteTeam($pdo);
        break;
    case 'get_messages':
        handleGetMessages($pdo);
        break;
    case 'get_message':
        handleGetMessage($pdo);
        break;
    case 'mark_message_read':
        handleMarkMessageRead($pdo);
        break;
    case 'delete_message':
        handleDeleteMessage($pdo);
        break;
    case 'change_password':
        handleChangePassword($pdo);
        break;
    case 'update_site_settings':
        handleUpdateSiteSettings($pdo);
        break;
    case 'get_site_settings':
        handleGetSiteSettings($pdo);
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}

// Get dashboard statistics
function handleGetStats($pdo) {
    try {
        $stats = [];
        
        $stmt = $pdo->query("SELECT COUNT(*) FROM messages");
        $stats['messages'] = (int) $stmt->fetchColumn();
        
        $stmt = $pdo->query("SELECT COUNT(*) FROM messages WHERE is_read = 0");
        $stats['unread_messages'] = (int) $stmt->fetchColumn();
        
        $stmt = $pdo->query("SELECT COUNT(*) FROM news");
        $stats['news'] = (int) $stmt->fetchColumn();
        
        $stmt = $pdo->query("SELECT COUNT(*) FROM gallery");
        $stats['gallery'] = (int) $stmt->fetchColumn();
        
        $stmt = $pdo->query("SELECT COUNT(*) FROM team_members");
        $stats['team'] = (int) $stmt->fetchColumn();
        
        echo json_encode(['success' => true, 'stats' => $stats]);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching stats']);
    }
}

// NEWS MANAGEMENT
function handleGetNews($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM news ORDER BY publication_date DESC, created_at DESC");
        $news = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'news' => $news]);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching news']);
    }
}

function handleGetNewsItem($pdo) {
    try {
        $news_id = intval($_GET['id'] ?? 0);
        if ($news_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid ID']);
            return;
        }
        
        $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
        $stmt->execute([$news_id]);
        $news_item = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($news_item) {
            echo json_encode(['success' => true, 'news_item' => $news_item]);
        } else {
            echo json_encode(['success' => false, 'message' => 'News article not found']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching news']);
    }
}

function handleAddNews($pdo) {
    try {
        $title = trim($_POST['title'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $publication_date = $_POST['publication_date'] ?? date('Y-m-d');
        $content = trim($_POST['content'] ?? '');
        $is_published = isset($_POST['is_published']) ? 1 : 0;
        
        if (empty($title) || empty($category) || empty($content)) {
            echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
            return;
        }
        
        $featured_image = null;
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/news/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $file_info = pathinfo($_FILES['featured_image']['name']);
            $file_extension = strtolower($file_info['extension'] ?? '');
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array($file_extension, $allowed_extensions)) {
                $filename = 'news_' . time() . '_' . rand(1000, 9999) . '.' . $file_extension;
                $upload_path = $upload_dir . $filename;
                
                if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $upload_path)) {
                    $featured_image = $upload_path;
                }
            }
        }
        
        $stmt = $pdo->prepare("INSERT INTO news (title, category, author, publication_date, featured_image, content, is_published) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $result = $stmt->execute([$title, $category, $author, $publication_date, $featured_image, $content, $is_published]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'News article added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add news article']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}

function handleUpdateNews($pdo) {
    try {
        $news_id = intval($_POST['news_id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $publication_date = $_POST['publication_date'] ?? date('Y-m-d');
        $content = trim($_POST['content'] ?? '');
        $is_published = isset($_POST['is_published']) ? 1 : 0;
        
        if ($news_id <= 0 || empty($title) || empty($category) || empty($content)) {
            echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
            return;
        }
        
        $stmt = $pdo->prepare("SELECT featured_image FROM news WHERE id = ?");
        $stmt->execute([$news_id]);
        $current_news = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$current_news) {
            echo json_encode(['success' => false, 'message' => 'News article not found']);
            return;
        }
        
        $featured_image = $current_news['featured_image'];
        
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/news/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $file_info = pathinfo($_FILES['featured_image']['name']);
            $file_extension = strtolower($file_info['extension'] ?? '');
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array($file_extension, $allowed_extensions)) {
                $filename = 'news_' . time() . '_' . rand(1000, 9999) . '.' . $file_extension;
                $upload_path = $upload_dir . $filename;
                
                if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $upload_path)) {
                    if ($featured_image && file_exists($featured_image)) {
                        unlink($featured_image);
                    }
                    $featured_image = $upload_path;
                }
            }
        }
        
        $stmt = $pdo->prepare("UPDATE news SET title = ?, category = ?, author = ?, publication_date = ?, featured_image = ?, content = ?, is_published = ? WHERE id = ?");
        $result = $stmt->execute([$title, $category, $author, $publication_date, $featured_image, $content, $is_published, $news_id]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'News article updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update news article']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}

function handleDeleteNews($pdo) {
    try {
        $news_id = intval($_POST['id'] ?? 0);
        
        if ($news_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid news ID']);
            return;
        }
        
        $stmt = $pdo->prepare("SELECT featured_image FROM news WHERE id = ?");
        $stmt->execute([$news_id]);
        $news = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($news && !empty($news['featured_image']) && file_exists($news['featured_image'])) {
            unlink($news['featured_image']);
        }
        
        $stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
        $result = $stmt->execute([$news_id]);
        
        if ($result && $stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'News article deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'News article not found']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
}

// GALLERY MANAGEMENT
function handleGetGallery($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC");
        $gallery = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'gallery' => $gallery]);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching gallery']);
    }
}

function handleGetGalleryItem($pdo) {
    try {
        $gallery_id = intval($_GET['id'] ?? 0);
        if ($gallery_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid ID']);
            return;
        }
        
        $stmt = $pdo->prepare("SELECT * FROM gallery WHERE id = ?");
        $stmt->execute([$gallery_id]);
        $gallery_item = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($gallery_item) {
            echo json_encode(['success' => true, 'gallery_item' => $gallery_item]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gallery item not found']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching gallery item']);
    }
}

function handleAddGallery($pdo) {
    try {
        $image_title = trim($_POST['image_title'] ?? '');
        $image_description = trim($_POST['image_description'] ?? '');
        $image_category = trim($_POST['image_category'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        if (empty($image_title) || empty($image_category)) {
            echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
            return;
        }
        
        if (!isset($_FILES['gallery_image']) || $_FILES['gallery_image']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'Please upload an image']);
            return;
        }
        
        $upload_dir = 'uploads/gallery/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $file_info = pathinfo($_FILES['gallery_image']['name']);
        $file_extension = strtolower($file_info['extension'] ?? '');
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (!in_array($file_extension, $allowed_extensions)) {
            echo json_encode(['success' => false, 'message' => 'Invalid image format']);
            return;
        }
        
        $filename = 'gallery_' . time() . '_' . rand(1000, 9999) . '.' . $file_extension;
        $upload_path = $upload_dir . $filename;
        
        if (!move_uploaded_file($_FILES['gallery_image']['tmp_name'], $upload_path)) {
            echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
            return;
        }
        
        $stmt = $pdo->prepare("INSERT INTO gallery (image_title, image_description, image_category, image_path, is_active) VALUES (?, ?, ?, ?, ?)");
        $result = $stmt->execute([$image_title, $image_description, $image_category, $upload_path, $is_active]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Gallery item added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add gallery item']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
}

function handleUpdateGallery($pdo) {
    try {
        $gallery_id = intval($_POST['gallery_id'] ?? 0);
        $image_title = trim($_POST['image_title'] ?? '');
        $image_description = trim($_POST['image_description'] ?? '');
        $image_category = trim($_POST['image_category'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        if ($gallery_id <= 0 || empty($image_title) || empty($image_category)) {
            echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
            return;
        }
        
        $stmt = $pdo->prepare("SELECT image_path FROM gallery WHERE id = ?");
        $stmt->execute([$gallery_id]);
        $current_gallery = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$current_gallery) {
            echo json_encode(['success' => false, 'message' => 'Gallery item not found']);
            return;
        }
        
        $image_path = $current_gallery['image_path'];
        
        if (isset($_FILES['gallery_image']) && $_FILES['gallery_image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/gallery/';
            $file_info = pathinfo($_FILES['gallery_image']['name']);
            $file_extension = strtolower($file_info['extension'] ?? '');
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array($file_extension, $allowed_extensions)) {
                $filename = 'gallery_' . time() . '_' . rand(1000, 9999) . '.' . $file_extension;
                $upload_path = $upload_dir . $filename;
                
                if (move_uploaded_file($_FILES['gallery_image']['tmp_name'], $upload_path)) {
                    if ($image_path && file_exists($image_path)) {
                        unlink($image_path);
                    }
                    $image_path = $upload_path;
                }
            }
        }
        
        $stmt = $pdo->prepare("UPDATE gallery SET image_title = ?, image_description = ?, image_category = ?, image_path = ?, is_active = ? WHERE id = ?");
        $result = $stmt->execute([$image_title, $image_description, $image_category, $image_path, $is_active, $gallery_id]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Gallery item updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update gallery item']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
}

function handleDeleteGallery($pdo) {
    try {
        $gallery_id = intval($_POST['id'] ?? 0);
        
        if ($gallery_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid gallery ID']);
            return;
        }
        
        $stmt = $pdo->prepare("SELECT image_path FROM gallery WHERE id = ?");
        $stmt->execute([$gallery_id]);
        $gallery_item = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($gallery_item && !empty($gallery_item['image_path']) && file_exists($gallery_item['image_path'])) {
            unlink($gallery_item['image_path']);
        }
        
        $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
        $result = $stmt->execute([$gallery_id]);
        
        if ($result && $stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Gallery item deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gallery item not found']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
}

// TEAM MANAGEMENT
function handleGetTeam($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM team_members ORDER BY created_at DESC");
        $team = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'team' => $team]);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching team']);
    }
}

function handleGetTeamMember($pdo) {
    try {
        $team_id = intval($_GET['id'] ?? 0);
        if ($team_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid ID']);
            return;
        }
        
        $stmt = $pdo->prepare("SELECT * FROM team_members WHERE id = ?");
        $stmt->execute([$team_id]);
        $team_member = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($team_member) {
            echo json_encode(['success' => true, 'team_member' => $team_member]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Team member not found']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching team member']);
    }
}

function handleAddTeam($pdo) {
    try {
        $full_name = trim($_POST['full_name'] ?? '');
        $position = trim($_POST['position'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $biography = trim($_POST['biography'] ?? '');
        $facebook_url = trim($_POST['facebook_url'] ?? '');
        $twitter_url = trim($_POST['twitter_url'] ?? '');
        $linkedin_url = trim($_POST['linkedin_url'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        if (empty($full_name) || empty($position) || empty($email) || empty($phone)) {
            echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
            return;
        }
        
        $profile_photo = null;
        if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/team/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $file_info = pathinfo($_FILES['profile_photo']['name']);
            $file_extension = strtolower($file_info['extension'] ?? '');
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array($file_extension, $allowed_extensions)) {
                $filename = 'team_' . time() . '_' . rand(1000, 9999) . '.' . $file_extension;
                $upload_path = $upload_dir . $filename;
                
                if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $upload_path)) {
                    $profile_photo = $upload_path;
                }
            }
        }
        
        $stmt = $pdo->prepare("INSERT INTO team_members (full_name, position, email, phone, profile_photo, biography, facebook_url, twitter_url, linkedin_url, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $result = $stmt->execute([$full_name, $position, $email, $phone, $profile_photo, $biography, $facebook_url, $twitter_url, $linkedin_url, $is_active]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Team member added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add team member']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
}

function handleUpdateTeam($pdo) {
    try {
        $team_id = intval($_POST['team_id'] ?? 0);
        $full_name = trim($_POST['full_name'] ?? '');
        $position = trim($_POST['position'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $biography = trim($_POST['biography'] ?? '');
        $facebook_url = trim($_POST['facebook_url'] ?? '');
        $twitter_url = trim($_POST['twitter_url'] ?? '');
        $linkedin_url = trim($_POST['linkedin_url'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        if ($team_id <= 0 || empty($full_name) || empty($position) || empty($email) || empty($phone)) {
            echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
            return;
        }
        
        $stmt = $pdo->prepare("SELECT profile_photo FROM team_members WHERE id = ?");
        $stmt->execute([$team_id]);
        $current_team = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$current_team) {
            echo json_encode(['success' => false, 'message' => 'Team member not found']);
            return;
        }
        
        $profile_photo = $current_team['profile_photo'];
        
        if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/team/';
            $file_info = pathinfo($_FILES['profile_photo']['name']);
            $file_extension = strtolower($file_info['extension'] ?? '');
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array($file_extension, $allowed_extensions)) {
                $filename = 'team_' . time() . '_' . rand(1000, 9999) . '.' . $file_extension;
                $upload_path = $upload_dir . $filename;
                
                if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $upload_path)) {
                    if ($profile_photo && file_exists($profile_photo)) {
                        unlink($profile_photo);
                    }
                    $profile_photo = $upload_path;
                }
            }
        }
        
        $stmt = $pdo->prepare("UPDATE team_members SET full_name = ?, position = ?, email = ?, phone = ?, profile_photo = ?, biography = ?, facebook_url = ?, twitter_url = ?, linkedin_url = ?, is_active = ? WHERE id = ?");
        $result = $stmt->execute([$full_name, $position, $email, $phone, $profile_photo, $biography, $facebook_url, $twitter_url, $linkedin_url, $is_active, $team_id]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Team member updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update team member']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
}

function handleDeleteTeam($pdo) {
    try {
        $team_id = intval($_POST['id'] ?? 0);
        
        if ($team_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid team member ID']);
            return;
        }
        
        $stmt = $pdo->prepare("SELECT profile_photo FROM team_members WHERE id = ?");
        $stmt->execute([$team_id]);
        $team_member = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($team_member && !empty($team_member['profile_photo']) && file_exists($team_member['profile_photo'])) {
            unlink($team_member['profile_photo']);
        }
        
        $stmt = $pdo->prepare("DELETE FROM team_members WHERE id = ?");
        $result = $stmt->execute([$team_id]);
        
        if ($result && $stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Team member deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Team member not found']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
}

// MESSAGES MANAGEMENT
function handleGetMessages($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'messages' => $messages]);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching messages']);
    }
}

function handleGetMessage($pdo) {
    try {
        $message_id = intval($_GET['id'] ?? 0);
        if ($message_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid ID']);
            return;
        }
        
        $stmt = $pdo->prepare("SELECT * FROM messages WHERE id = ?");
        $stmt->execute([$message_id]);
        $message = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($message) {
            echo json_encode(['success' => true, 'message' => $message]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Message not found']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching message']);
    }
}

function handleMarkMessageRead($pdo) {
    try {
        $message_id = intval($_POST['id'] ?? 0);
        
        if ($message_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid message ID']);
            return;
        }
        
        $stmt = $pdo->prepare("UPDATE messages SET is_read = 1 WHERE id = ?");
        $result = $stmt->execute([$message_id]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Message marked as read']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to mark message as read']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
}

function handleDeleteMessage($pdo) {
    try {
        $message_id = intval($_POST['id'] ?? 0);
        
        if ($message_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid message ID']);
            return;
        }
        
        $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
        $result = $stmt->execute([$message_id]);
        
        if ($result && $stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Message deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Message not found']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
}

// SETTINGS MANAGEMENT
function handleChangePassword($pdo) {
    try {
        $current_password = trim($_POST['current_password'] ?? '');
        $new_password = trim($_POST['new_password'] ?? '');
        
        if (empty($current_password) || empty($new_password)) {
            echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
            return;
        }
        
        if (strlen($new_password) < 6) {
            echo json_encode(['success' => false, 'message' => 'New password must be at least 6 characters long']);
            return;
        }
        
        $admin_username = $_SESSION['admin_username'] ?? null;
        
        if (!$admin_username) {
            echo json_encode(['success' => false, 'message' => 'Admin session invalid']);
            return;
        }
        
        $stmt = $pdo->prepare("SELECT id, password FROM admin_users WHERE username = ?");
        $stmt->execute([$admin_username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$admin) {
            echo json_encode(['success' => false, 'message' => 'Admin user not found']);
            return;
        }
        
        if (!password_verify($current_password, $admin['password'])) {
            echo json_encode(['success' => false, 'message' => 'Current password is incorrect']);
            return;
        }
        
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE admin_users SET password = ? WHERE id = ?");
        $result = $stmt->execute([$hashed_password, $admin['id']]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update password']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
}

function handleUpdateSiteSettings($pdo) {
    try {
        $school_name = trim($_POST['school_name'] ?? '');
        $school_email = trim($_POST['school_email'] ?? '');
        $school_phone = trim($_POST['school_phone'] ?? '');
        $school_address = trim($_POST['school_address'] ?? '');
        
        if (!empty($school_email) && !filter_var($school_email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Please enter a valid email address']);
            return;
        }
        
        $settings = [
            'school_name' => $school_name,
            'school_email' => $school_email,
            'school_phone' => $school_phone,
            'school_address' => $school_address
        ];
        
        $updated_count = 0;
        foreach ($settings as $key => $value) {
            try {
                // Check if setting exists
                $stmt = $pdo->prepare("SELECT id FROM site_settings WHERE setting_key = ?");
                $stmt->execute([$key]);
                $exists = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($exists) {
                    // Update existing
                    $stmt = $pdo->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?");
                    $stmt->execute([$value, $key]);
                } else {
                    // Insert new
                    $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?)");
                    $stmt->execute([$key, $value]);
                }
                $updated_count++;
            } catch(PDOException $e) {
                error_log("Error updating setting $key: " . $e->getMessage());
            }
        }
        
        if ($updated_count > 0) {
            echo json_encode(['success' => true, 'message' => 'Settings updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No settings were updated']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
}

function handleGetSiteSettings($pdo) {
    try {
        $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
        $settings_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $settings = [
            'school_name' => '',
            'school_email' => '',
            'school_phone' => '',
            'school_address' => ''
        ];
        
        foreach ($settings_rows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        
        echo json_encode(['success' => true, 'settings' => $settings]);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching settings']);
    }
}
?>