<?php
include_once "vendor/autoload.php";
session_start();

if( !isset($_SESSION["Login"]) ) {
    header("Location: login.php");
}

$datastore = new DatastoreClient([
    'projectId' => 'php-datastore-assignment'
]);

if ( isset( $_POST["Submit"]) ) {
    if ( empty( $_POST["eventName"]) or empty( $_POST["eventTime"] ) or empty( $_POST["eventDescription"]) or empty( $_POST["eventDate"]) or empty( $_POST["eventAddress"]) or empty( $_POST["eventOrganizer"]) ) {
        $error = '<span> Event Name or Organizer or Description or Date or Address or Time cannot be empty. </span>';
    } else {
        $EventKey = $datastore->key('EventNumber', 'EventNumber');
        $transaction = $datastore->transaction();
        $EventNumber = $transaction->lookup($EventKey);
        $EventNumber['EventNumber'] += 1;
        $transaction->update($EventNumber);
        $transaction->commit();
        $EventID = $EventNumber['EventNumber'];

        $key = $datastore->key('Events', $EventID);
        $event = $datastore->lookup($key);
        $event = $datastore->entity($key, [ 'EventName' => $_POST["eventName"], 'EventDescription' => $_POST["eventDescription"], 'EventDate' => $_POST["eventDate"], 'EventTime' => $_POST["eventTime"], 'EventOrganizer' => $_POST["eventOrganizer"], 'EventAddress' => $_POST["eventAddress"] ]);
        $datastore->insert($event);
        header("Location: events.php");
    }
}
 ?>

<html>
    <head>
        <title>Eventica</title>
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

            .dropdown {
              float: left;
              overflow: hidden;
            }

            .dropdown .dropbtn {
              font-size: 16px;
              border: none;
              outline: none;
              color: white;
              padding: 14px 16px;
              background-color: inherit;
              font-family: inherit;
              margin: 0;
            }

            .dropdown-content {
              display: none;
              position: absolute;
              background-color: #f9f9f9;
              min-width: 160px;
              box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
              z-index: 1;
            }

            .dropdown-content a {
              float: none;
              color: black;
              padding: 12px 16px;
              text-decoration: none;
              display: block;
              text-align: left;
            }

            .dropdown-content a:hover {
              background-color: #ddd;
            }

            .dropdown:hover .dropdown-content {
              display: block;
            }
        </style>
    </head>
	<body>
        <div class="topnav">
            <a  href="index.php">Home</a>
            <a href="createevents.php">Create Event</a>
            <div class="dropdown">
                <button class="dropbtn"><?php echo $_SESSION["name"] ?><i class="fa fa-caret-down"></i></button>
                <div class="dropdown-content">
                    <a href="name.php">Change Name</a>
                    <a href="password.php">Change Password</a>
                    <a href="logout.php">Log Out</a>
                </div>
            </div>
        </div>
        <div>
            <h1>Eventica - Online Event Ticketing</h1>
        </div>
        <div>
            <h2>Create Events</h3>
    	    <h3>Please fill your data below to register.</h3>
        </div>
        <div>
            <form action="events.php" method="POST">
                <label>Event Name:</label> <input type="text" name="eventName">
                <br>
                <label>Event Organizer:</label> <input type="text" name="eventOrganizer">
                <br>
                <label>Event Address:</label> <input type="text" name="eventAddress">
                <br>
                <label>Event Date:</label> <input type="text" name="eventDate">
                <br>
                <label>Event Time:</label> <input type="text" name="eventTime">
                <br>
                <label>Event Description:</label>
                <br>
                <textarea name="eventDescription">
                <br>
                <input type="submit" name="Submit" value="Submit"/>
        	</form>
            <?php echo $error ?>
        </div>
    </body>
</html>
