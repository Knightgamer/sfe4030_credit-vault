<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clientId = $_POST['client_id'];
    $clientName = $_POST['client_name'];
    $No_units = $_POST['No_units'];
    $location = $_POST["location"]; 
    $buildingName = $_POST["building_name"];
    $amountPayable = $_POST['amount_payable'];
    $Advance = $_POST['Advance'];
    $totalAmountPaid = $_POST['total_amount_paid'];
    $paymentStatus = $_POST['payment_status'];
    

    $remainingValue = $amountPayable - $totalAmountPaid;


    // Perform the database update
    $sql = "UPDATE clients SET 
            client_name = '$clientName',
            location = '$location',
            building_name = '$buildingName',
            No_units='$No_units',
            amount_payable = '$amountPayable',
            Advance='$Advance',
            total_amount_paid = '$totalAmountPaid',
            payment_status = '$paymentStatus',
            remainingValue = '$remainingValue' 
            WHERE id = $clientId"; // Change to "id" column

    if ($conn->query($sql) === TRUE) {
        header('Location: view_clients.php?success=1');
    } else {
        echo 'Error updating client: ' . $conn->error;
    }
}

$conn->close();
?>
