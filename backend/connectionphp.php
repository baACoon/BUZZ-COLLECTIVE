<?php


$connection = "mysql:host=localhost;dbname=barbershop";
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO ($connection, $dbusername, $dbpassword);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION)

} catch(PDOException $e) {
    echo "connection failed: ". $e->getMessage();
    
}
 
?>