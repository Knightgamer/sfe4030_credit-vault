<?php
// Start a session (place this at the beginning of your protected page)
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: login.html");
    exit();
}

// Continue with the protected page content
?>
<!DOCTYPE html>
<html>
<head>
    <title>Excel-Like Web App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* styles.css */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-image: url('images/empty-escalator-view.jpg'); 
    background-size: 1000px 600px;
    background-attachment: fixed;
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: #333;
    color: white;
}

.logo {
    max-width: 100px; /* Set the maximum width of your logo */
    height: auto;
}

.header {
    text-align: center;
    padding: 20px;
}

.homepage {
    text-align: center;
    padding: 50px;
}

/* Center-align the text container */
.text-container {
    background-color: rgba(0, 0, 0, 0.7);
    padding: 20px;
    border-radius: 10px;
    margin: 0 auto; /* Center horizontally */
    margin-top: 20px; /* Adjust the top margin as needed */
    text-align: center;
    max-width: 500px;
}


/* Center-align the button container */
.button-container {
    background-color: rgba(0, 0, 0, 0.7);
    padding: 20px;
    border-radius: 10px;
    margin: 0 auto; /* Center horizontally */
    margin-top: 20px; /* Adjust the top margin as needed */
    text-align: center;
    max-width: 500px;
}



.navigation {
    margin-top: 20px;
}

/* Updated button styles */
.nav-button {
    display: inline-block;
    margin: 10px;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 25px; /* Rounded corners */
    min-width: 150px; /* Set a minimum width for buttons */
    text-align: center;
    transition: background-color 0.3s; /* Smooth hover effect */
}

.nav-button:hover {
    background-color: #0056b3;
}

.excel-sheet {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    grid-gap: 1px;
    margin-top: 20px;
    border-collapse: collapse;
    width: 100%;
}

.excel-row {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
}

.excel-cell {
    border: 1px solid #ccc;
    padding: 10px;
    background-color: #f0f0f0;
}

.header-row {
    background-color: #007bff;
    color: white;
}

.long-cell {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Center-align text and use normal font weight for headers */
h1, h3 {
    text-align: center;
    font-weight: normal;
    color: white; /* Set text color to white */
}
    </style>
</head>
<body>
    <div class="navbar">
        <img src="images/Volks Elevator Logo.png" alt="Company Logo" class="logo">
    </div>
    <div class="header">
        <!-- Container for h1 and h3 -->
        <div class="text-container">
            <h1>Hello & Welcome to the Excel-Like Web App</h1>
            <h3>How may I be of service to you?</h3>
        </div>
    </div>
    <div class="homepage">
        <!-- Button Container -->
        <div class="button-container">
            <div class="navigation">
                <a href="add_client.html" class="nav-button"><span class="icon">➕</span>Add New Client</a>
                <a href="view_clients.php" class="nav-button"><span class="icon">👀</span>View Clients</a>
                <a href="generate_report.html" class="nav-button"><span class="icon">📊</span>Generate Report</a>
                <a href="logout.php" class="nav-button"><span class="icon"><i style="font-size:24px" class="fa">&#xf08b;</i></span>Logout</a>
            </div>
        </div>
    </div>
</body>
</html>