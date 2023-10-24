<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection code here
    include("database.php");

    // Retrieve user input from the form
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Perform basic validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        // Handle empty fields
        echo "All fields are required.";
    } elseif ($password !== $confirm_password) {
        // Handle password mismatch
        echo "Passwords do not match.";
    } else {
        // Check if the username or email already exists in the database
        $query = "SELECT * FROM users WHERE username = '$username' OR password = '$password'";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Database query failed: " . mysqli_error($conn)); // Output the specific database error
        }
        

        if (mysqli_num_rows($result) > 0) {
            // Handle duplicate username or email
            echo "Username or email already exists. Please choose another.";
        } else {
            // Hash the password before storing it in the database (use a strong hashing algorithm)
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert user data into the database
            $insert_query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

            if (mysqli_query($conn, $insert_query)) {
                // Registration successful
                header("Location: login.html");
                exit();         
               } else {
                // Handle database insert error
                echo "Registration failed. Please try again later.";
            }
        }
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Redirect to the registration page if accessed directly
    header("Location: register.html");
}
?>
