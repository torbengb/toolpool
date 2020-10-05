<?php
require "common.php";

function runsqlfile($file) {
  $sql = file_get_contents($file);
  $connection->exec($sql);
  return;
}

try
{ // first create database:
  $sql = "CREATE DATABASE IF NOT EXISTS " . $dbname; 
  $connection->exec($sql);
  // then open database:
  $sql = "USE " . $dbname; 
  $connection->exec($sql);
  // and then create tables:
  //$sql = file_get_contents("init.sql");
  //$connection->exec($sql);
  runsqlfile("init.sql");
  echo "Successfully created database and tables.<br>";
  runsqlfile("taxonomy.sql");
  runsqlfile("countries.sql");
  runsqlfile("regions.sql");
  echo "Successfully inserted base data.<br>";

  // now load test data unless it's in production:
  switch ($dbname) { // determine environment:
    case "toolpool": // do nothing in production!
      break;
    case "toolpool_dev":
    case "toolpool_test":
      runsqlfile("testdata.sql");
      echo "Successfully inserted test data.<br>";
      break;
    default:
      die('Cannot insert test data into unknown environment!<br>');
  }

  echo "Now <a href='../index.php'>go to the homepage</a>.";
} catch(PDOException $error) {
    echo /* $sql . "<br>" . */ $error->getMessage() . " Try visiting <a href='../index.php'>the homepage</a>.";
}
