<?php
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Query\Query;
include_once "vendor/autoload.php";
session_start();

if(!isset($_SESSION["id"])) {
    header("Location: login.php");
}

$datastore = new DatastoreClient([
    'projectId' => 'php-datastore-assignment'
]);

if ( isset( $_POST["submit"]) ) {
    if ( empty( $_POST["name"])) {
          $error = '<span> Name be empty. </span>';
    } else {
        $transaction = $datastore->transaction();
        $key = $datastore->key('Users', $_SESSION["id"]);
        $user = $transaction->lookup($key);
        $user['name'] = $_POST["name"];
        $_SESSION["name"] = $user['name'];
        $transaction->update($user);
        $transaction->commit();
        header("Location: main.php");
    }
}
?>
<html>
<body>
    <div>
        <p>Logged in as <?php echo $_SESSION["name"] ?></p><br><br>
        <hr>
        <h1>Change Name</h1>
        <div>
            <form action="name.php" method="POST">
                New Name: <input type="text" name="name"><br>
                <input type="submit" name="submit" value="Submit">
            </form>
            <?php echo $login_error ?>
        </div>
    </div>
</body>
</html>
