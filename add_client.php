<?php
include 'database.php';
session_start();
$_SESSION['new_client_added'] = true;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clientName = $_POST['clientName'];
    $location = $_POST['location'];
    $buildingName = $_POST['buildingName'];
    $No_units = $_POST['No_units'];
    $amountPayable = $_POST['amountPayable'];
    $Advance = $_POST['Advance'];
    $totalAmountPaid = $_POST['totalAmountPaid'];
    $paymentStatus = $_POST['paymentStatus'];
    $remainingValue = $amountPayable - $totalAmountPaid;

    // Perform the database insert
    $sql = "INSERT INTO clients (client_name, No_units,amount_payable, Advance, total_amount_paid, payment_status, remainingValue, location, building_name)
    VALUES ('$clientName',  '$No_units ' ,'$amountPayable','$Advance','$totalAmountPaid', '$paymentStatus', '$remainingValue', '$location', '$buildingName')";

    if ($conn->query($sql) === TRUE) {
        header('Location: view_clients.php?success=1');
    } else {
        echo 'Error adding client: ' . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Client</title>
    <link rel="stylesheet" type="text/css" href="responsive.css">

    <style>
        /* Set background image */
        body {
            background-image: url('images/empty-escalator-view.jpg'); /* Replace 'background.png' with the path to your image */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        /* Top navigation bar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 10px 20px;
        }

        .navbar-logo {
            display: flex;
            align-items: center;
            color: #fff;
            text-decoration: none;
        }

        .navbar-logo img {
            max-width: 100px;
            margin-right: 10px;
        }

        .navigation {
            text-align: center;
        }

        /* Style for navigation buttons */
        .nav-button, button {
            display: inline-block;
            padding: 10px 20px;
            width: 150px; /* Set a fixed width for all buttons */
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            cursor: pointer;
            border: none; /* Remove button border */
            outline: none; /* Remove button outline */
        }

        .nav-button:hover, button:hover {
            background-color: #0056b3;
        }

        .container {
            text-align: center;
            margin-top: 20px;
        }

        /* Centered and evenly spaced form elements */
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form label,
        form input,
        form select {
            margin: 3px;
        }

        /* Centered content */
        h1, a {
            text-align: center;
        }

        /* Form container with a different background and shadow */
        .form-container {
            background-color: #fff; /* Set your desired background color */
            background-image: url('1.jpg'); 
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            padding: 15px; /* Smaller padding */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.7); 
            margin: 0 auto; /* Center the form container horizontally */
            text-align: left;
        }

        /* Reduce the height of the form container */
        .form-container {
            max-width: 500px;
            overflow-y: auto; 
        }

        /* Style for round and equal-sized button */
        .nav-button, .add-client-button {
            border-radius: 25px; /* Rounded corners */
        }

        /* Responsive design */
        @media screen and (max-width: 768px) {
            .container {
                margin-top: 10px;
            }

            form label,
            form input,
            form select {
                margin: 6px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="#" class="navbar-logo">
            <img src="images/Volks Elevator Logo.png" alt="Logo">
            
        </a>
        <div class="navigation">
            <a href="index.php" class="nav-button">Homepage</a>
            <a href="view_clients.php" class="nav-button">View Clients</a>
            <a href="generate_pdf.php" class="nav-button">Generate Report</a>
        </div>
    </div>

    <div class="container">
        <h1>Add New Client</h1>

        <div class="form-container">
            <form action="add_client.php" method="post" id="clientForm">
                <label for="clientName">Client Name:</label>
                <input type="text" id="clientName" name="clientName" required>			<br>

                <label for="location">Location:</label>
                <input type="text" id="location" name="location" required><br>

                <label for="buildingName">Building Name:</label>
                <input type="text" id="buildingName" name="buildingName" required><br>

                <label for="No_units">No_units:</label>
                <input type="text" id="No_units" name="No_units" required><br>
                
                <label for="amountPayable">Amount Payable:</label>
                <input type="number" id="amountPayable" name="amountPayable" required><br>

                <label for="Advance">Advance:</label>
                <input type="number" id="Advance" name="Advance" required><br>

                <label for="totalAmountPaid">Total Amount Paid:</label>
                <input type="number" id="totalAmountPaid" name="totalAmountPaid" required><br>
                
                <label for="paymentStatus">Payment Status:</label>
                <select id="paymentStatus" name="paymentStatus" required>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="not_paid">Not Paid</option>
                </select><br>
                
                <button type="submit" class="add-client-button">Add Client</button>
            </form>
        </div>
        
        <a href="view_clients.php">View Clients</a> 
    </div>

    <script>
        const form = document.getElementById('clientForm');
        form.addEventListener('submit', (event) => {
            const paymentStatusSelect = document.getElementById('paymentStatus');
            const selectedOption = 								paymentStatusSelect.options[paymentStatusSelect.selectedIndex];
            selectedOption.classList.add(selectedOption.value);
        });
    </script>
</body>
</html>