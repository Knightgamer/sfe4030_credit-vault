<?php

include 'database.php';
session_start();

if (isset($_GET['id'])) {
    $clientId = $_GET['id'];
    $sql = "SELECT * FROM clients WHERE id = $clientId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $clientData = $result->fetch_assoc();
    }
}
// Get the first character of the username for display
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$userInitial = strtoupper(substr($_SESSION['username'], 0, 1));


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
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

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <img src="images/Volks Elevator Logo.png" alt="Logo" width="60"> <!-- Add your logo path here -->
        </a>
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

    <div class="container mt-5">
        <h2>Edit Client Data</h2>

        <?php if (isset($clientData)): ?>
            <form method="POST" action="edit_process.php">
                <input type="hidden" name="client_id" value="<?= $clientData['id']; ?>">
                <div class="form-group">
                    <label>Client Name</label>
                    <input type="text" class="form-control" name="client_name" value="<?= $clientData['client_name']; ?>">
                </div>
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" class="form-control" name="location" value="<?= $clientData['location']; ?>">
                </div>
                <div class="form-group">
                    <label>Building Name</label>
                    <input type="text" class="form-control" name="building_name"
                        value="<?= $clientData['building_name']; ?>">
                </div>
                <div class="form-group">
                    <label>No. of Units</label>
                    <input type="number" class="form-control" name="No_units" value="<?= $clientData['No_units']; ?>">
                </div>
                <div class="form-group">
                    <label>Amount Payable</label>
                    <input type="number" class="form-control" name="amount_payable"
                        value="<?= $clientData['amount_payable']; ?>">
                </div>
                <div class="form-group">
                    <label>Advance</label>
                    <input type="number" class="form-control" name="Advance" value="<?= $clientData['Advance']; ?>">
                </div>
                <div class="form-group">
                    <label>Total Amount Paid</label>
                    <input type="number" class="form-control" name="total_amount_paid"
                        value="<?= $clientData['total_amount_paid']; ?>">
                </div>
                <div class="form-group">
                    <label>Payment Status</label>
                    <select name="payment_status" class="form-control" required>
                        <option value="pending" <?php echo ($clientData['payment_status'] == 'pending') ? 'selected' : ''; ?>>
                            Pending</option>
                        <option value="paid" <?php echo ($clientData['payment_status'] == 'paid') ? 'selected' : ''; ?>>Paid
                        </option>
                        <option value="not_paid" <?php echo ($clientData['payment_status'] == 'not_paid') ? 'selected' : ''; ?>>Not Paid</option>
                    </select>
                </div>


                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        <?php elseif (!isset($_GET['id'])): ?>
            <p>Invalid client ID.</p>
        <?php else: ?>
            <p>Client not found.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>