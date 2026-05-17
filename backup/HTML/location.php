<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location and Weather Forecast - Hotel Cozy</title>
    <link rel="stylesheet" href="../CSS/location.css"> 
    <link rel="stylesheet" href="../CSS/Component.css">
    <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
</head>
<body>
    <header>
        <h1>Location and Weather Forecast</h1>
        <nav>
            <ul>
            <?php include 'header.inc' ?>
            </ul>
        </nav>
    </header>

    <section class="location-section">
        <h2>Our Location</h2>
        <div class="map-container">
            <button onclick="getLocation()"></button>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.310256002069!2d101.68834145751511!3d3.132799127194278!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2z4KSq4KSw4KWN4KS44KWJ4KWe4KWI4KSo4KWJ4KWL4KWJ4KWr4KS-IOCkruCkvuCksuClh-Ckv-CksuCkruCljeCkqOCksOCkvuCksuCkqA!5e0!3m2!1sen!2sin!4v1646614346406!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div> 
        <div class="buttons">
            <a href="https://www.google.com/maps" class="btn" target="_blank">View on Google Maps</a> <br><br>
            <h2>Weather Forecast</h2>
            <div class="elfsight-app-323e50f2-85bc-4acf-9f5d-b3ddd01dcfa8" data-elfsight-app-lazy></div>
        </div>
    </section>

    <script>
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap&v=weekly"
        defer
        
    </script>
</body>
</html>

