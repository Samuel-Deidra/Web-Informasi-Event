<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbevent";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

// Function to sanitize input
function sanitizeInput($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = $conn->real_escape_string($data);
    return $data;
}

// Function to handle file upload
function handleFileUpload($file, $uploadDir = 'uploads/') {
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['status' => false, 'message' => 'No file uploaded'];
    }
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['status' => false, 'message' => 'File upload error'];
    }
    
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
    $fileType = $file['type'];
    
    if (!in_array($fileType, $allowedTypes)) {
        return ['status' => false, 'message' => 'Invalid file type'];
    }
    
    $maxSize = 5 * 1024 * 1024;
    if ($file['size'] > $maxSize) {
        return ['status' => false, 'message' => 'File too large'];
    }
    
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $uniqueFilename = uniqid('logo_', true) . '.' . $fileExtension;
    $targetPath = $uploadDir . $uniqueFilename;
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['status' => true, 'filename' => $uniqueFilename];
    } else {
        return ['status' => false, 'message' => 'Failed to move uploaded file'];
    }
}

// Function to delete file
function deleteFile($filename, $uploadDir = 'uploads/') {
    $filePath = $uploadDir . $filename;
    if (file_exists($filePath)) {
        return unlink($filePath);
    }
    return false;
}

// ========================================
// CREATE - Add New Event
// ========================================
if (isset($_POST['addevent'])) {
    // ... rest of your code
}