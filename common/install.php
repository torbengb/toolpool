<?php
require "common.php";

function runsqlfile($file) {
  //echo __LINE__ . "<br>";
  $sql = file_get_contents($file);
  $connection->exec($sql);
  //echo __LINE__ . "<br>";
  return;
}

/**
 * @param PDO $connection
 */
function arst(PDO $connection, str $file): void
{
  echo __LINE__ . "<br>";
  $sql = file_get_contents($file);
  $connection->exec($sql);
  echo __LINE__ . "<br>";
}

try {
// first create database:
  /* INSTALLER CANNOT CREATE DATABASE on DreamHost!! (and neither can a local SQL client!)
   * The database MUST exist before the installer is run!
   * The installer can do everything after that.
  $sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;
  $connection->exec($sql);
   */
  echo __LINE__ . "<br>";
// then open database:
  $sql = "USE " . $dbname;
  $connection->exec($sql);
  echo __LINE__ . "<br>";
  // and then create tables:
  $sql = file_get_contents("../database/countries.sql");
  $connection->exec($sql);
  echo __LINE__ . "<br>";
  $sql = file_get_contents("../database/regions.sql");
  $connection->exec($sql);
  $sql = file_get_contents("../database/users.sql");
  $connection->exec($sql);
  $sql = file_get_contents("../database/taxonomy.sql");
  $connection->exec($sql);
  $sql = file_get_contents("../database/tools.sql");
  $connection->exec($sql);
  $sql = file_get_contents("../database/loans.sql");
  $connection->exec($sql);
  echo __LINE__ . "Successfully created tables and inserted base data.<br>";

// now load test data unless it's in production:
  switch ($dbname) {
    case "toolpool":
      // do nothing in production!
      break;
    case "toolpool_dev":
    case "toolpool_test":
//      runsqlfile("../database/testdata.sql");
      echo "Successfully inserted test data.<br>";
      break;
    default:
      die('Cannot insert test data into unknown environment!<br>');
  }

  echo "Now <a href='../index.php'>go to the homepage</a>.";
} catch(PDOException $error) {
    echo /* $sql . "<br>" . */ $error->getMessage() . " Try visiting <a href='../index.php'>the homepage</a>.";
}
