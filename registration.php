<?php


require_once('database.php');

function registerUser($username, $email, $password, $confirm_password)
{
    $conn = connectDatabase();

    // Basic form validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        return "All fields are required.";
    } elseif ($password !== $confirm_password) {
        return "Passwords do not match.";
    } else {
        // Check if the username or email already exists in the database
        $query = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return "Username or email already exists. Please choose another.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $insert_query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                return "Success";
            } else {
                return "Registration failed. Please try again later.";
            }
        }
    }
}
