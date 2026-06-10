<?php
require 'includes/db.php';

$queries = [
    "ALTER TABLE employees ADD COLUMN verification_token VARCHAR(255) NULL",
    "ALTER TABLE employees ADD COLUMN reset_token VARCHAR(255) NULL",
    "ALTER TABLE employees ADD COLUMN reset_token_expiry DATETIME NULL",
    "ALTER TABLE employees ADD COLUMN skills VARCHAR(255) NULL"
];

foreach ($queries as $query) {
    if (mysqli_query($conn, $query)) {
        echo "Successfully executed: $query\n";
    } else {
        echo "Error or already exists for: $query\n";
    }
}
?>
