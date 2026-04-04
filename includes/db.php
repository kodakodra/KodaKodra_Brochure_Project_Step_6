<?php

/**
 * db.php
 *
 * Database connection using PDO.
 * Include this file anywhere a database connection is needed.
 * Returns a $pdo object ready for prepared statements.
 *
 * PDO is used over mysqli for cleaner syntax, better security,
 * and easier prepared statement handling.
 */

require_once __DIR__ . '/config.php';

try {
    // Build the DSN (Data Source Name) string for MySQL
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';

    // Create the PDO connection with secure default options
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Throw exceptions on errors
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Return results as associative arrays
        PDO::ATTR_EMULATE_PREPARES   => false,                   // Use real prepared statements
    ]);

} catch (PDOException $e) {
    // Log the real error privately and show a safe message to the user
    error_log('Database connection failed: ' . $e->getMessage());
    die('A database error occurred. Please try again later.');
}
