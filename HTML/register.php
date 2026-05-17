<!DOCTYPE html>
<html>
<head>
    <title>Hotel Online Reservation System</title>
    <link rel="stylesheet" href="../CSS/login.css"> 
    <link rel="stylesheet" href="../CSS/Component.css">

</head>
<body>
    <header>
        <h1 class="logo"> Hotel</h1>
        <nav>
            <ul class="navigation">
            <?php include 'header.inc' ?>
            </ul>
        </nav>
    </header>
    
        <div class="wrapper">
            <div class="form-box login">
                <h2>Register</h2>
                <form action="../PHP/process_register.php" method="post">
                    <div class="input-box">
                        <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                        <input type="text" name="username" required>
                        <label>Username</label>
                    </div>
                
                    
                    <div class="input-box">
                        <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                        <input type="password" name="password"  required>
                        <label>Password</label>
                    </div>

                    <div class="input-box">
                        <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                        <input type="email" name="email" required>
                        <label>Email</label>
                    </div>

                    <div class="forgot">
                        <label>
                            <input type="checkbox" required>
                            I agree to the terms & conditions
                        </label>
                    </div>

                    <button type="submit" name="action" value="register">Register</button>

                    <div class="register">
                        <p>Already have an account?<a href="login.php" class="register-link">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>
