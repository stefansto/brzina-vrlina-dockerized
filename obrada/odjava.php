<?php
    @session_start();
    unset($_SESSION['idK']);
    unset($_SESSION['roleK']);
    header("Location: ../login.php");
?>