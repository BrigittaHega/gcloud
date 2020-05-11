<?php

session_start();
$id = $_SESSION['id'];

#to store in session to be used by other pages

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
$username="Unknown";
if($entity!=null)
{
	$username=$entity['name'];	
} 
?>

<!DOCTYPE html>
<html>
<head>
 <title>Home</title>
</head>

<body>
Welcome,
<?php
	echo $username;
?>
<p>You can now change your name or your password.</p>
<p>Select one from below.</p>
<br/>
<input type="button" onclick="window.location.href='name'" value="Change Name"/>
<input type="button" onclick="window.location.href='password'" value="Change Password"/>
</body>
</html>