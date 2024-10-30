<?php
$target_dir = "uploads/receipts/";  // Folder to store uploaded images

// Check if form was submitted and file is uploaded
if (isset($_POST["submit"]) && isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {

    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        exit();
    }

    // Check if the file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        exit();
    }

    // Check file size (limit to 5MB)
    if ($_FILES["image"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        exit();
    }

    // Allow certain file formats (JPEG, PNG, JPG, GIF)
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        exit();
    }

    // Try to move the uploaded file to the target folder
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Save the file information in the database
        $conn = new mysqli("localhost", "root", "", "barbershop");  // Make sure credentials are correct

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $image_name = basename($_FILES["image"]["name"]);
        $sql = "INSERT INTO payments (receipt, receipt_path) VALUES ('$image_name', '$target_file')";

        if ($conn->query($sql) === TRUE) {
            echo "The file " . htmlspecialchars($image_name) . " has been uploaded and saved to the database.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

} else {
    if (isset($_POST["submit"])) {
        // Check for specific file upload error
        if (isset($_FILES["image"]["error"])) {
            echo "Error during file upload: " . $_FILES["image"]["error"];
        } else {
            echo "No file was uploaded or there was an error with the upload.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Receipt</title>
</head>
<body>
    <div class="receipt-upload">
        <form id="receiptForm" action="upload_receipt.php" method="POST" enctype="multipart/form-data">
            <label class="file-label">
                <input type="file" name="image" accept="image/*" required>
                <span id="file-label-text">UPLOAD RECEIPT</span>
            </label>
            <button type="submit" name="submit" class="submit-button">SUBMIT</button>
        </form>
    </div>
</body>
</html>