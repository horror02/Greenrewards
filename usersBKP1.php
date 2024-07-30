<?php
	$Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
	file_put_contents('UIDContainer.php',$Write);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style10.css">
    <title>Document</title>
</head>

<body>
<label>
       <!-- <input type="checkbox">
        <div class="toggle">
            <span class="top_line common"></span>
            <span class="middle_line common"></span>
            <span class="bottom_line common"></span>

        </div> -->
        <div class="dashboard">
            <h1>Home</h1>
            <ul>
                <li><a href="dashboard.php"><i class="home"></i>Dashboard</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="daily.php">Daily Monitoring</a></li>
                <li><a href="product.php">Product</a></li>
                <li> <button class="btn" onclick="window.location.href='logout.php';">Logout</button></li>
            </ul>
        </div>
    </label>
    <div class="container">
        <h2>Users</h2>
        <button class="btn" onclick="window.location.href='register.php';">Add User</button>

        <table class="tb1">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Middle Name</th>
                <th>RFID</th>
                <th>Student ID</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
               include 'database.php';
               $pdo = Database::connect();
               $sql = 'SELECT * FROM user';
               foreach ($pdo->query($sql) as $row) {
                        echo '<tr>';
                        echo '<td>'. $row['firstName'] . '</td>';
                        echo '<td>'. $row['lastName'] . '</td>';
                        echo '<td>'. $row['middleName'] . '</td>';
						echo '<td>'. $row['rfidTags'] . '</td>';
                        echo '<td>'. $row['schoolId'] . '</td>';
						echo '<td><a class="btn btn-success" href="users_edit.php ?rfidTags='.$row['rfidTags'].'">Edit</a>';
						echo ' ';
						echo '<a class="btn btn-danger" href="user_delete.php ?rfidTags='.$row['rfidTags'].'">Delete</a>';
						echo '</td>';
                         echo '</tr>';
                   }
               Database::disconnect();
           ?>
        </tbody>
        </table>
        
    </div>
</body>
<script src="jquery.min.js"></script>
</html>
