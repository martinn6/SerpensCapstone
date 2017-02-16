<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
session_destroy();
// unset($_SESSION['admin']); 
header("Location: ../index.html"); 
die();
?>