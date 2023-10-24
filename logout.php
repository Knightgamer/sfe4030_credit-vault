<?php
// Start a session (place this at the beginning of your script)
session_start();

// Check if the user is logged in (by checking the presence of the 'username' session variable)
if (isset($_SESSION['username'])) {
    // Unset or destroy the session variables
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session data

    // Redirect to the login page or any other page as needed
    header("Location: login.html");
    exit();
} else {
    // If the user is not logged in, you can handle this situation accordingly
    echo "You are not currently logged in.";
}
?>
