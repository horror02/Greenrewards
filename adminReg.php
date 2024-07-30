<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style12.css">
    <title>Document</title>
</head>
<body>
<div class="user-pass">
<img src="logo1.jpg" alt="Logo" class="logo">
        <form action="process.php" method="post">
        <div class="admin">
                <h1>Admin Registration</h1>
         </div>
         <?php
        // Check for error message
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            echo '<div class="error">' . htmlspecialchars($error) . '</div>';
        }

        // Check for success message
        if (isset($_GET['success'])) {
            $success = $_GET['success'];
            echo '<div class="success">' . htmlspecialchars($success) . '</div>';
        }
        ?>
            <div class="input">
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="input">
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="input">
                <input type="text" id="firstname" name="firstname" placeholder="First Name" required>
            </div>
            <div class="input">
                <input type="text" id="lastname" name="lastname" placeholder="Last Name" required>
            </div>
            <button type="submit" class="btn">Sign Up</button>
            <a href="index.php">Go Back</a>
        </form>
    </div>
</body>
</html>