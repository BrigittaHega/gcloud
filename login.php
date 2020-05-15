<?php
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Query\Query;
include_once "vendor/autoload.php";
$datastore = new DatastoreClient([
    'projectId' => 'cloud-assignment-2-2020'
]);

session_start();
if(isset($_SESSION["id"])) {
    header("Location: main.php");
}

if ( isset( $_POST["Login"]) ) {
    if ( empty( $_POST["userid"]) or empty( $_POST["password"]) ) {
        $login_error = '<span> User ID or password cannot be empty. </span>';
    } else {
        $key = $datastore->key('Users', $_POST["userid"]);
        $user = $datastore->lookup($key);
        if ( isset( $user['name'] ) ) {
            if ( $user['password'] == $_POST["password"] ) {
                $_SESSION["id"] = $_POST["userid"];
                $_SESSION["name"] = $user['name'];
                $_SESSION["password"] = $user['password'];
                header("Location: main.php");
            } else {
                $login_error = "<span>Wrong password.</span>";
            }
        } else {
            $login_error = "<span>User ID or Password is invalid. </span>";
        }
    }
}
?>
<html>
    <head>
        <title>Eventica | Login</title>
        <link rel = "icon" href = "icon.png">
        <link rel = "apple-touch-icon" href = "icon.png">
    </head>
	<body>
    <div>
	    <h1><img src="eventica.png" alt="Eventica" width="42" height="42"> Login</h1>
    </div>
    <div>
	    <h3>Please fill your data below to login.</h3>
    </div>
    <div>
        <form action="login.php"  method="post">
            <label>User ID:</label> <input type="text" name="userid">
            <br>
            <label>Password:</label> <input type="password" name="password">
            <br>
            <input type="submit" value="Login"/>
    	</form>
        <label>Click this to <a href="register.php">register</a>!</label><br>
        <?php echo $login_error ?>
    </div>
    </body>
</html>
