<?php
$cardNumber = $_POST["card_number"];
$expiryDate = $_POST["expiry_date"];
$cvv = $_POST["cvv"];
$cardholderName = $_POST["cardholder_name"];

$fullname = $_POST["fullname"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$checkin_date = $_POST["checkin_date"];
$checkout_date = $_POST["checkout_date"];
$room_type = $_POST["room_type"];
$location = $_POST["location"];
$comments = $_POST["comments"];
$totalPrice = $_POST["total_price"];

$conn = new mysqli('localhost', 'root', '', 'hotel');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert booking first
$stmtBooking = $conn->prepare("INSERT INTO booking_details(fullname, email, phone, checkin_date, checkout_date, room_type, location, comments) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmtBooking->bind_param("ssssssss", $fullname, $email, $phone, $checkin_date, $checkout_date, $room_type, $location, $comments);
$stmtBooking->execute();
// Get booking id
$booking_id = $conn->insert_id;
$stmtBooking->close();


// Insert payment with booking_id
$stmtPayment = $conn->prepare("INSERT INTO payment_details(booking_id, card_number, expiry_date, cvv, cardholder_name, total_price) VALUES (?, ?, ?, ?, ?, ?)");
$stmtPayment->bind_param("issssd", $booking_id, $cardNumber, $expiryDate, $cvv, $cardholderName, $totalPrice);
$stmtPayment->execute();
$stmtPayment->close();

$conn->close();

echo "<script>
alert('Booking and Payment Successful.');
window.location.href='../HTML/room.php';
</script>";
?>