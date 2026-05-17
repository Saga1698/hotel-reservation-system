<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update query
$sql = "UPDATE registered_user 
        SET username='ell' 
        WHERE username='mnngell'";

if ($conn->query($sql) === TRUE) {

    echo "<script>
        alert('Record updated successfully');
        window.location.href='../HTML/account.php';
    </script>";

} else {

    echo "Error updating record: " . $conn->error;

}

$conn->close();

?>