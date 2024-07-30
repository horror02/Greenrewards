<?php
session_start(); // Start or resume the session

require 'database.php';

$rfidTags = null;
if (!empty($_GET['rfidTags'])) {
    $rfidTags = $_REQUEST['rfidTags'];
}

if (!empty($_POST)) {
    // keep track post values
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $middleName = $_POST['middleName'];
    $rfidTags = $_POST['rfidTags'];
    $schoolId = $_POST['schoolId'];

    // get admin last name from session
    $adminLastName = $_SESSION['lastName'];

    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // begin transaction
    $pdo->beginTransaction();

    try {
        // update user data
        $sql = "UPDATE user SET firstName = ?, lastName = ?, middleName = ?, schoolId = ? WHERE rfidTags = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($firstName, $lastName, $middleName, $schoolId, $rfidTags));

        // insert into history table
        $sql = "INSERT INTO history (schoolId, remarks, registeredBy, updatedAt) VALUES (?, 'updated', ?, NOW())";
        $q = $pdo->prepare($sql);
        $q->execute(array($schoolId, $adminLastName));

        // commit transaction
        $pdo->commit();

    } catch (Exception $e) {
        // rollback transaction if something goes wrong
        $pdo->rollBack();
        throw $e;
    }

    Database::disconnect();
    header("Location: users.php");
}
?>
