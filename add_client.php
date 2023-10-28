<?php
session_start();
require_once 'utils\db_util.php';

// Check if user is authenticated
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$userInitial = strtoupper(substr($_SESSION['username'], 0, 1));

// Process POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dbUtil = new DatabaseUtil(); // Create instance of DatabaseUtil
    $conn = $dbUtil->connect(); // Use the connect method to get connection

    $clientName = $_POST['clientName'];
    $location = $_POST['location'];
    $buildingName = $_POST['buildingName'];
    $No_units = $_POST['No_units'];
    $amountPayable = $_POST['amountPayable'];
    $Advance = $_POST['Advance'];
    $totalAmountPaid = $_POST['totalAmountPaid'];
    $paymentStatus = $_POST['paymentStatus'];
    $remainingValue = $amountPayable - $totalAmountPaid;

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare(
        "INSERT INTO clients (client_name, No_units, amount_payable, Advance, total_amount_paid, payment_status, remainingValue, location, building_name)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param('sssssssss', $clientName, $No_units, $amountPayable, $Advance, $totalAmountPaid, $paymentStatus, $remainingValue, $location, $buildingName);

    if ($stmt->execute()) {
        header('Location: view_clients.php?success=1');
    } else {
        echo 'Error adding client: ' . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Add New Client</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="./assets/css/add-client.css"> -->

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

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">
            <img src="images/Volks Elevator Logo.png" alt="Logo" width="60" height="30">
            <!-- You can adjust width and height as needed -->
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mr-3" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Homepage</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_clients.php">View Clients</a>
                </li>
            </ul>
        </div>
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

    <!-- Main Content -->
    <div class="container mt-3">
        <h1 class="text-center mb-4">Add New Client</h1>
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <form action="add_client.php" method="post" id="clientForm">
                    <label for="clientName" class="form-label">Client Name:</label>
                    <input type="text" id="clientName" name="clientName" class="form-control" required>

                    <label for="location" class="form-label">Location:</label>
                    <input type="text" id="location" name="location" class="form-control" required>

                    <label for="buildingName" class="form-label">Building Name:</label>
                    <input type="text" id="buildingName" name="buildingName" class="form-control" required>

                    <label for="No_units" class="form-label">No_units:</label>
                    <input type="text" id="No_units" name="No_units" class="form-control" required>

                    <label for="amountPayable" class="form-label">Amount Payable:</label>
                    <input type="number" id="amountPayable" name="amountPayable" class="form-control" required>

                    <label for="Advance" class="form-label">Advance:</label>
                    <input type="number" id="Advance" name="Advance" class="form-control" required>

                    <label for="totalAmountPaid" class="form-label">Total Amount Paid:</label>
                    <input type="number" id="totalAmountPaid" name="totalAmountPaid" class="form-control" required>

                    <label for="paymentStatus" class="form-label">Payment Status:</label>
                    <select id="paymentStatus" name="paymentStatus" class="form-control" required>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="not_paid">Not Paid</option>
                    </select>

                    <button type="submit" class="btn btn-primary btn-block mt-3">Add Client</button>
                </form>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="view_clients.php" class="btn btn-secondary">View Clients</a>
        </div>
    </div>

    <script>
        const form = document.getElementById('clientForm');
        form.addEventListener('submit', (event) => {
            const paymentStatusSelect = document.getElementById('paymentStatus');
            const selectedOption = paymentStatusSelect.options[paymentStatusSelect.selectedIndex];
            selectedOption.classList.add(selectedOption.value);
        });
    </script>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>