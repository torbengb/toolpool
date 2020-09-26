<?php
require "common.php";

try
{ // first create database:
  $sql = "CREATE DATABASE IF NOT EXISTS " . $dbname; 
  $connection->exec($sql);
  // then open database:
  $sql = "USE " . $dbname; 
  $connection->exec($sql);
  // and then create tables:
  $sql = file_get_contents("init.sql");
  $connection->exec($sql);
  echo "Successfully created database and tables. ";
  
  // now load test data unless it's in production:
  switch ($dbname) { // determine environment:
    case "toolpool": // do nothing in production!
      break;
    case "toolpool_dev":
    case "toolpool_test":
      $sql = file_get_contents("testdata.sql");
      break;
    default:
      die('Cannot insert test data into unknown environment!');
  }
  echo "Successfully inserted test data. ";

  echo "Now <a href='../index.php'>go to the homepage</a>.";
} catch(PDOException $error) {
    echo /* $sql . "<br>" . */ $error->getMessage() . " Try visiting <a href='../index.php'>the homepage</a>.";
}
