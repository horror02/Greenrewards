<?php
session_start(); // Start or resume the session

// Assuming you have stored first name and last name in session after login
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style9.css">
    <style>
        .scrollable-container {
            max-height: 400px; /* Adjust the height as needed */
            overflow: auto;
        }
    </style>
</head>
<body>
<div class="star" style="top: 20px; left: 20px;"></div>
    <div class="star" style="top: 100px; right: 100px;"></div>
   <!-- <div class="star" style="bottom: 80px; left: 150px;"></div> -->
    <div class="star" style="bottom: 20px; right: 50px;"></div>
    <div class="sidebar" id="sidebar">
    <h1><?php echo htmlspecialchars($firstName . ' ' . $lastName); ?></h1>
        <ul>
            <li><a href="dashboardBKP.php">Dashboard</a></li>
            <li><a href="usersBKP.php">Users</a></li>
            <li><a href="product.php">Product</a></li>
            <li><a href="recover.php">Account Recovery</a></li>
        </ul>
        <button class="logout-btn" onclick="window.location.href='logout.php';">Logout</button>
    </div>

    <div class="content">
        <div class="container">
            <h2>History</h2>
            <div class="scrollable-container">
                <table class="tb1">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Transaction</th>
                            <th>Date</th>
                            <th>Action By</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        include 'database.php';
                        $pdo = Database::connect();
                        $sql = 'SELECT schoolId, remarks, updatedAt, createdAt, deletedAt, recoveredAt, registeredBy FROM history ORDER BY COALESCE(updatedAt, deletedAt, recoveredAt, createdAt) DESC'; // Order by the latest timestamp
                        foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. htmlspecialchars($row['schoolId']) . '</td>';
                            echo '<td>';
                            if ($row['remarks'] === '1') {
                                echo 'Deleted';
                            } elseif ($row['remarks'] === '0') {
                                echo 'Created';
                            } else {
                                echo htmlspecialchars($row['remarks']);
                            }
                            echo '</td>';
                            echo '<td>';
                            if ($row['remarks'] === '1') {
                                echo date('Y-m-d H:i:s', strtotime($row['deletedAt']));
                            } elseif ($row['remarks'] === 'recovered') {
                                echo date('Y-m-d H:i:s', strtotime($row['recoveredAt']));
                            } elseif ($row['remarks'] === 'updated') {
                                echo date('Y-m-d H:i:s', strtotime($row['updatedAt']));
                            }
                            else {
                                echo date('Y-m-d H:i:s', strtotime($row['createdAt']));
                            }
                            echo '</td>';
                            echo '<td>'. htmlspecialchars($row['registeredBy']) . '</td>';
                            echo '</tr>';
                        }
                        Database::disconnect();
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
