<?php
include 'database.php';

// Check if the search form is submitted
if(isset($_GET['search'])) {
    // Get the search term from the form
    $searchTerm = $_GET['search'];
    
    // Prepare and execute the SQL query
    $pdo = Database::connect();
    $sql = "SELECT * FROM user WHERE schoolId LIKE :searchTerm";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':searchTerm', "%$searchTerm%");
    $stmt->execute();
    
    // Display the search results in a table
    echo '<table class="tb1">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>First Name</th>';
    echo '<th>Last Name</th>';
    echo '<th>Middle Name</th>';
    echo '<th>RFID</th>';
    echo '<th>Student ID</th>';
    echo '<th>Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = $stmt->fetch()) {
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
    echo '</tbody>';
    echo '</table>';
    
    Database::disconnect();
} else {
    // Display all records if search form is not submitted
    echo '<table class="tb1">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>First Name</th>';
    echo '<th>Last Name</th>';
    echo '<th>Middle Name</th>';
    echo '<th>RFID</th>';
    echo '<th>Student ID</th>';
    echo '<th>Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    $pdo = Database::connect();
    $sql = 'SELECT * FROM user';
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
    echo '</tbody>';
    echo '</table>';
    
    Database::disconnect();
}
?>
