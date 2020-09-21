<?php
require "config.php";

session_start();

if (empty($_SESSION['csrf'])) {
	if (function_exists('random_bytes')) {
		$_SESSION['csrf'] = bin2hex(random_bytes(32));
	} else if (function_exists('mcrypt_create_iv')) {
		$_SESSION['csrf'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
	} else {
		$_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
	}
}
// determine which database to use:
$myhost = $_SERVER['HTTP_HOST'];
switch ($myhost) {
  case "localhost":
  case "toolpool-dev.golfbravo.net":
    $dbname = "toolpool_dev";
    break;
  case "toolpool-test.golfbravo.net":
    $dbname = "toolpool_test";
    break;
  case "toolpool.golfbravo.net":
    $dbname = "toolpool";
    break;
  default:
    die('Unable to select database!');
}
// then use that database:
$connection = new PDO($dsn, $username, $password, $options);
$sql = "USE " . $dbname;
$connection->exec($sql);

function escape($html) {
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

