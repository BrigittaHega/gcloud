<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
    </head>
	<body>
	<h1>Login</h1>
	<h3>Please fill your data below to login.</h3>
    <form method="post">
		<label>Enter your user Id:</label>
		<input type="text" name="id" id="id"/>
		
		<br>
		
		<label>Enter your Password:</label>
		<input type="password" name="password" id="password"/>
		
		<br>
		
		<input type="submit" value="Login"/>
	</form>


<?php
session_start();
$id = $_POST['id'];
$password = $_POST['password'];
#to store in session to be used by other pages
$_SESSION['id'] = $id;
$_SESSION['password'] = $password;
# Includes the autoloader for libraries installed with composer
require __DIR__ . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Query\Query;

# Your Google Cloud Platform project ID
$projectId = 's3766172-cc2020';

# Instantiates a client
$datastore = new DatastoreClient([ 'projectId' => $projectId ]);
$key = $datastore->key('user', $id);
$entity = $datastore->lookup($key);
if(($entity["password"]) == $password) 
{
?>
<script type="text/javascript">
	window.location.href = "main";
</script>
<?php
}
else
{?>
<script type="text/javascript">
	alert ("User id or password is invalid");
</script>
<?php
}

?>
    </body>
</html>





