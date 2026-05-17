<?php
    // Retrieve form data
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $checkin_date = $_POST["checkin_date"];
    $checkout_date = $_POST["checkout_date"];
    $comments = $_POST["comments"];


    //Create Connection
    $conn = new mysqli('localhost', 'root', '', 'hotel');


    //Check for connection
    if($conn->connect_error){
        echo "$conn->connect_error";
        die("Connection failed :". $conn->connect_error);
    }else{
    $stmt = $conn->prepare("insert into booking_details(fullname, email, phone, checkin_date, checkout_date, comments) values (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisss", $fullname, $email, $phone, $checkin_date, $checkout_date, $comments);
    $execval = $stmt->execute();
    echo "<script>alert('Booking Successful.');
    window.location.href='../HTML/payment.php';</script>";
    $stmt->close();
    $conn->close();
    }
?>

