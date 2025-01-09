<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Origin: https://admin.buzzcollective.gayvar.com");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    exit(0);
}

header("Access-Control-Allow-Origin: https://admin.buzzcollective.gayvar.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// For debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Set the full path to your uploads directory with correct path
$fullPath = $_SERVER['DOCUMENT_ROOT'] . 'https://buzzcollective.gayvar.com/Buzz-collective/frontend/uploads/receipts/' . $imagePath;

// Debug information
error_log("Attempting to access file: " . $fullPath);

// Validate the path and file existence
if (!file_exists($fullPath)) {
    error_log("File not found at: " . $fullPath);
    http_response_code(404);
    exit('File not found at: ' . $fullPath);
}

// Validate file extension
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
header('Cache-Control: public, max-age=86400');

// Output file
readfile($fullPath);
exit;