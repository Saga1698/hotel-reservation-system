<?php
session_start();
date_default_timezone_set("Asia/Kuala_Lumpur");

$today = date("Y-m-d");

$conn = new mysqli('localhost', 'root', '', 'hotel');

$bookedData = [];

$sql = "SELECT room_type, checkin_date, checkout_date FROM booking_details";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $roomType = $row['room_type'];

    $start = new DateTime($row['checkin_date']);
    $end = new DateTime($row['checkout_date']);

    while ($start < $end) {
        $bookedData[] = [
            "room_type" => $roomType,
            "date" => $start->format("Y-m-d")
        ];

        $start->modify("+1 day");
    }
}

$selectedRoom = $_GET['room_type'] ?? '';
$selectedLocation = $_GET['location'] ?? '';

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Room Booking - Hotel Reservate</title>
    <link rel="stylesheet" href="../CSS/booking.css">
    <script>

    let bookedData = <?php echo json_encode($bookedData); ?>;

    function isRoomBooked(roomType, dateString) {
        return bookedData.some(function(item) {
            return item.room_type === roomType && item.date === dateString;
        });
    }

    function checkUnavailableDate() {

        let roomType =
            document.getElementById("room_type").value;

        let checkin =
            document.getElementById("checkin_date").value;

        let checkout =
            document.getElementById("checkout_date").value;

        // Check check-in
        if (checkin && isRoomBooked(roomType, checkin)) {

            alert(roomType + " is unavailable on " + checkin);

            document.getElementById("checkin_date").value = "";

            return false;
        }

        // Check checkout date
        if (checkout && isRoomBooked(roomType, checkout)) {

            alert(roomType + " is unavailable on " + checkout);

            document.getElementById("checkout_date").value = "";

            return false;
        }

        // Check full date range
        if (checkin !== "" && checkout !== "") {

            let start = new Date(checkin);
            let end = new Date(checkout);

            while (start < end) {

                let dateString =
                    start.toISOString().split("T")[0];

                if (isRoomBooked(roomType, dateString)) {

                    alert(roomType + " is unavailable on " + dateString);

                    document.getElementById("checkin_date").value = "";
                    document.getElementById("checkout_date").value = "";

                    return false;
                }

                start.setDate(start.getDate() + 1);
            }
        }

        return true;
    }

    function checkPastDate() {
    let today = new Date().toISOString().split("T")[0];
    let checkin = document.getElementById("checkin_date").value;
    let checkout = document.getElementById("checkout_date").value;

    if (checkin && checkin < today) {
        alert("Check-in date cannot be before today.");
        document.getElementById("checkin_date").value = "";
        return false;
    }

    if (checkout && checkout < today) {
        alert("Check-out date cannot be before today.");
        document.getElementById("checkout_date").value = "";
        return false;
    }

    return true;
    }

    function updateLocationOptions() {
        let roomType = document.getElementById("room_type").value;
        let location = document.getElementById("location");

        let perakOption = location.querySelector('option[value="Perak"]');
        let penangOption = location.querySelector('option[value="Penang"]');

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
        else {
            location.value = "";
        }
    }

    function calculatePrice() {
        var checkinValue = document.getElementById("checkin_date").value;
        var checkoutValue = document.getElementById("checkout_date").value;
        var roomType = document.getElementById("room_type").value;

        if (checkinValue === "" || checkoutValue === "") {
            document.getElementById("total_price").innerText = "Total Price: RM 0";
            document.getElementById("total_price_input").value = 0;
            return true;
        }

        var checkinDate = new Date(checkinValue);
        var checkoutDate = new Date(checkoutValue);

        var numberOfNights = Math.ceil(
            (checkoutDate - checkinDate) / (1000 * 60 * 60 * 24)
        );

        if (numberOfNights <= 0) {
            alert("Check-out date must be after check-in date.");
            document.getElementById("total_price").innerText = "Total Price: RM 0";
            document.getElementById("total_price_input").value = 0;
            return false;
        }

        var pricePerNight = getPricePerNight(roomType);
        var totalPrice = 0;

        var currentDate = new Date(checkinDate);

        while (currentDate < checkoutDate) {
            var dateString = formatDate(currentDate);

            if (isMalaysiaHoliday(dateString)) {
                totalPrice += pricePerNight * 1.3;
            } else {
                totalPrice += pricePerNight;
            }

            currentDate.setDate(currentDate.getDate() + 1);
        }

        totalPrice = Math.round(totalPrice);

        document.getElementById("total_price").innerText = "Total Price: RM " + totalPrice;
        document.getElementById("total_price_input").value = totalPrice;

        return true;
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

    function formatDate(date) {
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, "0");
        var day = String(date.getDate()).padStart(2, "0");

        return year + "-" + month + "-" + day;
    }

    function isMalaysiaHoliday(dateString) {
        var malaysiaHolidays = [
            "2026-01-01",
            "2026-02-17",
            "2026-02-18",
            "2026-03-20",
            "2026-03-21",
            "2026-05-01",
            "2026-05-27",
            "2026-06-01",
            "2026-08-31",
            "2026-09-16",
            "2026-11-08",
            "2026-12-25"
        ];

        return malaysiaHolidays.includes(dateString);
    }
    </script>
