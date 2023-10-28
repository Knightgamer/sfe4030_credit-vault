<!DOCTYPE html>
<html>
<head>
    <title>View Clients</title>
    <!--<link rel="stylesheet" type="text/css" href="styles.css"> -->
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Hide the success message after 3 seconds
            setTimeout(function() {
                $('.success-message').fadeOut('slow');
            }, 3000); // 3000 milliseconds = 3 seconds
        });
    </script>


    <style>
        /* styles.css */
body {
    font-family: Arial, sans-serif;
    
}
/* Set background image */
body {
        background-image: url('background.png'); /* Replace 'background.png' with the path to your image */
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

    h1 {
        text-align: center;
    }

    table.excel-sheet {
        width: 400px;
        border-collapse: collapse;
        margin-top: 20px;
        margin: 0 auto;
    }

    .header-row {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .header-row th {
        padding: 50px;
        text-align: left;
        border-bottom: 2px solid #ddd;
    }
    .main {
        text-align: center; /* Center align the content within .main */
        margin-top: 50px;
        
    }

    .excel-cell {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        vertical-align: top; /* Align content to the top of the cell */
    }

    .excel-row:nth-child(even) {
        background-color: #f2f2f2;
    }
    .excel-cell.single-line {
        white-space: nowrap;
        overflow: hidden; /* Hide any overflow */
        text-overflow: ellipsis;
    }


    .excel-row td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .success-message {
        color: green;
        font-weight: bold;
        margin-top: 10px;
    }

    .container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;

        
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
            <a href="add_client.html" class="nav-button">Add New Client</a>
            <a href="generate_pdf.php" class="nav-button">Generate Report</a>
        </div>
    </div>
   
    <div class="main">
    <h1>View Clients</h1>

<?php
include 'database.php';

$sql = "SELECT * FROM clients";
$result = $conn->query($sql);
session_start();
if (isset($_SESSION['new_client_added']) && $_SESSION['new_client_added'] === true) {
    echo '<p class="success-message">Client successfully added!</p>';
    unset($_SESSION['new_client_added']); // Clear the session variable
}


if ($result->num_rows > 0) {
    echo '<table id="example" class="excel-sheet">';
    echo '<tr class="header-row">';
    echo '<th>Client Name</th>';
    echo '<th>Location</th>';
    echo '<th>Building Name</th>';
    echo '<th>No_units</th>';
    echo '<th>Amount Payable</th>';
    echo '<th>Advance</th>'; 
    echo '<th>Total Amount Paid</th>';
    echo '<th>Remaining Value</th>';
    echo '<th>Payment Status</th>';
    echo '<th>Action</th>';

    echo '</tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr class="excel-row">';
        echo '<td class="excel-cell">' . $row['client_name'] . '</td>';
        echo '<td class="excel-cell">' . $row['location'] . '</td>'; 
        echo '<td class="excel-cell">' . $row['building_name'] . '</td>'; 
        echo '<td class="excel-cell">' . $row['No_units'] . '</td>';
        echo '<td class="excel-cell">' . $row['amount_payable'] . '</td>';
        echo '<td class="excel-cell">' . $row['Advance'] . '</td>';
        echo '<td class="excel-cell">' . $row['total_amount_paid'] . '</td>';
        echo '<td class="excel-cell">' . $row['remainingValue'] . '</td>';
        echo '<td class="excel-cell">' . $row['payment_status'] . '</td>';
        echo '<td class="excel-cell"> <a class="edit-button" href="edit.php?id=' . $row['id'] . '">Edit</button></a>
        <br> <br><button class="delete-button" data-client-id="' . $row['id'] . '">Delete</button></td>';
        echo '</tr>';

        /*echo '<td class="excel-cell"> <button a class="edit-button" href="edit.php?id=' . $row['id'] . '">Edit</button></a><td>';
        echo '</tr>';
        echo '<td class="excel-cell"><button class="delete-button" data-client-id="' . $row['id'] . '">Delete</button></td>';
        echo '</tr>';*/
    }   

    echo '</table>';
} else {
    echo 'No clients found.';
}


$conn->close();
?>


    </div>
    <script>
        // Automatically hide the success message after 3 seconds
        setTimeout(function() {
            var successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 3000); // 3000 milliseconds = 3 seconds

        $(document).on('click', '.delete-button', function() {
        var clientId = $(this).data('client-id'); // Corrected to 'client-id'
        var confirmDelete = confirm('Are you sure you want to delete this client?');

        if (confirmDelete) {
            // Perform AJAX call to delete.php or your backend endpoint
            $.ajax({
                url: 'delete.php',
                method: 'POST',
                data: { client_id: clientId }, // Change to 'client_id'
                success: function(response) {
                    // Handle success, e.g., show the response in an alert or update the page
                    alert(response); // Display the success or error message
                    window.location.reload(); // Refresh the page after deletion
                },
                error: function() {
                    alert('An error occurred while deleting the client.');
                }
            });
        }
    });



    </script>
    
    </body>
</html>
