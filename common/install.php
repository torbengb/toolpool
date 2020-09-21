<?php
require "common.php";

try {
    $connection = new PDO("mysql:host=$host", $username, $password, $options);
    
    $sql = "CREATE DATABASE IF NOT EXISTS " . $dbname; // first create database
    $connection->exec($sql);
    $sql = "USE " . $dbname; // then open database
    $connection->exec($sql);
    $sql = file_get_contents("init.sql"); // and then create tables
    $connection->exec($sql);
    
    echo "Database and tables created successfully. Now <a href='../index.php'>go to the homepage</a>.";
} catch(PDOException $error) {
    echo /* $sql . "<br>" . */ $error->getMessage() . " Try visiting <a href='../index.php'>the homepage</a>.";
}
