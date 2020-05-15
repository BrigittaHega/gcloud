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
        $error = '<span> User ID or password cannot be empty. </span>';
    } else {
        $key = $datastore->key('Users', $_POST["userid"]);
        $user = $datastore->lookup($key);
        if ( !isset( $user['name'] ) ) {
            $user = $datastore->entity('Users', [ 'userid' => $_POST["userid"], 'name' => $_POST["name"], 'password' => $_POST["password"] ]);
        } else {
            $error = "<span>This ID is already registered! </span>";
        }
    }
}
?>
<html>
    <head>
        <title>Eventica | Register</title>
        <link rel = "icon" type = "image/png" href = "/icon.png">
        <link rel = "apple-touch-icon" type = "image/png" href = "/icon.png"/>
    </head>
	<body>
    <div>
	   <img src="eventica.png" width="42" height="42"> <h1>Register</h1>
    </div>
    <div>
	    <h3>Please fill your data below to register.</h3>
    </div>
    <div>
        <form method="post">
            <label>Name:</label> <input type="text" name="name">
            <br>
            <label>User ID:</label> <input type="text" name="userid">
            <br>
            <label>Password:</label> <input type="password" name="password">
            <br>
            <input type="submit" value="Login"/>
    	</form>
        <label>Click this to <a href="login.php">login</a> if you already have an account!</label><br>
        <?php echo $error ?>
    </div>
    </body>
</html>
