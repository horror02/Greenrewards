<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style12.css">
    <script src="jquery.min.js"></script>
    <title>Document</title>

</head>
<body>
<div class="user-pass">
    <form action="insertDB.php" method="post">
        <div class="registration">
            <h1>Registration </h1>
        </div>
        <div class="input">
            <input type="text" name="firstName" placeholder="First Name" required>
        </div>
        <div class="input">
            <input type="text" name="lastName" placeholder="Last Name" required>
        </div>
        <div class="input">
            <input type="text" name="middleName" placeholder="Middle Name">
        </div>
        <div class="input">
            <input type="text" name="schoolId" placeholder="School ID" required>
        </div>
        <div class="input">
            <textarea name="rfidTags" id="getUID" placeholder="RFID TAGS" required></textarea>
        </div>
                 
        <div class="form-actions">
            <button type="submit" name="login_btn" class="btn">Save</button>
        </div>
        <div class="nothing">
            <a href="users.php">Go Back?</a>
        </div>
    </form>
</div>

<script>
    $(document).ready(function(){
        $("#getUID").load("UIDContainer.php");
        setInterval(function() {
            $("#getUID").load("UIDContainer.php");
        }, 500);
    });
</script>
</body>
</html>
