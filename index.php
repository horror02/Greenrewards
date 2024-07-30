<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <title>Login</title>
</head>
<body>
    <div class="user-pass">
    <img src="logo1.jpg" alt="Logo" class="logo">
        <form action="Login_auth.php" method="POST"> <!-- Added method="POST" to the form -->
            <div class="admin">
                <h1>Admin</h1>
            </div>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <div class="input">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input">
                <input type="password" name="password" placeholder="Password" required> <!-- Changed input type to "password" -->
            </div>
            <button type="submit" name="login_btn" class="btn">LOG IN</button>
            <a href="adminreg.php">Sign Up</a>
        </form>
    </div>
</body>
</html>
