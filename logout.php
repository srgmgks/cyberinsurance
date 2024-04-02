<?php
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to index.html after logout
header("Location: login.html");
exit();
?>
