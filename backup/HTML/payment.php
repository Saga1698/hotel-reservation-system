<!DOCTYPE html>
<html>
<head>
    <title>Payment - Hotel Reservate</title>
    <link rel="stylesheet" href="../CSS/payment.css">
    <script>
        // JavaScript function to retrieve and display the total price
        function displayTotalPrice() {
            // Retrieve the total price from the hidden input field
            var totalPrice = document.getElementById("total_price_input").value;


            // Display the total price on the payment page
            document.getElementById("total_price").innerText = "Total Price: $" + totalPrice;
        }
    </script>
</head>
<body onload="displayTotalPrice()"> <!-- Call the function when the page loads -->
    <header>
        <h1>Payment Details</h1>
    </header>


    <h2>Enter Payment Information</h2>
    <!-- Payment form -->
    <form action="../PHP/process_payment.php" method="post">
         <!-- Include hidden input fields to pass booking details -->
         <input type="hidden" id="fullname" name="fullname" value="<?php echo htmlspecialchars($_POST['fullname']); ?>" required>
         <input type="hidden" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email']); ?>" required>
         <input type="hidden" id="phone" name="phone" value="<?php echo htmlspecialchars($_POST['phone']); ?>" required>
         <input type="hidden" id="checkin_date" name="checkin_date" value="<?php echo htmlspecialchars($_POST['checkin_date']); ?>" required>
         <input type="hidden" id="checkout_date" name="checkout_date" value="<?php echo htmlspecialchars($_POST['checkout_date']); ?>" required>
         <input type="hidden" id="comments" name="comments" value="<?php echo htmlspecialchars($_POST['comments']); ?>">
         <input type="hidden" id="total_price_input" name="total_price" value="<?php echo htmlspecialchars($_POST['total_price']); ?>">


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


        <!-- Display the total price here -->
        <div id="total_price_input"></div>


        <input type="submit" id="submit" name="Submit"> <br><br>
    </form>

</body>
</html>

