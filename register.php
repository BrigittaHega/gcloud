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

if ( isset( $_POST["Submit"]) ) {
    if ( empty( $_POST["userid"]) or empty( $_POST["password"] ) or empty( $_POST["name"]) ) {
        $error = '<span> User ID or Name or Password cannot be empty. </span>';
    } else {
        $key = $datastore->key('Users', $_POST["userid"]);
        $user = $datastore->lookup($key);
        if ( empty($user['name']) ) {
            $user = $datastore->entity($key, [ 'name' => $_POST["name"], 'password' => $_POST["password"] ]);
            $datastore->insert($user);
            header("Location: login.php");
        } else {
            $error = "<span>This ID is already registered! </span>";
        }
    }
}
?>

<html>
    <head>
        <title>Eventica | Register</title>
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
    	    <h1> Register</h1>
        </div>
        <div>
    	    <h3>Please fill your data below to register.</h3>
        </div>
        <div>
            <form action="register.php" method="POST">
                <label>Name:</label> <input type="text" name="name">
                <br>
                <label>User ID:</label> <input type="text" name="userid">
                <br>
                <label>Password:</label> <input type="password" name="password">
                <br>
                <input type="submit" name="Submit" value="Submit"/>
        	</form>
            <label>Click this to <a href="login.php">login</a> if you already have an account!</label><br>
            <?php echo $error ?>
        </div>
    </body>
</html>
