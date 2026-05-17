<?php
session_start();
session_destroy();

header("Location: ../HTML/MainPage.php");
exit();
?>