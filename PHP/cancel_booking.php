<?php
session_start();

$id = $_POST['id'];
$email = $_SESSION['email'];

$conn = new mysqli('localhost', 'root', '', 'hotel');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete payment first
$stmtPayment = $conn->prepare("
    DELETE FROM payment_details
    WHERE booking_id = ?
");

$stmtPayment->bind_param("i", $id);
$stmtPayment->execute();
$stmtPayment->close();

// Delete booking
$stmtBooking = $conn->prepare("
    DELETE FROM booking_details
    WHERE id = ? AND email = ?
");

$stmtBooking->bind_param("is", $id, $email);
$stmtBooking->execute();
$stmtBooking->close();

$conn->close();

echo "<script>
alert('Booking and payment cancelled successfully.');
window.location.href='../HTML/account.php';
</script>";
?>