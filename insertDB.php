<!DOCTYPE html>
<html>
<head>
    <title>Error Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }

        .error-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .error-title {
            font-size: 24px;
            color: #FF5733;
            margin-bottom: 20px;
        }

        .error-message {
            font-size: 18px;
            color: #FF5733;
            margin-bottom: 20px;
        }

        .goback-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .goback-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-title">Error</div>
        <div class="error-message">
            <?php
            session_start(); // Start or resume the session

            // Assuming you have stored first name and last name in session after login
            $adminFirstName = $_SESSION['firstName'];
            $adminLastName = $_SESSION['lastName'];

            require 'database.php'; // Make sure this file includes the database connection

            if (!empty($_POST)) {
                // Keep track of post values
                $firstName = $_POST['firstName'];
                $lastName = $_POST['lastName'];
                $middleName = $_POST['middleName'];
                $rfidTags = $_POST['rfidTags'];
                $schoolId = $_POST['schoolId'];

                // Check if RFID tag and schoolId already exist
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $checkRfidSql = "SELECT COUNT(*) FROM user WHERE rfidTags = ?";
                $checkRfidQuery = $pdo->prepare($checkRfidSql);
                $checkRfidQuery->execute([$rfidTags]);
                $countRfid = $checkRfidQuery->fetchColumn();

                $checkSchoolSql = "SELECT COUNT(*) FROM user WHERE schoolId = ?";
                $checkSchoolQuery = $pdo->prepare($checkSchoolSql);
                $checkSchoolQuery->execute([$schoolId]);
                $countSchool = $checkSchoolQuery->fetchColumn();

                if ($countRfid > 0) {
                    // RFID tag already exists, show error message or handle as needed
                    echo "RFID tag already exists in the database.";
                } elseif ($countSchool > 0) {
                    // School ID already exists, show error message or handle as needed
                    echo "School ID already exists in the database.";
                } else {
                    // RFID tag and School ID do not exist, proceed with insertion
                    $password = '123'; // No need to hash the password as per your requirement
                    $pin = '123';
                    $remarks = '0';

                    $userSql = "INSERT INTO user (firstName, lastName, middleName, rfidTags, schoolId, password, pin, createdAt, remarks) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)";
                    $userQuery = $pdo->prepare($userSql);
                    $userQuery->execute([$firstName, $lastName, $middleName, $rfidTags, $schoolId, $password, $pin, $remarks]);

                    // Insert into history table with admin's lastName
                    $historySql = "INSERT INTO history (schoolId, remarks, createdAt, registeredBy) VALUES (?, '0', NOW(), ?)";
                    $historyQuery = $pdo->prepare($historySql);
                    $historyQuery->execute([$schoolId, $adminLastName]);

                    // Insert into points table
                    $checkPointsSql = "SELECT COUNT(*) FROM points WHERE rfidTags = ? AND schoolId = ?";
                    $checkPointsQuery = $pdo->prepare($checkPointsSql);
                    $checkPointsQuery->execute([$rfidTags, $schoolId]);
                    $countPoints = $checkPointsQuery->fetchColumn();

                    if ($countPoints == 0) {
                        // User does not exist in points table, proceed with insertion
                        $pointsSql = "INSERT INTO points (rfidTags, schoolId, lastName, point) VALUES (?, ?, ?, 0)";
                        $pointsQuery = $pdo->prepare($pointsSql);
                        $pointsQuery->execute([$rfidTags, $schoolId, $lastName]);
                    }

                    Database::disconnect();
                    header("Location: users.php");
                    exit(); // Make sure to exit after redirecting
                }
            } else {
                echo "No data received.";
            }
            ?>
        </div>
        <a href="register.php" class="goback-button">Go Back</a>
    </div>
</body>
</html>
