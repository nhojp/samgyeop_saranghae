<?php
session_start(); // Start the session

// Destroy the session
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session

// Redirect to the login or homepage (index.php)
header("Location: index.php");
exit; // Ensure no further code is executed
?>
