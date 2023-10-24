<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['client_id'])) {
    $clientId = $_POST['client_id'];

    // Perform the database deletion
    $sql = "DELETE FROM clients WHERE id = $clientId"; // Use 'id' column
    if ($conn->query($sql) === TRUE) {
        echo 'Client deleted successfully.'; // Return a success message
    } else {
        echo 'Error deleting client: ' . $conn->error; // Return an error message
    }
}

$conn->close();
?>
