<!DOCTYPE html>
<html>
<head>
    <title>Room Booking - Hotel Reservate</title>
    <link rel="stylesheet" href="../CSS/booking.css">
    <script>
        
        function calculatePrice() {
            
            var checkinDate = new Date(document.getElementById("checkin_date").value);
            var checkoutDate = new Date(document.getElementById("checkout_date").value);
            var numberOfNights = Math.ceil((checkoutDate - checkinDate) / (1000 * 60 * 60 * 24)); 

            var roomType = document.getElementById("room_type").value;
            var pricePerNight = getPricePerNight(roomType);

            var totalPrice = numberOfNights * pricePerNight;

            document.getElementById("total_price").innerText = "Total Price: $" + totalPrice;

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

    </script>
</head>

<body>
    <header>
        <h1>Booking Details</h1>
    </header>

        <h2>Book Your Room</h2>
        <form action="../PHP/process_booking.php" method="post" onsubmit="return calculatePrice()">
            <div class="form-group">
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="phone" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="checkin_date">Check-In Date:</label>
                <input type="date" id="checkin_date" name="checkin_date" required>
            </div>

            <div class="form-group">
                <label for="checkout_date">Check-Out Date:</label>
                <input type="date" id="checkout_date" name="checkout_date" required>
            </div>

            <div class="form-group">
                <label for="room_type">Room Type:</label>
                <select id="room_type" name="room_type" onchange="calculatePrice()" required>
                    <option value="Deluxe Queen Room">Deluxe Queen Room</option>
                    <option value="Deluxe Twin Room">Deluxe Twin Room</option>
                    <option value="Deluxe Triple Room">Deluxe Triple Room</option>
                    <option value="Deluxe Family Room">Deluxe Family Room</option>
                </select>
            </div>

            <div class="form-group">
                <label for="comments">Additional Comments:</label>
                <textarea id="comments" name="comments"></textarea>
            </div>

            <br><br><br><br><br><input type="hidden" id="total_price_input" name="total_price">

            <input type="submit" id="submit" name="Submit">

        </form>

    </body>

</html>