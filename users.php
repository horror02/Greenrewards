<?php
    $Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
    file_put_contents('UIDContainer.php',$Write);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style10.css">
    <style>
        .scrollable-container {
            max-height: 400px; /* Adjust the height as needed */
            overflow: auto;
        }
    </style>
    <title>User Management</title>
</head>
<body>
<label>
        <div class="sidebar" id="sidebar">
            <input type="checkbox">
            <div class="toggle">
                <span class="top_line common"></span>
                <span class="middle_line common"></span>
                <span class="bottom_line common"></span>
            </div>
            <div class="slide">
                <h1>User</h1>
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
                <div class="search-container">
                <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <input type="text" name="search" placeholder="Search">
                    <button type="submit">Search</button>
                </form>
            </div>
        <div class="scrollable-container">
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

                            // Check if search parameter is set
                            if(isset($_GET['search'])) {
                                $search = $_GET['search'];
                                $sql = "SELECT * FROM user WHERE schoolId LIKE '%$search%' AND remarks != '1'";
                            } else {
                                $sql = "SELECT * FROM user WHERE remarks = '0'";
                            }

                            foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
                                echo '<td>'. $row['firstName'] . '</td>';
                                echo '<td>'. $row['lastName'] . '</td>';
                                echo '<td>'. $row['middleName'] . '</td>';
                                echo '<td>'. $row['rfidTags'] . '</td>';
                                echo '<td>'. $row['schoolId'] . '</td>';
                                echo '<td>';
                                echo '<a class="btn edit-btn" href="users_edit.php?rfidTags='.$row['rfidTags'].'">Edit</a>';
                                echo '<a class="btn delete-btn" href="user_delete.php?rfidTags='.$row['rfidTags'].'">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            Database::disconnect();
                        ?>
                    </tbody>
                </table>
            </div>
            <button class="btn add-user-btn" onclick="window.location.href='register.php';">Add User</button>
        </div>
    </div>

</body>
<script src="jquery.min.js"></script>
</html>
