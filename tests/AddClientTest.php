<?php
use PHPUnit\Framework\TestCase;

require_once 'utils\db_util.php';
require_once 'authentication.php';
require_once 'database.php';

class AddClientTest extends TestCase
{

    private $conn;

    protected function setUp(): void
    {
        $this->conn = connectDatabase();
    }

    protected function tearDown(): void
    {
        $this->conn->close();
    }


    public function testAuthenticationRedirect()
    {
        // Simulate a non-authenticated user by not setting $_SESSION['username']
        session_start();
        ob_start(); // Start output buffering to capture the header redirect
        include 'add_client.php';
        $result = ob_get_clean();

        // Assert that the script redirects to login.php
        $this->assertEquals('Location: login.php', $result);
    }

    public function testSuccessfulClientAddition()
    {
        // Simulate an authenticated user
        session_start();
        $_SESSION['username'] = 'testuser';

        // Create a POST request with valid client data
        $_POST = [
            'clientName' => 'Test Client',
            'location' => 'Test Location',
            'buildingName' => 'Test Building',
            'No_units' => '5',
            'amountPayable' => '1000',
            'Advance' => '500',
            'totalAmountPaid' => '500',
            'paymentStatus' => 'pending',
        ];

        ob_start(); // Start output buffering to capture the header redirect
        include 'add_client.php';
        $output = ob_get_clean();

        // Assert that the script redirects to view_clients.php?success=1
        $this->assertStringContainsString('Location: view_clients.php?success=1', $output);
    }

    public function testErrorHandlingOnClientAddition()
    {
        // Simulate an authenticated user
        session_start();
        $_SESSION['username'] = 'testuser';

        // Create a POST request with invalid client data to trigger a database error
        $_POST = [
            'clientName' => '',  // Invalid data to trigger an error
            // ... include other required fields
        ];

        ob_start(); // Start output buffering to capture the error message
        include 'add_client.php';
        $output = ob_get_clean();

        // Assert that the script outputs an error message
        $this->assertStringContainsString('Error adding client', $output);
    }

    public function testFormSubmissionWithMissingData()
    {
        // Simulate an authenticated user
        session_start();
        $_SESSION['username'] = 'testuser';

        // Create a POST request with missing or incomplete client data
        $_POST = [
            // Missing clientName and other required fields
        ];

        ob_start(); // Start output buffering to capture the error message
        include 'add_client.php';
        $output = ob_get_clean();

        // Assert that the script outputs an error message
        $this->assertStringContainsString('Error adding client', $output);
    }

    public function testPaymentStatusClassAddition()
    {
        // Simulate an authenticated user
        session_start();
        $_SESSION['username'] = 'testuser';

        // Create a POST request with valid client data
        $_POST = [
            'clientName' => 'Test Client',
            'location' => 'Test Location',
            'buildingName' => 'Test Building',
            'No_units' => '5',
            'amountPayable' => '1000',
            'Advance' => '500',
            'totalAmountPaid' => '500',
            'paymentStatus' => 'paid',  // Select a different payment status
        ];

        ob_start(); // Start output buffering to capture the script output
        include 'add_client.php';
        $output = ob_get_clean();

        // Assert that the selected payment status option has the corresponding CSS class added
        $this->assertStringContainsString('<option value="paid" class="paid" selected> Paid </option>', $output);
    }
}
