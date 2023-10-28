<?php
session_start();

// Include the database connection file
require_once('database.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize the error message
$errorMessage = "";

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_hashed_password = $row['password'];

        if (password_verify($password, $stored_hashed_password)) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $errorMessage = "Incorrect password";
        }
    } else {
        $errorMessage = "No user with the given username found";
    }
} else {
    $errorMessage = "";
}

$conn->close();
?>

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