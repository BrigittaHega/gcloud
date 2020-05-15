<?php
session_start();
include_once "vendor/autoload.php";

if(!isset($_SESSION["id"])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Eventica | Home</title>
	<link rel = "apple-touch-icon" type = "image/png" href = "/icon.png"/>
</head>
<body>
    <div>
        <p>Logged in as <?php echo $_SESSION["name"] ?></p><br><br>
        <a href="name.php"><button>Change Name</button></a><br>
        <a href="password.php"><button>Change Password</button></a><br><br>
        <hr>
        <h1> Main Content</h1>
    </div>
</body>
</html>
