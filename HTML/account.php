<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

$conn = new mysqli('localhost', 'root', '', 'hotel');

$sql = "SELECT 
            booking_details.*,
            payment_details.card_number,
            payment_details.cvv,
            payment_details.total_price
        FROM booking_details
        LEFT JOIN payment_details
        ON booking_details.id = payment_details.booking_id
        WHERE booking_details.email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

//booking date checker
$bookedData = [];
$sqlBooked = "SELECT id, room_type, checkin_date, checkout_date 
              FROM booking_details";

$resultBooked = $conn->query($sqlBooked);

while ($booked = $resultBooked->fetch_assoc()) {

    $start = new DateTime($booked['checkin_date']);
    $end = new DateTime($booked['checkout_date']);

    while ($start < $end) {

        $bookedData[] = [
            "booking_id" => $booked['id'],
            "room_type" => $booked['room_type'],
            "date" => $start->format("Y-m-d")
        ];

        $start->modify("+1 day");
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <link rel="stylesheet" href="../CSS/Component.css">
    <link rel="stylesheet" href="../CSS/account.css">
</head>
<body>

<header>
    <h1 class="logo">My Account</h1>
    <?php include 'header.inc'; ?>
</header>

<br><br><br><br><br>
<div class="account-container">

    <h2>My Booking List</h2>

    <table class="booking-table">
        <tr>
            <th>ID</th>
            <th>Room Type</th>
            <th>Location</th>
            <th>Check-In</th>
            <th>Check-Out</th>
            <th>Comments</th>
            <th>Card Number</th>
            <th>CVV</th>
            <th>Total Price</th>
            <th>Action</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr data-booking-id="<?php echo $row['id']; ?>">
            <form action="../PHP/update_booking.php" method="post">
                <td>
                    <?php echo $row['id']; ?>
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                </td>

                <td>
                    <select name="room_type" class="room-type" onchange="updateRowPrice(this)">
                        <option value="Deluxe Queen Room" <?php if($row['room_type']=="Deluxe Queen Room") echo "selected"; ?>>Deluxe Queen Room</option>
                        <option value="Deluxe Twin Room" <?php if($row['room_type']=="Deluxe Twin Room") echo "selected"; ?>>Deluxe Twin Room</option>
                        <option value="Deluxe Triple Room" <?php if($row['room_type']=="Deluxe Triple Room") echo "selected"; ?>>Deluxe Triple Room</option>
                        <option value="Deluxe Family Room" <?php if($row['room_type']=="Deluxe Family Room") echo "selected"; ?>>Deluxe Family Room</option>
                    </select>
                </td>

                <td>
                    <select name="location" class="location-select">
                        <option value="Perak" <?php if($row['location']=="Perak") echo "selected"; ?>>Perak</option>
                        <option value="Penang" <?php if($row['location']=="Penang") echo "selected"; ?>>Penang</option>
                    </select>
                </td>

                <td>
                    <input type="date" name="checkin_date" class="checkin-date" value="<?php echo $row['checkin_date']; ?>" onchange="updateRowPrice(this)">
                </td>

                <td>
                    <input type="date" name="checkout_date" class="checkout-date" value="<?php echo $row['checkout_date']; ?>" onchange="updateRowPrice(this)">
                </td>

                <td>
                    <input type="text" name="comments" value="<?php echo htmlspecialchars($row['comments']); ?>">
                </td>

                <td>
                    <input type="text" name="card_number" value="<?php echo htmlspecialchars($row['card_number']); ?>">
                </td>

                <td>
                    <input type="text" name="cvv" value="<?php echo htmlspecialchars($row['cvv']); ?>">
                </td>

                <td>
                    <input type="text"
                        name="total_price"
                        class="total-price"
                        value="<?php echo htmlspecialchars($row['total_price']); ?>"
                        disabled>
                </td>

                <td>
                    <button type="submit" class="update-btn">Modify</button>
            </form>

                    <form action="../PHP/cancel_booking.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="cancel-btn" onclick="return confirm('Cancel this booking?')">
                            Cancel
                        </button>
                    </form>
                </td>
        </tr>
        <?php } ?>

    </table>

</div>

<script>

let bookedData = <?php echo json_encode($bookedData); ?>;


function updateLocationOptions(row) {
    let roomType =
        row.querySelector(".room-type").value;
    let location =
        row.querySelector(".location-select");
    let perakOption =
        location.querySelector('option[value="Perak"]');
    let penangOption =
        location.querySelector('option[value="Penang"]');
    perakOption.hidden = false;
    penangOption.hidden = false;

    if (roomType === "Deluxe Queen Room") {
        penangOption.hidden = true;
        location.value = "Perak";
    }

    else if (roomType === "Deluxe Family Room") {
        perakOption.hidden = true;
        location.value = "Penang";
    }
}


function getPricePerNight(roomType) {
    switch (roomType) {
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

function isRoomBooked(roomType, dateString, currentBookingId) {
    return bookedData.some(function(item) {
        return item.room_type === roomType &&
               item.date === dateString &&
               item.booking_id != currentBookingId;
    });
}

function updateRowPrice(element) {

    let row = element.closest("tr");
    updateLocationOptions(row);
    let bookingId = row.dataset.bookingId;
    let roomType =
        row.querySelector(".room-type").value;
    let checkin =
        row.querySelector(".checkin-date").value;
    let checkout =
        row.querySelector(".checkout-date").value;
    let totalPriceInput =
        row.querySelector(".total-price");

    if (checkin === "" || checkout === "") {

        totalPriceInput.value = 0;
        return;
    }

    let checkinDate = new Date(checkin);
    let checkoutDate = new Date(checkout);
    let nights = Math.ceil(
        (checkoutDate - checkinDate) /
        (1000 * 60 * 60 * 24)
    );
    if (nights <= 0) {
        alert("Check-out date must be after check-in date.");
        totalPriceInput.value = 0;
        return;
    }

    let start = new Date(checkin);
    while (start < checkoutDate) {
        let dateString =
            start.toISOString().split("T")[0];
        if (isRoomBooked(roomType, dateString, bookingId)) {

            alert(roomType + " is already booked on " + dateString);

            row.querySelector(".checkin-date").value = "";
            row.querySelector(".checkout-date").value = "";

            totalPriceInput.value = 0;

            return;
        }
        start.setDate(start.getDate() + 1);
    }
    let pricePerNight =
        getPricePerNight(roomType);

    let totalPrice =
        nights * pricePerNight;

    totalPriceInput.value = totalPrice;
}

</script>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>