<?php

use PHPUnit\Framework\TestCase;

require_once 'utils\db_util.php';
require_once 'authentication.php';

class LoginTest extends TestCase
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

    public function testSuccessfulAuthentication()
    {
        $username = 'user4'; // Replace with a valid test username from your DB
        $password = '8888'; // Replace with a valid test password from your DB

        $result = authenticateUser($username, $password, $this->conn);

        $this->assertEquals("Success", $result);
    }

    public function testFailedAuthentication()
    {
        $username = 'user4'; // Replace with a valid test username from your DB
        $password = '88886'; // Replace with an invalid test password

        $result = authenticateUser($username, $password, $this->conn);

        $this->assertEquals("Incorrect password", $result);
    }

    public function testUserNotFound()
    {
        $username = 'nonExistentUsername'; // Replace with a username that doesn't exist in your DB
        $password = 'randomPassword'; // Replace with a random password

        $result = authenticateUser($username, $password, $this->conn);

        $this->assertEquals("No user with the given username found", $result);
    }
}
