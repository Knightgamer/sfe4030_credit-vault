<?php
// Start a session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$userInitial = strtoupper(substr($_SESSION['username'], 0, 1));

?>

<!DOCTYPE html>
<html>

<head>
    <title>Excel-Like Web App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .navbar .dropdown-toggle::after {
            content: none;
        }

        .navbar .dropdown-menu .logout-text {
            color: black;
        }
    </style>

</head>

<body>
    <!-- Modified Navbar using Bootstrap -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <img src="images/Volks Elevator Logo.png" alt="Company Logo" width="60px">
        </a>
        <div class="ml-auto">
            <div class="navbar-text dropdown">
                <a href="#" class="dropdown-toggle profile-link" data-toggle="dropdown"
                    style="text-decoration: none; color: inherit;">
                    <div class="user-profile d-inline-block text-center bg-primary rounded-circle text-white"
                        style="width: 40px; height: 40px; line-height: 40px;">
                        <?= $userInitial ?>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right ">
                    <a href="logout.php" class="dropdown-item logout-text">Logout</a>
                </div>
            </div>
        </div>
    </nav>


    <div class="container mt-5 text-center">
        <div class="header mb-4">
            <h1>Hello & Welcome to the Excel-Like Web App</h1>
            <h3>How may I be of service to you?</h3>
        </div>

        <!-- Modified buttons using Bootstrap classes -->
        <div class="homepage">
            <div class="button-container mb-4">
                <a href="add_client.php" class="btn btn-primary btn-lg mb-2"><span class="icon">➕</span> Add New
                    Client</a><br>
                <a href="view_clients.php" class="btn btn-info btn-lg mb-2"><span class="icon">👀</span> View
                    Clients</a><br>
                <!-- <a href="generate_report.html" class="btn btn-warning btn-lg mb-2"><span class="icon">📊</span> Generate Report</a><br> -->
                <a href="logout.php" class="btn btn-danger btn-lg mb-2"><span class="icon"><i style="font-size:24px"
                            class="fa">&#xf08b;</i></span> Logout</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>