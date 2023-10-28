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
} 

$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>

    <style>
        body {
            background-color: #a1a1a1;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center; /* Center the container horizontally */
            align-items: center; /* Center the container vertically */
            height: 100vh; /* Make the container full height of the viewport */
            margin: 0;
        }

        .container {
            max-width: 300px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
            text-align: center; /* Center the text inside the container */
        }

        h2 {
            color: #333;
        }

        /* Logo container */
        .logo-container {
            margin-bottom: 20px;
        }

        /* Logo image */
        .logo {
            max-width: 40%; /* Ensure the logo scales down to fit the container */
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box; /* Ensure padding and border don't increase the width */
        }

        /* Password container */
        .password-container {
            position: relative;
        }
        /* Password input field */
        .password-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box; /* Ensure padding and border don't increase the width */
        }
         /* Show password icon */
         .show-password-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        button {
            width: 50%; /* Make the button 50% width of the container */
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 20px; /* Make it more rounded */
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
        .small-text {
            font-size: 14px; /* Adjust the font size as needed */
        }
        
    </style>
</head>
<body>
    <div class="container">
         <!-- Logo container -->
         <div class="logo-container">
            <img class="logo" src="images/Volks Elevator Logo.png" alt="Volks Logo">
        </div>
        <h2>Welcome to Volks Elevator</h2>
        <form action="login.php" method="POST">
            
            <input type="text" name="username" placeholder="Username" required>
            
           <!-- Password container -->
           <div class="password-container">
            <input type="password" name="password" class="password-input" id="password" placeholder="Password" required>
            <!-- Show password icon -->
            <i class="show-password-icon" id="showPasswordIcon">&#x1F441;</i>
            
            </div>
                <div class="small-text">
                <p>Forgot Password?</p>
                <button type="submit">Login</button>
                <p><b>OR</p></b><hr>
                <a href="register.php">
                    <button>Register</button>
                </a>
                <p>By continuing, you agree to Volks Elevator's <b>Terms of Service, Privacy Policy</b></p>
                
            </div>
        </form>
    </div>

    <script>
        // JavaScript to toggle password visibility
        const passwordInput = document.getElementById('password');
        const showPasswordIcon = document.getElementById('showPasswordIcon');
        
        showPasswordIcon.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    </script>
</body>
</html>

