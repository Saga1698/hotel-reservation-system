<?php
    // Retrieve form data
    $cardNumber = $_POST["card_number"];
    $expiryDate = $_POST["expiry_date"];
    $cvv = $_POST["cvv"];
    $cardholderName = $_POST["cardholder_name"];


    // Simulate a successful payment
    $paymentSuccessful = true;


    if ($paymentSuccessful) {  
        // Retrieve booking details from the POST request
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $checkin_date = $_POST['checkin_date'];
        $checkout_date = $_POST['checkout_date'];
        $comments = $_POST['comments'];
        $totalPrice = $_POST['total_price']; // Retrieve total price from hidden input
       
        // Create connection to the database
        $conn = new mysqli('localhost', 'root', '', 'hotel');
   
        // Check for connection
        if ($conn->connect_error) {
            echo "$conn->connect_error";
            die("Connection failed :". $conn->connect_error);
        } else {
            // Prepare and bind the SQL statement for inserting payment details
            $stmt = $conn->prepare("INSERT INTO payment_details(card_number, expiry_date, cvv, cardholder_name) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $cardNumber, $expiryDate, $cvv, $cardholderName);
            $stmt->execute();
            $stmt->close();


            // Close connection
            $conn->close();


            echo "<script>alert('Booking Successful.');
            window.location.href='../HTML/room.php';</script>";
        }
    } else {
        // Payment failed
        echo "Payment failed. Please check your payment details and try again.";
    }
?>
