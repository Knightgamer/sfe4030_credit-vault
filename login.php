<?php
// Start a session (place this at the beginning of your script)
session_start();

// Establish a database connection (replace with your database details)
$hostname = "localhost";
$dbname = "root";
$password = "";
$database = "credit_control";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli($hostname, $dbname, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'username' and 'password' are set in the POST request
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Retrieve user input
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database to check if the username exists
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_hashed_password = $row['password'];

        // Verify the provided password against the stored hashed password
        if (password_verify($password, $stored_hashed_password)) {
            // Passwords match, login successful

            // Store user information in a session variable
            $_SESSION['username'] = $username;

            // Redirect to the protected page (e.g., index.php)
            header("Location: index.php");
            exit();
        } else {
            echo "Login failed. Incorrect password.";
        }
    } else {
        echo "No user with the given username found.";
    }
} else {
    // Handle the case where 'username' and 'password' are not set in the POST request
    echo "Please provide a username and password.";
}

$conn->close();
?>
