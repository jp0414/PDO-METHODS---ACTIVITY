<?php
/**
 * Database Configuration and Connection Setup
 * Uses PDO (PHP Data Objects) for secure, error-resistant MySQL connections.
 */
// Define database connection credentials
$host = "localhost"; // Database server host (usually localhost for local development)
$user = "root";      // Default username for local servers (XAMPP, WAMP, MAMP)
$password = "";          // Default password for local servers (blank for XAMPP/WAMP)
$dbname = "sapida";    // Target database name containing your grocery tables
try {
    // Define the Data Source Name (DSN) specifying driver, host, database name, and UTF-8 encoding
    $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
    // Configure core driver options to improve reliability and security
    $options = [
        // Throw exceptions on SQL structural or execution errors for easier debugging
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Fetch rows automatically as clean associative arrays (column_name => value)
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Disable emulated prepares to enforce native, secure parameterized queries against SQL injection
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    // Establish the connection instance by instantiating the native PDO class
    $pdo = new PDO($dsn, $user, $password, $options);
    // Explicitly sync database runtime operations with Philippine Standard Time (PHT)
    $pdo->exec("SET time_zone = '+08:00';");
} catch (PDOException $e) {
    // Log the sensitive raw error traceback information privately to the system server logs
    error_log($e->getMessage());
    // Mask sensitive server details from end users by terminating script execution with a generic alert
    die("Connection failed. Please try again later.");
}
?>