<?php
include 'database.php';

if (isset($_GET['id'])) {
    $clientId = $_GET['id'];
    $sql = "SELECT * FROM clients WHERE id = $clientId"; // Change to "id" column
    $result = $conn->query($sql);

    if ($result->num_rows > 0) { // Check if any rows were fetched
        $clientData = $result->fetch_assoc();
        // Display an edit form
        echo '<form method="POST" action="edit_process.php">';
        echo '<input type="hidden" name="client_id" value="' . $clientData['id'] . '">'; // Change to "id" column
        echo 'Client Name: <input type="text" name="client_name" value="' . $clientData['client_name'] . '"><br>';
        echo 'Client Name: <input type="text" name="location" value="' . $clientData['location'] . '"><br>';
        echo 'Client Name: <input type="text" name="building_name" value="' . $clientData['building_name'] . '"><br>';
        echo 'No_units: <input type="text" name="No_units" value="' . $clientData['No_units'] . '"><br>';
        echo 'Amount Payable: <input type="text" name="amount_payable" value="' . $clientData['amount_payable'] . '"><br>';
        echo 'Advance: <input type="text" name="Advance" value="' . $clientData['Advance'] . '"><br>';
        echo 'Total Amount Paid: <input type="text" name="total_amount_paid" value="' . $clientData['total_amount_paid'] . '"><br>';
        echo 'Payment Status: <input type="text" name="payment_status" value="' . $clientData['payment_status'] . '"><br>';
        
        echo '<input type="submit" value="Save Changes">';
        echo '</form>';
    } else {
        echo 'Client not found.';
    }
} else {
    echo 'Invalid client ID.';
}

$conn->close();
?>
