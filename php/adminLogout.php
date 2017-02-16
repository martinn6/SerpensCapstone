<?php 
session_destroy();
// unset($_SESSION['admin']); 
header("Location: ../index.html"); 
die();
?>