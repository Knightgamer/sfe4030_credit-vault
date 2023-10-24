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
