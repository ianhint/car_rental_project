<?php
// Connection with mySQL

$conn = new mysqli("localhost", "root", "", "car_rental_db");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// $user = $conn->query("SELECT * FROM cars");

// var_dump($user->fetch_assoc());
