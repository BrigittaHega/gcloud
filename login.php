<?php
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Query\Query;
include_once "vendor/autoload.php";
$datastore = new DatastoreClient([
    'projectId' => 'cloud-assignment-2-2020'
]);

session_start();
if( isset($_SESSION["Login"]) ) {
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
                $_SESSION["Login"] = true;
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
        <style>
            .topnav {
              background-color: #333;
              overflow: hidden;
            }

            .topnav a {
              float: left;
              color: #f2f2f2;
              text-align: center;
              padding: 14px 16px;
              text-decoration: none;
              font-size: 17px;
            }

            .topnav a:hover, .dropdown:hover .dropbtn {
              background-color: #ddd;
              color: black;
            }

            .topnav a:active {
              background-color: #ffffff;
              color: white;
            }
        </style>
    </head>
	<body>
        <div class="topnav">
            <a  href="index.php">Home</a>
            <a href="events.php">Events</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </div>
        <div>
    	    <h1>Login</h1>
        </div>
        <div>
    	    <h3>Please fill your data below to login.</h3>
        </div>
        <div>
            <form action="login.php"  method="POST">
                <label>User ID:</label> <input type="text" name="userid">
                <br>
                <label>Password:</label> <input type="password" name="password">
                <br>
                <input type="submit" name= "Login" value="Login"/>
        	</form>
            <label>Click this to <a href="register.php">register</a>!</label><br>
            <?php echo $login_error ?>
        </div>
    </body>
</html>
