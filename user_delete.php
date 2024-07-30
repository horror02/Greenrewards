<?php
session_start();
require 'database.php';

$rfidTags = 0;

if (!empty($_GET['rfidTags'])) {
    $rfidTags = $_REQUEST['rfidTags'];
}

if (!empty($_POST)) {
    // keep track post values
    $rfidTags = $_POST['rfidTags'];
    
    // get admin last name from session
    $adminLastName = $_SESSION['lastName'];
    
    // connect to database
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // begin transaction
    $pdo->beginTransaction();
    
    try {
        // delete data (update user)
        $sql = "UPDATE user SET deletedAt = CURRENT_TIMESTAMP, remarks = '1' WHERE rfidTags = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($rfidTags));
        
        // insert into history table
        $sql = "INSERT INTO history (deletedAt, schoolId, remarks, registeredBy) 
                SELECT deletedAt, schoolId, remarks, ? FROM user WHERE rfidTags = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($adminLastName, $rfidTags));
        
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link rel="stylesheet" href="style5.css">
</head>
<body>
    <div class="container">
        <div class="span10 offset1">
            <div class="row">
                <h3 align="center">Delete User</h3>
            </div>
            <form class="form-horizontal" action="user_delete.php" method="post">
                <input type="hidden" name="rfidTags" value="<?php echo $rfidTags; ?>"/>
                <p class="alert alert-error">Are you sure you want to delete this user?</p>
                <div class="form-actions">
                    <button type="submit" class="btn btn-danger">Yes</button>
                    <a class="btn" href="users.php">No</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
