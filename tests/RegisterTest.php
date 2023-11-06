<?php
use PHPUnit\Framework\TestCase;

require_once 'utils\db_util.php';
require_once 'registration.php';

class RegisterTest extends TestCase
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

    /**
     * Test to ensure all fields are required during registration.
     * Expecting an error message when all fields are empty.
     */
    public function testAllFieldsRequired()
    {
        $result = registerUser("", "", "", "");
        $this->assertEquals("All fields are required.", $result);
    }

    /**
     * Test to ensure the provided passwords must match.
     * Expecting an error message when the two passwords do not match.
     */
    public function testPasswordsDoNotMatch()
    {
        $result = registerUser("user_test", "test@example.com", "password1", "password2");
        $this->assertEquals("Passwords do not match.", $result);
    }

    /**
     * Test to ensure unique usernames.
     * Expecting an error message when attempting to register with an already existing username.
     */
    public function testDuplicateUsername()
    {
        // Assuming 'user_test' is an existing username in the DB.
        $result = registerUser("shivam", "sbp1784@gmail.com", "shivam", "shivam");
        $this->assertEquals("Username or email already exists. Please choose another.", $result);
    }

    /**
     * Test to ensure unique email addresses.
     * Expecting an error message when attempting to register with an already existing email address.
     */
    public function testDuplicateEmail()
    {
        // Assuming 'test@example.com' is an existing email in the DB.
        $result = registerUser("different_username", "sbp1784@gmail.com", "password", "password");
        $this->assertEquals("Username or email already exists. Please choose another.", $result);
    }

    /**
     * Test successful registration.
     * Assuming the username and email are unique, and the two passwords match.
     */
    public function testSuccessfulRegistration()
    {
        $result = registerUser("new_unique_user", "new_email@example.com", "password", "password");
        $this->assertEquals(true, $result); // Assuming your 'registerUser' function returns true on successful registration.
    }

    // You can continue to add more tests for various scenarios...
}