</head>

<body onload="updateLocationOptions()">
    <header>
        <h1>Booking Details</h1>
    </header>

        <h2>Book Your Room</h2>
        <form action="../HTML/payment.php" method="post" onsubmit="return checkPastDate() && checkUnavailableDate() && calculatePrice()">
            <div class="form-group">
                <label for="fullname">Name:</label>
                <input type="text"
                id="fullname"
                name="fullname"
                value="<?php echo $_SESSION['username'] ?? ''; ?>"
                required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email"
                id="email"
                name="email"
                value="<?php echo $_SESSION['email'] ?? ''; ?>"
                required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="phone" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="checkin_date">Check-In Date:</label>
                <input type="date" id="checkin_date" name="checkin_date" min="<?php echo $today; ?>" onchange="checkUnavailableDate(); calculatePrice()" required>
            </div>

            <div class="form-group">
                <label for="checkout_date">Check-Out Date:</label>
                <input type="date" id="checkout_date" name="checkout_date" min="<?php echo $today; ?>" onchange="checkUnavailableDate(); calculatePrice()" required>
            </div>

            <div class="form-group">
                <label for="room_type">Room Type:</label>
                <select id="room_type" name="room_type" onchange="updateLocationOptions(); checkUnavailableDate(); calculatePrice()" required>
                    <option value="Deluxe Queen Room" <?php if($selectedRoom == "Deluxe Queen Room") echo "selected"; ?>>Deluxe Queen Room</option>
                    <option value="Deluxe Twin Room" <?php if($selectedRoom == "Deluxe Twin Room") echo "selected"; ?>>Deluxe Twin Room</option>
                    <option value="Deluxe Triple Room" <?php if($selectedRoom == "Deluxe Triple Room") echo "selected"; ?>>Deluxe Triple Room</option>
                    <option value="Deluxe Family Room" <?php if($selectedRoom == "Deluxe Family Room") echo "selected"; ?>>Deluxe Family Room</option>
                </select>
            </div>

            <div class="form-group">
                <label for="location">Location:</label>
                <select id="location" name="location" required>
                    <option value="">Select Location</option>
                    <option value="Perak" <?php if($selectedLocation == "Perak") echo "selected"; ?>>Perak</option>
                    <option value="Penang" <?php if($selectedLocation == "Penang") echo "selected"; ?>>Penang</option>
                </select>
            </div>

            <div class="form-group">
                <label for="comments">Additional Comments:</label>
                <textarea id="comments" name="comments"></textarea>
            </div>

            <p id="total_price">Total Price: RM0</p>

            <input type="hidden" id="total_price_input" name="total_price" value="0">

            <input type="submit" id="submit" name="Submit" value="Book Now">

            <input type="submit"
            value="Back"
            class="back-button"
            onclick="history.back()"
            style="margin-right: 10px;">
            </form>


    </body>

</html>