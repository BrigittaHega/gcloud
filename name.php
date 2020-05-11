<!DOCTYPE html>
<html>
    <head>
        <title>Change name</title>
    </head>
	<body>
	<h1>Change Name</h1>
	<h3>Please fill your data below to change your name.</h3>
    <form method="post">
		<label>Enter your old username:</label>
		<input type="text" name="old_name" id="old_name"/>
		
		<br>
		
		<label>Enter your new username:</label>
		<input type="text" name="new_name" id="new_name"/>
		
		<br>
		
		<input type="submit" value="Change Name"/>
	</form>
<?php
session_start();
$old_name = $_POST['old_name'];
$new_name = $_POST['new_name'];
#to store in session to be used by other pages
$_SESSION['old_name'] = $old_name;
$_SESSION['new_name'] = $new_name;
# Includes the autoloader for libraries installed with composer
require __DIR__ . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Query\Query;

# Your Google Cloud Platform project ID
$projectId = 's3766172-cc2020';

$transaction = $datastore->transaction();
$key = $datastore->key('user', '$id');
$entity = $datastore->lookup($key);

if(($entity["name"]) == $old_name) 
{
	$task = $transaction->lookup($key);
	$task['name'] = $new_name;
	$transaction->update($task);
	$transaction->commit();
	header("Location: main");
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