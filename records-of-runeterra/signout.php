<?php
include 'connect.php';
include 'header.php';
    unset($_SESSION['signed_in']);
echo '<div style="color: whitesmoke; font-size:50; text-align: center">You are signed out!</div>';
include 'footer.php';
?>