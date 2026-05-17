<!DOCTYPE html>
<html>
    <head>
        <title>Hotel Online Reservation System</title>
        <link rel="stylesheet" href="../CSS/MainPage.css"> 
        <link rel="stylesheet" href="../CSS/.Component.css">
    </head>
    <body>  
        <header>
            <h1 class="logo">Welcome to Hotel</h1>
            <?php include 'header.inc' ?>
        </header>

        <div class="here">
        <section class="main-content">
            <video id="background-video" autoplay loop muted poster="../VID/MainVid.mp4">
                <source src="../VID/MainVid.mp4" type="video/mp4">
            </video>

                
            <div class="hero-content">
                <h2>Book Your Stay With Ease</h2>
                <p>Experience luxury at affordable prices</p>
            </div><br><br>

            <div class="button-container">
                <button type="button" class="book-now-button" onclick="document.location='room.php'">Book Now</button>
            </div>
        </section>
    </body>  
    <script src="../JAVA/script.js"></script>
</html>
