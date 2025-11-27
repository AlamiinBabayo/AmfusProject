<?php

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    
    try {
        
        $name = Security::sanitizeInput($_POST['name'] ?? '');
        $email = Security::sanitizeInput($_POST['email'] ?? '');
        $phone = Security::sanitizeInput($_POST['phone'] ?? '');
        $subject = Security::sanitizeInput($_POST['subject'] ?? '');
        $message = Security::sanitizeInput($_POST['message'] ?? '');
        
       
        $errors = [];
        
        if (empty($name) || strlen($name) < 3) {
            $errors[] = "Name must be at least 3 characters long";
        }
        
        if (empty($email) || !Security::validateEmail($email)) {
            $errors[] = "Valid email is required";
        }
        
        if (!empty($phone) && !Security::validatePhone($phone)) {
            $errors[] = "Invalid phone number format";
        }
        
        if (empty($message) || strlen($message) < 10) {
            $errors[] = "Message must be at least 10 characters long";
        }
        
        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            header('Location: contact.php');
            exit();
        }
        
        
        $sql = "INSERT INTO contact_messages (name, email, phone, subject, message, ip_address, user_agent) 
                VALUES (:name, :email, :phone, :subject, :message, :ip_address, :user_agent)";
        
        $stmt = $db->prepare($sql);
        $result = $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':subject' => $subject,
            ':message' => $message,
            ':ip_address' => Security::getClientIP(),
            ':user_agent' => Security::getUserAgent()
        ]);
        


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['suggestion_submit'])) {
    
    try {
    
        $name = Security::sanitizeInput($_POST['name'] ?? '');
        $email = Security::sanitizeInput($_POST['email'] ?? '');
        $suggestion = Security::sanitizeInput($_POST['suggestion'] ?? '');
        
        
        $errors = [];
        
        if (empty($name) || strlen($name) < 3) {
            $errors[] = "Name must be at least 3 characters long";
        }
        
        if (!empty($email) && !Security::validateEmail($email)) {
            $errors[] = "Invalid email format";
        }
        
        if (empty($suggestion) || strlen($suggestion) < 10) {
            $errors[] = "Suggestion must be at least 10 characters long";
        }
        
        if (!empty($errors)) {
            echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
            exit();
        }
        
    
        $sql = "INSERT INTO suggestions (name, email, suggestion, ip_address, user_agent) 
                VALUES (:name, :email, :suggestion, :ip_address, :user_agent)";
        
        $stmt = $db->prepare($sql);
        $result = $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':suggestion' => $suggestion,
            ':ip_address' => Security::getClientIP(),
            ':user_agent' => Security::getUserAgent()
        ]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Thank you! Your suggestion has been received.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to submit suggestion. Please try again.']);
        }
        
    } catch(PDOException $e) {
        error_log("Suggestion Form Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again later.']);
    }
    exit();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['application_submit'])) {
    
    try {
      
        $studentName = Security::sanitizeInput($_POST['student_name'] ?? '');
        $parentName = Security::sanitizeInput($_POST['parent_name'] ?? '');
        $parentEmail = Security::sanitizeInput($_POST['parent_email'] ?? '');
        $parentPhone = Security::sanitizeInput($_POST['parent_phone'] ?? '');
        $class = Security::sanitizeInput($_POST['class'] ?? '');
        $previousSchool = Security::sanitizeInput($_POST['previous_school'] ?? '');
        $dateOfBirth = Security::sanitizeInput($_POST['date_of_birth'] ?? '');
        $gender = Security::sanitizeInput($_POST['gender'] ?? '');
        $address = Security::sanitizeInput($_POST['address'] ?? '');
        
        
        $errors = [];
        
        if (empty($studentName)) {
            $errors[] = "Student name is required";
        }
        
        if (empty($parentName)) {
            $errors[] = "Parent/Guardian name is required";
        }
        
        if (empty($parentEmail) || !Security::validateEmail($parentEmail)) {
            $errors[] = "Valid parent email is required";
        }
        
        if (empty($parentPhone) || !Security::validatePhone($parentPhone)) {
            $errors[] = "Valid parent phone is required";
        }
        
        if (empty($class)) {
            $errors[] = "Class selection is required";
        }
        
        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            header('Location: apply.html');
            exit();
        }
        
    
        $sql = "INSERT INTO applications (student_name, parent_guardian_name, parent_email, parent_phone, 
                class, previous_school, date_of_birth, gender, address) 
                VALUES (:student_name, :parent_name, :parent_email, :parent_phone, :class, 
                :previous_school, :date_of_birth, :gender, :address)";
        
        $stmt = $db->prepare($sql);
        $result = $stmt->execute([
            ':student_name' => $studentName,
            ':parent_name' => $parentName,
            ':parent_email' => $parentEmail,
            ':parent_phone' => $parentPhone,
            ':class' => $class,
            ':previous_school' => $previousSchool,
            ':date_of_birth' => $dateOfBirth ?: null,
            ':gender' => $gender ?: null,
            ':address' => $address
        ]);
        
        if ($result) {
            // Send confirmation email
            $emailSubject = 'Application Received - Amfus School';
            $emailBody = "Dear $parentName,\n\nThank you for applying to Amfus School. Your application for $studentName has been received.\n\nWe will review your application and contact you soon.\n\nBest regards,\nAmfus School";
            mail($parentEmail, $emailSubject, $emailBody);
            
            $_SESSION['success'] = "Application submitted successfully! We will contact you soon.";
        } else {
            $_SESSION['error'] = "Failed to submit application. Please try again.";
        }
        
    } catch(PDOException $e) {
        error_log("Application Form Error: " . $e->getMessage());
        $_SESSION['error'] = "An error occurred. Please try again later.";
    }
    
    header('Location: apply.html');
    exit();
}
?>