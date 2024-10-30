<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$target_dir = "uploads/";

if (isset($_POST["submit"]) && isset($_FILES["receipt"])) {
    if ($_FILES["receipt"]["error"] !== 0) {
        echo "Error uploading file: " . $_FILES["receipt"]["error"];
        exit();
    }

    $target_file = $target_dir . basename($_FILES["receipt"]["name"]);
    $fileExtension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["receipt"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        exit();
    }

    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        exit();
    }

    if ($_FILES["receipt"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        exit();
    }

    if (!in_array($fileExtension, ["jpg", "jpeg", "png", "gif"])) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        exit();
    }

    if (move_uploaded_file($_FILES["receipt"]["tmp_name"], $target_file)) {
        $conn = new mysqli("localhost", "root", "", "barbershop");
        
        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $receipt_name = basename($_FILES["receipt"]["name"]);
        $stmt = $conn->prepare("INSERT INTO payments (receipt, receipt_path) VALUES (?, ?)");
        $stmt->bind_param("ss", $receipt_name, $target_file);

        if ($stmt->execute()) {
            echo "The receipt " . htmlspecialchars($receipt_name) . " has been uploaded.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
} else {
    if (isset($_POST["submit"])) {
        echo "No file was uploaded or there was an error with the upload.";
    }
}
?>