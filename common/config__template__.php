<?php

// Configuration for database connection
$host       = "mysql.yourdomain.com"; // hostname of DB server
$username   = "yourdbuser";           // username of DB user
$password   = "yourdbpass";           // obviously not the actual password :-)
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);