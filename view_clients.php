<?php
include 'database.php';
session_start();
// Get the first character of the username for display
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$userInitial = strtoupper(substr($_SESSION['username'], 0, 1));


?>
<!DOCTYPE html>
<html>

<head>
    <title>View Clients</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/view_client.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS and extensions -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">
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
            <img src="images/Volks Elevator Logo.png" alt="Logo" width="60">
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
                    <a class="nav-link" href="add_client.php">Add New Client</a>
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

    <!-- Main content -->
    <div class="container mt-5">
        <h1>View Clients</h1>

        <div class="table-responsive">
            <?php
            include 'database.php';

            $sql = "SELECT * FROM clients";
            $result = $conn->query($sql);

            if (isset($_SESSION['new_client_added']) && $_SESSION['new_client_added'] === true) {
                echo '<p class="success-message">Client successfully added!</p>';
                unset($_SESSION['new_client_added']); // Clear the session variable
            }

            if ($result->num_rows > 0) {
                $tableRows = '';
                while ($row = $result->fetch_assoc()) {
                    $tableRows .= <<<ROW
            <tr class="excel-row">
                <td class="excel-cell">{$row['client_name']}</td>
                <td class="excel-cell">{$row['location']}</td>
                <td class="excel-cell">{$row['building_name']}</td>
                <td class="excel-cell">{$row['No_units']}</td>
                <td class="excel-cell">{$row['amount_payable']}</td>
                <td class="excel-cell">{$row['Advance']}</td>
                <td class="excel-cell">{$row['total_amount_paid']}</td>
                <td class="excel-cell">{$row['remainingValue']}</td>
                <td class="excel-cell">{$row['payment_status']}</td>
                <td class="excel-cell action-cell">
    <a href="edit.php?id={$row['id']}" class="btn btn-warning btn-sm mr-2" role="button"><i class="fas fa-edit"></i></a>
    <button class="btn btn-danger btn-sm delete-button" data-client-id="{$row['id']}"><i class="fas fa-trash-alt"></i></button>
</td>


            </tr>
ROW;
                }
            } else {
                $noClientsMessage = "No clients found.";
            }

            $conn->close();
            ?>

            <?php if (isset($tableRows)): ?>
                <table id="example" class="excel-sheet">
                    <thead>
                        <tr class="header-row">
                            <th>Client Name</th>
                            <th>Location</th>
                            <th>Building Name</th>
                            <th>No_units</th>
                            <th>Amount Payable</th>
                            <th>Advance</th>
                            <th>Total Amount Paid</th>
                            <th>Remaining Value</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $tableRows; ?>
                    </tbody>
                </table>
            <?php elseif (isset($noClientsMessage)): ?>
                <p>
                    <?= $noClientsMessage; ?>
                </p>
            <?php endif; ?>

        </div>
    </div>


    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS and extensions -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.3.0/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            // Hide the success message after 3 seconds
            setTimeout(function () {
                $('.success-message').fadeOut('slow');
            }, 3000); // 3000 milliseconds = 3 seconds
        });

        $(document).on('click', '.delete-button', function () {
            var clientId = $(this).data('client-id');
            var confirmDelete = confirm('Are you sure you want to delete this client?');

            if (confirmDelete) {
                // Perform AJAX call to delete.php or your backend endpoint
                $.ajax({
                    url: 'delete.php',
                    method: 'POST',
                    data: {
                        client_id: clientId
                    },
                    success: function (response) {
                        // Handle success, e.g., show the response in an alert or update the page
                        alert(response); // Display the success or error message
                        window.location.reload(); // Refresh the page after deletion
                    },
                    error: function () {
                        alert('An error occurred while deleting the client.');
                    }
                });
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
</body>

</html>