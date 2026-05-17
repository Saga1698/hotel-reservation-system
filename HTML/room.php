<?php
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

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Room Types - Hotel Reservate</title>
    <link rel="stylesheet" href="../CSS/rooms.css">
    <link rel="stylesheet" href="../CSS/Component.css">
</head>

<body>
<header>
    <h1 class="logo">Rooms</h1>
    <nav>
        <ul class="navigation">
            <?php include 'header.inc' ?>
        </ul>
    </nav>

    <div class="search-container">

        <input type="text"
               id="searchRoom"
               onkeyup="searchRoom()"
               placeholder="Search room...">

        <select id="locationFilter" onchange="searchRoom()">
            <option value="">All Locations</option>
            <option value="perak">Perak</option>
            <option value="penang">Penang</option>
        </select>

        <input type="date"
               id="fromDate"
               min="<?php echo $today; ?>"
               onchange="searchRoom()">

        <input type="date"
               id="toDate"
               min="<?php echo $today; ?>"
               onchange="searchRoom()">

    </div>
</header>

<div class="room-types">
    <div class="room-grid">

        <div class="Single room-card">
            <img src="../IMG/DeluxeQueen.jpg" alt="Single Room"><br><br>
            <h3>Deluxe Queen Room</h3><br>
            <li>1 Queen Bed</li>
            <li>Room size: 13 m²/140 ft²</li>
            <li>Free WiFi</li>
            <li class="location">Perak</li>
            <br><br><br>
            <a href="booking.php?room_type=Deluxe Queen Room&location=Perak" class="book-now-button">Book Now</a>
        </div>

        <div class="Double room-card">
            <img src="../IMG/DeluxeTwin.jpg" alt="Single Room"><br><br>
            <h3>Deluxe Twin Room</h3><br>
            <li>2 Single Bed</li>
            <li>Room size: 10 m²/108 ft²</li>
            <li>Free WiFi</li>
            <li class="location">Perak & Penang</li>
            <br><br><br>
            <a href="booking.php?room_type=Deluxe Twin Room" class="book-now-button">Book Now</a>
        </div>

        <div class="Triple room-card">
            <img src="../IMG/DeluxeTriple.jpg" alt="Single Room"><br><br>
            <h3>Deluxe Triple Room</h3><br>
            <li>1 Single bed and 1 Queen bed</li>
            <li>Room size: 15 m²/161 ft²</li>
            <li>City View</li>
            <li class="location">Perak & Penang</li>
            <br><br><br>
            <a href="booking.php?room_type=Deluxe Triple Room" class="book-now-button">Book Now</a>
        </div>

        <div class="Family room-card">
            <img src="../IMG/DeluxeFamily.jpg" alt="Single Room"><br><br>
            <h3>Deluxe Family Room</h3><br>
            <li>1 queen bed and 1 double bed</li>
            <li>Room size: 20 m²/215ft²</li>
            <li>Balcony/terrace</li>
            <li class="location">Penang</li>
            <br><br><br>
            <a href="booking.php?room_type=Deluxe Family Room&location=Penang" class="book-now-button">Book Now</a>
        </div>

    </div>
</div>

<script>
let bookedData = <?php echo json_encode($bookedData); ?>;

function isRoomAvailable(roomType, fromDate, toDate) {
    if (fromDate === "" || toDate === "") {
        return true;
    }

    let start = new Date(fromDate);
    let end = new Date(toDate);

    if (end <= start) {
        return false;
    }

    while (start < end) {
        let dateString = start.toISOString().split("T")[0];

        let booked = bookedData.some(function(item) {
            return item.room_type === roomType &&
                   item.date === dateString;
        });

        if (booked) {
            return false;
        }

        start.setDate(start.getDate() + 1);
    }

    return true;
}

function searchRoom() {
    let input = document.getElementById("searchRoom").value.toLowerCase();
    let selectedLocation = document.getElementById("locationFilter").value.toLowerCase();
    let fromDate = document.getElementById("fromDate").value;
    let toDate = document.getElementById("toDate").value;

    let rooms = document.querySelectorAll(".room-card");

    rooms.forEach(function(room) {
        let roomTitle = room.querySelector("h3").innerText;
        let roomTitleLower = roomTitle.toLowerCase();
        let roomLocation = room.querySelector(".location").innerText.toLowerCase();

        let matchesSearch = roomTitleLower.includes(input);

        let matchesLocation =
            selectedLocation === "" ||
            roomLocation.includes(selectedLocation);

        let matchesDate =
            isRoomAvailable(roomTitle, fromDate, toDate);

        if (matchesSearch && matchesLocation && matchesDate) {
            room.style.display = "block";
        } else {
            room.style.display = "none";
        }
    });
}
</script>

</body>
</html>