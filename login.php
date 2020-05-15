<?php
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Query\Query;
require __DIR__ . '/vendor/autoload.php';
$datastore = new DatastoreClient([
    'projectId' => 'cloudassg-2020'
]);

session_start();

if ( isset( $_POST["login"]) ) {
    if ( empty( $_POST["userid"]) or empty( $_POST["password"]) ) {
        <script type="text/javascript">
           alert ("User ID or password cannot be empty!");
        </script>
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
                <script type="text/javascript">
            	   alert ("Wrong Password!");
                </script>
            }
        } else {
            <script type="text/javascript">
               alert ("Wrong UserID or Password!");
            </script>
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Eventica | Login</title>
        <link rel = "icon" type = "image/png" href = "/icon.png">
        <link rel = "apple-touch-icon" type = "image/png" href = "/icon.png"/>
    </head>
	<body>
    <div>
	   <img src="eventica.png" width="42" height="42"> <h1>Login</h1>
    </div>
    <div>
	    <h3>Please fill your data below to login.</h3>
    </div>
    <div>
        <form method="post">
		    <label>Username:</label>
		    <input type="text" name="id" id="id"/>
            <br>
    		<label>Password:</label>
    		<input type="password" name="password" id="password"/>
    		<br>
    		<input type="submit" value="Login"/>
    	</form>
    </div>
    </body>
</html>
