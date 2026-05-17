<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $conn = new mysqli('localhost', 'root', '', 'hotel');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO registered_user(username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $email);

    if ($stmt->execute()) {
        echo "<script>
            alert('Registration Successfully.');
            window.location.href='../HTML/login.php';
        </script>";
    } else {
        echo "<script>
            alert('Registration failed.');
            window.history.back();
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>