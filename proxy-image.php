<?php
session_start();

// Handle CORS preflight
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Origin: https://admin.buzzcollective.gayvar.com");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    http_response_code(200);
    exit;
}

// Set CORS headers
header("Access-Control-Allow-Origin: https://admin.buzzcollective.gayvar.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    error_log("Unauthorized access attempt to proxy-image.php HAYS!! ");
    http_response_code(403);
    exit('Unauthorized');
}

// Sanitize and validate the file path
$imagePath = isset($_GET['path']) ? basename($_GET['path']) : '';
if (empty($imagePath) || !preg_match('/^[a-zA-Z0-9_.-]+$/', $imagePath)) {
    http_response_code(400);
    exit('Invalid file name');
}

// Full path to the uploads directory
$uploadsDir = $_SERVER['DOCUMENT_ROOT'] . '/../../frontend/uploads/receipts/';
$fullPath = $uploadsDir . $imagePath;

// Validate the file
if (!file_exists($fullPath)) {
    error_log("File not found: " . $fullPath);
    http_response_code(404);
    exit('File not found');
}

// Validate the file extension
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
$fileExtension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
if (!in_array($fileExtension, $allowedExtensions)) {
    error_log("Invalid file type attempted: " . $fileExtension);
    http_response_code(403);
    exit('Invalid file type');
}

// Determine MIME type
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $fullPath);
finfo_close($finfo);

// Set headers and serve the file
header('Content-Type: ' . $mimeType);
header('Content-Length: ' . filesize($fullPath));
header('Cache-Control: public, max-age=86400');
readfile($fullPath);
exit;
