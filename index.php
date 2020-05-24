<?php
include_once "vendor/autoload.php";
session_start();
if( isset($_SESSION["Login"]) ) {
    header("Location: main.php");
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

            .topnav a:hover {
              background-color: #ddd;
              color: black;
            }

            .topnav a.active {
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
            <h1>Eventica - Online Event Ticketing</h1>
        </div>
    </body>
</html>
