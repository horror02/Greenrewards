<?php
// Include your database connection file
include_once "database.php";

// Query to get the latest level of the bin from the database
$sql = "SELECT bin_level FROM bin_data ORDER BY timestamp DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();
    // Get the bin level from the associative array
    $bin_level = $row['bin_level'];
} else {
    // If no data is found, set a default value for bin level
    $bin_level = 0;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garbage Bin Level Monitoring</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to the external CSS file -->
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
        <h1>Garbage Bin Level Monitoring</h1>
        <div class="garbage-bin">
            <div class="bin-level" style="height: <?php echo $bin_level; ?>%;">
            </div>
        </div>
        <p>Bin Level: <?php echo $bin_level; ?>%</p>
    </div>
</body>
</html>
