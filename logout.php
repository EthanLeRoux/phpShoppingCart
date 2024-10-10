<?php
// Destroy the session
session_unset();    // Unset all session variables
session_destroy();  // Destroy the session

// Regenerate the session ID to ensure a new session
session_start(); // Start a new session
session_regenerate_id(true); // Regenerate the session ID and delete the old session file
// Redirect to another page, such as the homepage or login page
header("Location: index.php");
exit();
?>