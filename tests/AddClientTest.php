<?php
use PHPUnit\Framework\TestCase;

require_once 'utils\db_util.php';
require_once 'add_client.php';

class AddClientTest extends TestCase
{
    private $dbUtil;
    private $conn;

    protected function setUp(): void
    {
        // Mock the DatabaseUtil
        $this->dbUtil = $this->getMockBuilder(DatabaseUtil::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Mock the mysqli class
        $this->conn = $this->getMockBuilder(mysqli::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Configure the mock methods
        $this->dbUtil->method('connect')->willReturn($this->conn);

        // Start PHP session for testing
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function tearDown(): void
    {
        session_unset();
        session_destroy();
    }

    public function testUserNotAuthenticatedRedirectsToLogin()
    {
        $_SESSION = []; // Empty session to simulate no user logged in
        ob_start(); // Start output buffering
        require 'add_client.php'; // Execute your page script
        $output = ob_get_contents(); // Get the output
        ob_end_clean();

        $this->assertStringContainsString('Location: login.php', $output); // Check if redirection to login is present
    }
}

