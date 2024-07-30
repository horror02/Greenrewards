<?php
// Include your database connection file
include_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = validate($_POST['username']);
        $password = validate($_POST['password']);

        if (empty($username)) {
            header("Location: Login.php?error=Username is required");
            exit();
        } elseif (empty($password)) {
            header("Location: Login.php?error=Password is required");
            exit();
        } else {
            // Establish a database connection
            $db = Database::connect();
            
            // Prepare and execute a parameterized query to prevent SQL injection
            $stmt = $db->prepare("SELECT * FROM admin WHERE username = :username");
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Verify the password using password_verify() if passwords are hashed
                if ($password == $user['password']) {
                    // Authentication successful, store user details in session
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['firstName'] = $user['firstName']; // Assuming these fields exist in your database
                    $_SESSION['lastName'] = $user['lastName'];
                    
                    // Redirect to dashboard or wherever needed
                    header("Location: dashboard.php");
                    exit();
                } else {
                    header("Location: index.php?error=Incorrect password");
                    exit();
                }
            } else {
                header("Location: index.php?error=User not found");
                exit();
            }
        }
    } else {
        header("Location: index.php?error");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
