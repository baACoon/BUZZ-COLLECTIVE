// debug.php
<?php
echo "<h2>Server Paths:</h2>";
echo "<pre>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "\n";
echo "Upload Directory: " . $_SERVER['DOCUMENT_ROOT'] . "/BUZZ-COLLECTIVE/uploads/\n";
echo "</pre>";

echo "<h2>Uploaded Files:</h2>";
$upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/BUZZ-COLLECTIVE/uploads/";
$files = scandir($upload_dir);
echo "<pre>";
print_r($files);
echo "</pre>";

echo "<h2>Database Records:</h2>";
$conn = new mysqli("localhost", "root", "", "barbershop");
$result = $conn->query("SELECT * FROM payments");
echo "<pre>";
while ($row = $result->fetch_assoc()) {
    print_r($row);
}
echo "</pre>";
?>