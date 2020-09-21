<?php

// Configuration for database connection
$host       = "mysql.golfbravo.net";
$username   = "torbengb";
$password   = "*AU8m##sKU72T7";
// $dbname     = "toolpool_dev"; // this was moved into 'common.php'!
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);