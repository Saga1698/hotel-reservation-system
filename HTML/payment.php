<?php
$fullname = $_POST['fullname'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$checkin_date = $_POST['checkin_date'] ?? '';
$checkout_date = $_POST['checkout_date'] ?? '';
$room_type = $_POST['room_type'] ?? '';
$location = $_POST['location'] ?? '';
$comments = $_POST['comments'] ?? '';
$total_price = $_POST['total_price'] ?? '0';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment - Hotel Reservate</title>
    <link rel="stylesheet" href="../CSS/payment.css">
</head>

<body>
    <header>
        <h1>Payment Details</h1>
    </header>

    <h2>Enter Payment Information</h2>

    <form action="../PHP/process_payment.php" method="post">

        <input type="hidden" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <input type="hidden" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
        <input type="hidden" name="checkin_date" value="<?php echo htmlspecialchars($checkin_date); ?>">
        <input type="hidden" name="checkout_date" value="<?php echo htmlspecialchars($checkout_date); ?>">
        <input type="hidden" name="room_type" value="<?php echo htmlspecialchars($room_type); ?>">
        <input type="hidden" name="location" value="<?php echo htmlspecialchars($location); ?>">
        <input type="hidden" name="comments" value="<?php echo htmlspecialchars($comments); ?>">
        <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($total_price); ?>">

        <div class="form-group">
            <label for="card_number">Card Number:</label>
            <input type="text" id="card_number" name="card_number" required>
        </div>

        <div class="form-group">
            <label for="expiry_date">Expiry Date:</label>
            <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY" required>
        </div>

        <div class="form-group">
            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" required>
        </div>

        <div class="form-group">
            <label for="cardholder_name">Cardholder Name:</label>
            <input type="text" id="cardholder_name" name="cardholder_name" required>
        </div>

        <p>Total Price: $<?php echo htmlspecialchars($total_price); ?></p>

        <input type="submit" id="submit" name="Submit" value="Pay Now">

            <input type="submit"
            value="Back"
            class="back-button"
            onclick="history.back()"
            style="margin-left: 10px;">
            </form>
        
    </form>
</body>
</html>