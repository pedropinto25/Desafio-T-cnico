<?php
use PHPUnit\Framework\TestCase;
use Config\Database;

class DatabaseTest extends TestCase {
    private $database;

    protected function setUp(): void {
        $this->database = new Database();
    }

    public function testConnection() {
        $this->assertTrue($this->database->isConnected(), "Database connection should be established.");
    }
}
?>