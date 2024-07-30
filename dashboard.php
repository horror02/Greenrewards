<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start or resume the session

// Initialize variables with empty values
$firstName = '';
$lastName = '';

// Check if session variables are set and not empty
if (isset($_SESSION['firstName'])) {
    $firstName = $_SESSION['firstName'];
}
if (isset($_SESSION['lastName'])) {
    $lastName = $_SESSION['lastName'];
}

// Function to get total points in the last 24 hours
function getTotalPointsLast24Hours() {
    require_once 'database.php'; // Ensure this is included only once
    $pdo = Database::connect();
    $sql = 'SELECT SUM(points) as totalPoints FROM pointHistory WHERE date >= NOW() - INTERVAL 1 DAY';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $result['totalPoints'];
}

// Function to get total points in the last 7 days
function getTotalPointsLast7Days() {
    require_once 'database.php';
    $pdo = Database::connect();
    $sql = 'SELECT SUM(points) as totalPoints FROM pointHistory WHERE date >= NOW() - INTERVAL 7 DAY';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $result['totalPoints'];
}

// Function to get total points in the last month
function getTotalPointsLastMonth() {
    require_once 'database.php';
    $pdo = Database::connect();
    $sql = 'SELECT SUM(points) as totalPoints FROM pointHistory WHERE date >= NOW() - INTERVAL 1 MONTH';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $result['totalPoints'];
}

$totalPointsLast24Hours = getTotalPointsLast24Hours();
$totalPointsLast7Days = getTotalPointsLast7Days();
$totalPointsLastMonth = getTotalPointsLastMonth();
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
        .scrollable-container2 {
            max-height: 400px; /* Adjust the height as needed */
            overflow: auto;
        }
        .circle-charts {
            display: flex;
            justify-content: space-around;
            margin: 20px auto;
            z-index: 1;
        }
        .circle-chart {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
            width: 200px;
            border-radius: 50%;
            background: conic-gradient(#4CAF50 <?php echo $totalPointsLast24Hours; ?>%, #ddd 0);
            position: relative;
            margin: 10px;
        }
        .circle-chart span {
            position: absolute;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
            border-radius: 50%;
            background: #fff;
            font-size: 20px;
            font-weight: bold;
            color: #4CAF50;
        }
    </style>
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
            <h1><?php echo htmlspecialchars($firstName . ' ' . $lastName); ?></h1>
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
        <h3>Account Logs</h3>
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
                    require_once 'database.php';
                    $pdo = Database::connect();
                    $sql = 'SELECT schoolId, remarks, updatedAt, createdAt, deletedAt, recoveredAt, registeredBy FROM history ORDER BY COALESCE(updatedAt, deletedAt, recoveredAt, createdAt) DESC'; // Order by the latest timestamp
                    foreach ($pdo->query($sql) as $row) {
                        echo '<tr>';
                        echo '<td>'. (isset($row['schoolId']) ? htmlspecialchars($row['schoolId']) : '') . '</td>';
                        echo '<td>';
                        if (isset($row['remarks'])) {
                            if ($row['remarks'] === '1') {
                                echo 'Deleted';
                            } elseif ($row['remarks'] === '0') {
                                echo 'Created';
                            } else {
                                echo htmlspecialchars($row['remarks']);
                            }
                        }
                        echo '</td>';
                        echo '<td>';
                        if (isset($row['remarks'])) {
                            if ($row['remarks'] === '1' && isset($row['deletedAt'])) {
                                echo date('Y-m-d H:i:s', strtotime($row['deletedAt']));
                            } elseif ($row['remarks'] === 'recovered' && isset($row['recoveredAt'])) {
                                echo date('Y-m-d H:i:s', strtotime($row['recoveredAt']));
                            } elseif ($row['remarks'] === 'updated' && isset($row['updatedAt'])) {
                                echo date('Y-m-d H:i:s', strtotime($row['updatedAt']));
                            } elseif (isset($row['createdAt'])) {
                                echo date('Y-m-d H:i:s', strtotime($row['createdAt']));
                            }
                        }
                        echo '</td>';
                        echo '<td>'. (isset($row['registeredBy']) ? htmlspecialchars($row['registeredBy']) : '') . '</td>';
                        echo '</tr>';
                    }
                    Database::disconnect();
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="container2">
        <h3>Points Logs</h3>
        <div class="scrollable-container2">
            <table class="tb2">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Points</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $pdo = Database::connect();
                        $sql = 'SELECT schoolId, points, date FROM pointHistory ORDER BY date DESC';
                        foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. (isset($row['schoolId']) ? htmlspecialchars($row['schoolId']) : '') . '</td>';
                            echo '<td>'. (isset($row['points']) ? htmlspecialchars($row['points']) : '') . '</td>';
                            echo '<td>'. (isset($row['date']) ? date('Y-m-d H:i:s', strtotime($row['date'])) : '') . '</td>';
                            echo '</tr>';
                        }
                        Database::disconnect();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="circle-charts">
    <div class="circle-chart">
        <span><?php echo $totalPointsLast24Hours; ?> pts (24h)</span>
    </div>
    <div class="circle-chart">
        <span><?php echo $totalPointsLast7Days; ?> pts (7d)</span>
    </div>
    <div class="circle-chart">
        <span><?php echo $totalPointsLastMonth; ?> pts (1m)</span>
    </div>
</div>
</body>
</html>
