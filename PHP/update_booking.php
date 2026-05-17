<?php
session_start();

$id = $_POST['id'];
$room_type = $_POST['room_type'];
$location = $_POST['location'];
$checkin_date = $_POST['checkin_date'];
$checkout_date = $_POST['checkout_date'];
$comments = $_POST['comments'];
$email = $_SESSION['email'];

$conn = new mysqli('localhost', 'root', '', 'hotel');

function getPricePerNight($roomType) {
    switch ($roomType) {
        case "Deluxe Queen Room":
            return 150;
        case "Deluxe Twin Room":
            return 120;
        case "Deluxe Triple Room":
            return 180;
        case "Deluxe Family Room":
            return 200;
        default:
            return 0;
    }
}

$checkin = new DateTime($checkin_date);
$checkout = new DateTime($checkout_date);

$nights = $checkin->diff($checkout)->days;
$pricePerNight = getPricePerNight($room_type);
$totalPrice = $nights * $pricePerNight;

// Update booking table
$stmt = $conn->prepare("UPDATE booking_details 
                        SET room_type = ?, location = ?, checkin_date = ?, checkout_date = ?, comments = ?
                        WHERE id = ? AND email = ?");

$stmt->bind_param("sssssis", $room_type, $location, $checkin_date, $checkout_date, $comments, $id, $email);
$stmt->execute();
$stmt->close();

// Update payment table
$stmtPayment = $conn->prepare("UPDATE payment_details 
                               SET total_price = ?
                               WHERE booking_id = ?");

$stmtPayment->bind_param("di", $totalPrice, $id);
$stmtPayment->execute();
$stmtPayment->close();

$conn->close();

echo "<script>
alert('Booking updated successfully. Payment price also updated.');
window.location.href='../HTML/account.php';
</script>";
?>