<?php

try {
// first create database:
  /* INSTALLER CANNOT CREATE DATABASE on DreamHost!! (and neither can a remote SQL client!)
   * The database MUST exist before the installer is run!
   * The installer can do everything after that.
  $sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;
  $connection->exec($sql);
   */

  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // connect to the database:
  require dirname(__DIR__) . '/config/dbconfig.php';
  $dsn        = "mysql:host=$host;dbname=$dbname";
  $options    = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
  $connection = new PDO($dsn, $username, $password, $options);
  $sql        = "USE " . $dbname;
	echo "Using environment '" . $dbname . "' . . .<br>";
	$connection->exec($sql);
  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// and then create tables:
	echo "Creating tables and inserted base data . . .<br>";
	$sql = file_get_contents("../database/countries.sql");
	$connection->exec($sql);
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
	echo "Done.<br>";

	// now load test data unless it's in production:
	switch ($dbname) {
    case "toolpool_local":
		case "toolpool_dev":
		case "toolpool_test":
		echo "Inserting test data . . .<br>";
		$sql = file_get_contents("../database/testdata.sql");
		$connection->exec($sql);
		echo "Done.<br>";
		break;
    case "toolpool":
	    // do nothing in production!
	    echo "No testdata added to production.<br>";
	    break;
		default:
			echo "Cannot insert test data into unknown environment '" . $dbname . "'!<br>";
			die("Error '" . __LINE__ . "'!<br>");
	}

  echo "Installation finished. Now <a href='../index.php'>go to the homepage</a>.";
} catch(PDOException $error) {
    echo /* $sql . "<br>" . */ $error->getMessage() . "<br>Installation failed! Try visiting <a href='../index.php'>the homepage</a>.";
}
