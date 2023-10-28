<?php
session_start();

// Include the database connection and authentication files
require_once('database.php');
require_once('authentication.php');

// $conn = connectDatabase();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize the error message
$errorMessage = "";

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = authenticateUser($username, $password, $conn);

    if ($result === "Success") {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $errorMessage = $result;
    }
}

$conn->close();
?>

<!-- ... the rest of your HTML code remains unchanged ... -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div class="container">
        <div class="logo-container">
            <img class="logo" src="images/Volks Elevator Logo.png" alt="Volks Logo">
        </div>
        <h2>Welcome to Volks Elevator</h2>
        <form action="login.php" method="POST">

            <div class="error-message">
                <?php
                if (isset($errorMessage)) {
                    echo $errorMessage;
                }
                ?>
            </div>

            <input type="text" name="username" placeholder="Username" required>

            <div class="password-container">
                <input type="password" name="password" class="password-input" id="password" placeholder="Password"
                    required>
                <i class="show-password-icon" id="showPasswordIcon">&#x1F441;</i>
            </div>
            <div class="small-text">
                <p>Forgot Password?</p>
                <button type="submit">Login</button>
                <p><b>OR</b></p>
                <hr>
                <a href="register.php"><button type="button">Register</button></a>
                <p>By continuing, you agree to Volks Elevator's <b>Terms of Service, Privacy Policy</b></p>
            </div>

        </form>
    </div>

    <script>
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