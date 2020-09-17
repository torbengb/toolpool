<?php

/**
 * Open a connection via PDO to create a
 * new database and table with structure.
 *
 */

require "config.php";

try {
    $connection = new PDO("mysql:host=$host", $username, $password, $options);
    $sql = file_get_contents("../data/init.sql");
    $connection->exec($sql);
    
    echo "Database and tables created successfully. Now <a href='../index.php'>go to the homepage</a>.";
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
