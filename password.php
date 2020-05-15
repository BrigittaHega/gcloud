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
    if ( empty( $_POST["oldpass"]) or empty( $_POST["newpass"]) ) {
        $error = '<span> Old Password or New Password can not be empty. </span>';
    } else {
        $transaction = $datastore->transaction();
        $key = $datastore->key('Users', $_SESSION["id"]);
        $user = $transaction->lookup($key);
        if ( $user['password'] == $_POST["oldpass"] ) {
            $user['password'] = $_POST["newpass"];
            $_SESSION["password"] = $user['password'];
            $transaction->update($user);
            $transaction->commit();
            header("Location: main.php");
        } else {
            $error = "<span>Wrong password. </span>";
        }
    }
}
?>
<html>
    <head>
        <title>Eventica | Change Password</title>
        <link rel = "icon" href = "icon.png">
        <link rel = "apple-touch-icon" href = "icon.png">
    </head>
<body>
    <div>
        <p>Logged in as <?php echo $_SESSION["name"] ?></p><br><br>
        <hr>
        <h1>Change Password</h1>
        <div>
            <form action="password.php" method="POST">
                Old Password: <input type="password" name="oldpass"><br>
                New Password: <input type="password" name="newpass"><br>

                <input type="submit" name="submit" value="Submit">
            </form>
            <?php echo $login_error ?>
        </div>
    </div>
</body>
</html>
