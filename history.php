<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style3.css">
    <title>Document</title>
</head>
<body>
<div class="container">
        <div class="tb1_container">
        <h2>History</h2>
        <table class="tb1">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Plastic Weight (Grams)</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
               include 'database.php';
               $pdo = Database::connect();
               $sql = 'SELECT * FROM history ORDER BY date DESC';
               foreach ($pdo->query($sql) as $row) {
                        echo '<tr>';
                        echo '<td>'. $row['schoolId'] . '</td>';
                        echo '<td>'. $row['remarks'] . '</td>';
                        echo '<td>'. $row['createdAt'] . '</td>';
                        echo '</tr>';
                   }
               Database::disconnect();
           ?>
        </tbody>
        </table>
        
        </div>
    </div>
</body>
</html>