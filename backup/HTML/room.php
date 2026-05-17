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
    </header>

    <div class="room-types"> <br>
        <h2 align = "center">Room</h2> <br>
        <div class="room-grid">
          <div class="Single">
            <h3>Deluxe Queen Room</h3><br>
            <img src="../IMG/DeluxeQueen.jpg" alt="Single Room"><br><br>
                <li>1 Queen Bed</li>
                <li>Room size: 13 m²/140 ft²</li>
                <li>Free WiFi</li> <br><br><br>
            <a href="booking.php" class="book-now-button">Book Now</a>
          </div>

          
            <div class="Double">
                <h3>Deluxe Twin Room</h3><br>
                <img src="../IMG/DeluxeTwin.jpg" alt="Single Room"><br><br>
                <li>2 Single Bed</li>
                <li>Room size: 10 m²/108 ft²</li>
                <li>Free WiFi</li> <br><br><br>
                <a href="booking.php" class="book-now-button">Book Now</a>
            </div>

            <div class="Triple">
                <h3>Deluxe Triple Room</h3><br>
                <img src="../IMG/DeluxeTriple.jpg" alt="Single Room"><br><br>
                <li>1 Single bed and 1 Queen bed</li>
                <li>Room size: 15 m²/161 ft²</li>
                <li>City View</li> <br><br><br>
                <a href="booking.php" class="book-now-button">Book Now</a>
            </div>

            <div class="Family">
                <h3>Deluxe Family Room</h3><br>
                <img src="../IMG/DeluxeFamily.jpg" alt="Single Room"><br><br>
                <li>1 queen bed and 1 double bed</li>
                <li>Room size: 20 m²/ 215ft²</li>
                <li>Balcony/terrace</li> <br><br><br>
                <a href="booking.php" class="book-now-button">Book Now</a>
            </div>

            
        </div>

</body>
</html>