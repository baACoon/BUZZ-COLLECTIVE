<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Handle preflight request
    header("Access-Control-Allow-Origin: https://admin.buzzcollective.gayvar.com");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    exit(0);
}
// Allow from any origin
header("Access-Control-Allow-Origin: https://admin.buzzcollective.gayvar.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


// Security checks
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403);
    exit('Unauthorized');
}

// Get image path from query parameter and sanitize it
$imagePath = isset($_GET['path']) ? basename($_GET['path']) : '';
if (empty($imagePath)) {
    http_response_code(400);
    exit('Invalid request');
}

// Set the full path to your uploads directory
$fullPath = $_SERVER['DOCUMENT_ROOT'] . 'https://buzzcollective.gayvar.com/frontend/uploads/receipts/' . $imagePath;

// Validate the path and file existence
if (!file_exists($fullPath) || !is_file($fullPath)) {
    http_response_code(404);
    exit('File not found');
}

// Validate file extension (optional but recommended)
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
$fileExtension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
if (!in_array($fileExtension, $allowedExtensions)) {
    http_response_code(403);
    exit('Invalid file type');
}

// Get image mime type
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $fullPath);
finfo_close($finfo);

// Set proper headers
header('Content-Type: ' . $mimeType);
header('Content-Length: ' . filesize($fullPath));
header('Cache-Control: public, max-age=86400'); // Cache for 24 hours

// Output file
readfile($fullPath);
exit;