<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){

        //Retireve from data
        $email = $_POST['email'];
        $password = $_POST['password'];

        //Database Connection
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "hotel";

        //Create connection
        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        //Check for connection
        if($conn->connect_error){
            die("Connection failed :". $conn->connect_error);
        }

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $password = mysqli_real_escape_string($conn, $password);

        $sql = "SELECT * FROM registered_user WHERE email = ? AND password = ? AND is_admin = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "<script>alert('Login Successfully as Admin.');
                  window.location.href='../PHP/user_table.php'</script>";
          } else {
            // Check for regular user login (optional)
            $sql_user = "SELECT * FROM registered_user WHERE email = ? AND password = ?";
            $stmt_user = $conn->prepare($sql_user);
            $stmt_user->bind_param("ss", $email, $password);
            $stmt_user->execute();
            $result_user = $stmt_user->get_result(); // Replace with prepared statement execution
        
            if ($result_user->num_rows > 0) {
              echo "<script>alert('Login Successfully.');
                    window.location.href='../HTML/MainPage.php'</script>";
            } else {
              echo "<script>alert('Login Failed.');
                    window.history.back();</script>";
            }
          }
        
          $stmt->close(); // Close prepared statement (if used)
          $conn->close();
        }
    //     $query = "SELECT * FROM registered_user WHERE email='$email' AND password='$password'";

    //     if (mysqli_num_rows($result) > 0 && strpos($email, "@admin.com") !== false) {
    //         echo "<script>alert('Login Successfully.');
    //         window.location.href='../HTML/AdminMenu.html'</script>";
    //     } else if (mysqli_num_rows($result)>0) {
    //         echo "<script>alert('Login Successfully.');
    //         window.location.href='../HTML/MainPage.html'</script>";
    //     } else {
    //         echo "<script>alert('Login Failed.');
    //         window.history.back();</script>"; 
    //     }

    //     $result = $conn->query($query);

    //     $conn->close();
    // }
?>