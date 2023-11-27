<?php

use PHPUnit\Framework\TestCase;

require_once 'utils\db_util.php';

require_once 'database.php';
require_once 'authentication.php';

class EditTest extends TestCase
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

    private $mockClientId = 1;
    private $mockSessionUsername = 'test_user';

    public function testFormIsRenderedForValidClientId()
    {
        // Arrange
        $_GET['id'] = $this->mockClientId;
        $_SESSION['username'] = $this->mockSessionUsername;

        // Act
        ob_start(); // Capture output
        include 'edit.php';
        $output = ob_get_clean();

        // Assert
        $expectedOutput = '<form method="POST" action="edit_process.php">' .
        '<input type="hidden" name="client_id" value="' . $this->mockClientId . '">';
        $this->assertEquals($expectedOutput, $output);
    }

    public function testErrorMessageDisplayedForInvalidClientId()
    {
        // Arrange
        $_GET['id'] = -1; // assuming -1 is an invalid ID

        // Act
        ob_start(); // Capture output
        include 'edit.php';
        $output = ob_get_clean();

        // Assert
        $expectedOutput = '<p>Invalid client ID.</p>';
        $this->assertEquals($expectedOutput, $output);
    }

    public function testErrorMessageDisplayedForClientNotFound()
    {
        // Arrange
        $_GET['id'] = 999; // assuming 999 is a non-existent ID

        // Act
        ob_start(); // Capture output
        include 'edit.php';
        $output = ob_get_clean();

        // Assert
        $expectedOutput = '<p>Client not found.</p>';
        $this->assertEquals($expectedOutput, $output);
    }
}
