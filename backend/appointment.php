<?php
session_start();


$db = mysqli_connect('localhost', 'root', '', 'barbershop');

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $firstName = $_POST ['first_name'];
    $lastName = $_POST ['last_name'];
    $phonenumber = $_POST ['phone_num'];
    $email = $_POST ['email'];
    $barber = $_POST['barber'];
    $appointmentDate = $_POST ['appointment_date'];
    $appointmentTime = $_POST ['appointment_time'];
    $services = isset($_POST['services']) ? $_POST['services'] : [];

    // Convert the services array to a string to store in the database
    $servicesSerialized = serialize($services);

    $sql = "INSERT INTO appointments (first_name, last_name, phone_num, email, barber, appointment_date, appointment_time, services) VALUES ('$firstName', '$lastName', '$phonenumber', '$email',  '$barber', '$appointmentDate', '$appointmentTime', '$servicesSerialized')";

    if($db -> query($sql) === TRUE ){
        echo "NEW RECORD CREATED SUCCESFULLY";
    }else{
        echo "Error: ". $sql . "<br>" .$db->error;
    }
    $db->close();
}
?>