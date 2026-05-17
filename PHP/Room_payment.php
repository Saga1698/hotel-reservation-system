<?php
// process_booking.php

// Validate and sanitize form inputs (e.g., check for empty fields, validate dates, sanitize inputs)

// Connect to the database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "hotel_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement to insert booking data into the database
$stmt = $conn->prepare("INSERT INTO bookings (room_type, check_in_date, check_out_date, guests, comments) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssis", $room_type, $check_in_date, $check_out_date, $guests, $comments);

// Set parameters and execute the statement
$room_type = "Single Room"; // Example, replace with actual room type
$check_in_date = $_POST["check-in-date"];
$check_out_date = $_POST["check-out-date"];
$guests = $_POST["guests"];
$comments = $_POST["comments"];

$stmt->execute();

$stmt->close();
$conn->close();

// Send response to the client
echo "Booking successful!";
?>