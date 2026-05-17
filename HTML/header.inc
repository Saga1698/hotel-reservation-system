<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navigation">
    <ul>

        <a href="MainPage.php">Home</a>
        <a href="room.php">Rooms</a>
        <a href="location.php">Location</a>
        <a href="FAQs.php">FAQs</a>

        <span class="nav-divider">||</span>
        
        <?php if(isset($_SESSION['user_id'])) { ?>

        <a href="account.php">
            User: <?php echo $_SESSION['username']; ?>
        </a>

            <a href="../PHP/logout.php">Logout</a>

        <?php } else { ?>

            <a href="login.php">Login</a>

        <?php } ?>

    </ul>
</nav>