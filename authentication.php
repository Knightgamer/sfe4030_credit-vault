<?php
// authentication.php

function authenticateUser($username, $password, $conn)
{
    // Check if connection is successful
    if ($conn->connect_error) {
        return "Connection failed: " . $conn->connect_error;
    }

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_hashed_password = $row['password'];

        if (password_verify($password, $stored_hashed_password)) {
            // If you wish to start a session upon successful login, you can do so here.
            // For example: $_SESSION['username'] = $username;
            return "Success"; // Success indicates the credentials are correct
        } else {
            return "Incorrect password";
        }
    } else {
        return "No user with the given username found";
    }
}
