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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>

.container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    text-align: center;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

h1 {
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
    text-align: left;
}

label {
    display: block;
    font-weight: bold;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

button[type="submit"] {
    background-color: #007BFF;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

p {
    margin-top: 15px;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-group">
                <button type="submit">Register</button>
            </div>
        </form>
        <p>Already have an account? <a href="login.html">Login here</a></p>
    </div>
</body>
</html>
