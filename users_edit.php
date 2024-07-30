<?php
require 'database.php';
$rfidTags = null;
if (!empty($_GET['rfidTags'])) {
    $rfidTags = $_REQUEST['rfidTags'];
}

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM user WHERE rfidTags = ?";
$q = $pdo->prepare($sql);
$q->execute(array($rfidTags));
$data = $q->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style4.css">
    <script src="jquery.min.js"></script>
    <title>Edit Page</title>
</head>

<body>
    <div class="user-pass">
        <div class="registration">
            <h1>Edit Page</h1>
            <form class="click" action="users_edit_click.php?rfidTags=<?php echo $rfidTags ?>" method="post">
        </div>
        <div class="input">
            <input type="text" name="firstName" placeholder="First Name" value="<?php echo isset($data['firstName']) ? htmlspecialchars($data['firstName']) : ''; ?>" required>
        </div>
        <div class="input">
            <input type="text" name="lastName" placeholder="Last Name" value="<?php echo isset($data['lastName']) ? htmlspecialchars($data['lastName']) : ''; ?>" required>
        </div>
        <div class="input">
            <input type="text" name="middleName" placeholder="Middle Name" value="<?php echo isset($data['middleName']) ? htmlspecialchars($data['middleName']) : ''; ?>" required>
        </div>
        <div class="input">
            <input type="text" name="schoolId" placeholder="School ID" value="<?php echo isset($data['schoolId']) ? htmlspecialchars($data['schoolId']) : ''; ?>" required>
        </div>
        <div class="input">
            <input name="rfidTags" type="text" placeholder="" value="<?php echo isset($data['rfidTags']) ? $data['rfidTags'] : ''; ?>" readonly>
        </div>
        <button type="submit" name="login_btn" class="btn">Update</button>
        </form>
        <div class="nothing">
            <a href="users.php">Go Back?</a>
        </div>
    </div>
    </div>
</body>

</html>
