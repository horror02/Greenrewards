<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Deleted Accounts</title>
    <link rel="stylesheet" href="style10.css">
</head>
<label>
        <div class="sidebar" id="sidebar">
            <input type="checkbox">
            <div class="toggle">
                <span class="top_line common"></span>
                <span class="middle_line common"></span>
                <span class="bottom_line common"></span>
            </div>
            <div class="slide">
                <h1>Account Recovery</h1>
                <ul>
                    <li><a href="dashboard.php"><img src="history.png" alt="Dashboard Icon">Dashboard</a></li>
                    <li><a href="users.php"><img src="user.png" alt="Users Icon">Users</a></li>
                    <li><a href="product.php"><img src="product.png" alt="Product Icon">Product</a></li>
                    <li><a href="recover.php"><img src="recovery.png" alt="Recovery Icon">Account Recovery</a></li>
                </ul>
                <button class="logout-btn" onclick="window.location.href='logout.php';">Logout</button>
            </div>
        </div>
    </label>
    <div class="header">
        <div></div>
        <img src="logo1.jpg" alt="Logo">
    </div>
    <div class="content">
        <div class="container">
            <h2>Deleted Accounts</h2>
            <table class="tb1">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>School ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include 'database.php';
                        $pdo = Database::connect();
                        $sql = "SELECT * FROM user WHERE remarks = '1'";
                        foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['firstName'] . '</td>';
                            echo '<td>'. $row['lastName'] . '</td>';
                            echo '<td>'. $row['schoolId'] . '</td>';
                            echo '<td>';
                            echo '<a class="btn recover-btn" href="recover_account.php?rfidTags='.$row['rfidTags'].'">Recover</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        Database::disconnect();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script src="jquery.min.js"></script>
</html>
