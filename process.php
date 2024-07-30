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

    if (isset($_POST['username'], $_POST['password'], $_POST['firstname'], $_POST['lastname'])) {
        $username = validate($_POST['username']);
        $password = validate($_POST['password']);
        $firstname = ($_POST['firstname']);
        $lastname = ($_POST['lastname']);

        if (empty($username)) {
            header("Location: adminReg.php?error=Username is required");
            exit();
        } elseif (empty($password)) {
            header("Location: adminReg.php?error=Password is required");
            exit();
        } elseif (empty($firstname)) {
            header("Location: adminReg.php?error=First name is required");
            exit();
        } elseif (empty($lastname)) {
            header("Location: adminReg.php?error=Last name is required");
            exit();
        } else {
            // Establish a database connection
            $db = Database::connect();
            
            // Check if username already exists
            $stmt = $db->prepare("SELECT * FROM admin WHERE username = :username");
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Username already exists
                header("Location: adminReg.php?error=Username already exists");
                exit();
            } else {
                // Insert new user into database
                $insert_query = "INSERT INTO admin(username, password, firstName, lastName)
                                 VALUES (:username, :password, :firstname, :lastname)";
                $insert_stmt = $db->prepare($insert_query);
                $insert_stmt->bindParam(':username', $username);
                $insert_stmt->bindParam(':password', $password);
                $insert_stmt->bindParam(':firstname', $firstname);
                $insert_stmt->bindParam(':lastname', $lastname);

                if ($insert_stmt->execute()) {
                    // Registration successful
                    header("Location: adminReg.php?success=Registration complete. You can now login.");
                    exit();
                } else {
                    // Error inserting record
                    header("Location: adminReg.php?error=Something went wrong. Please try again later.");
                    exit();
                }
            }
        }
    } else {
        header("Location: adminReg.php?error=All fields are required");
        exit();
    }
} else {
    header("Location: adminReg.php");
    exit();
}
?>
