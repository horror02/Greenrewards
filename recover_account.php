<?php
// Include database connection
include 'database.php';

// Start or resume the session
session_start();

// Check if ID parameter is passed
if (isset($_GET['rfidTags'])) {
    $id = $_GET['rfidTags'];

    // Retrieve admin's last name from session
    $adminLastName = $_SESSION['lastName']; // Assuming it's stored in the session

    // Update the remarks column to 'active' for the recovered account
    $pdo = Database::connect();
    $sqlUpdate = "UPDATE user SET remarks = '0' WHERE rfidTags = ?";
    $stmtUpdate = $pdo->prepare($sqlUpdate);
    if ($stmtUpdate->execute([$id])) {
        // Insert a record into the history table for the recovered account
        $sqlInsert = "INSERT INTO history (schoolId, remarks, recoveredAt, registeredBy) SELECT schoolId, 'recovered', CURRENT_TIMESTAMP, ? FROM user WHERE rfidTags = ?";
        $stmtInsert = $pdo->prepare($sqlInsert);
        if ($stmtInsert->execute([$adminLastName, $id])) {
            // Redirect back to the deleted accounts page or any other page as needed
            header("Location: recover.php");
            exit();
        } else {
            // Display an error message or redirect to an error page
            echo "Error inserting into history table.";
            // Redirect to error page if needed
            // header("Location: error_page.php");
            // exit();
        }
    } else {
        // Display an error message or redirect to an error page
        echo "Error updating remarks column.";
        // Redirect to error page if needed
        // header("Location: error_page.php");
        // exit();
    }
    Database::disconnect();
} else {
    // Redirect to an error page or handle the situation as per your application logic
    header("Location: error_page.php");
    exit();
}
?>