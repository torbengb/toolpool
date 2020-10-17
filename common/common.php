<?php
session_start();
$_SESSION['debug'] =
    0; // set to 1 for extra debug output; 0 for nothing.
//if ($_SESSION['debug']==1) echo __LINE__ . " in " . __FILE__ ."<br>";
if ($_SESSION['debug']==1) echo "Debug is ON: line ".__LINE__ . " in " . __FILE__ ."<br>";
if (empty($_SESSION['csrf'])) {
  if (function_exists('random_bytes')) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
  } elseif (function_exists('mcrypt_create_iv')) {
    $_SESSION['csrf'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
  } else {
    $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
  }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// connect to the database:
require "dbconfig.php";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
$connection = new PDO($dsn, $username, $password, $options);
$sql        = "USE " . $dbname;
$connection->exec($sql);
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// common functions:
if ($_SESSION['debug']==1) echo __LINE__ . " in " . __FILE__ ."<br>";
function escape($html)
{
  return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

function showMessage($line = 0, $file = "not specified", $message = "")
{
  // usage: showMessage( __LINE__ , __FILE__ , "optional hint message" )
  //    or: showMessage( __LINE__ , __FILE__ )
  echo "An error occurred at line " . $line . " in file " . $file . "!" . ($message ? "<br>Additional information:<br>" . $message : "<br>No additional details were provided. Sorry about that.");
}

$statement = $connection->prepare("
        SELECT id, username FROM users
        WHERE ( deleted = '0000-00-00 00:00:00' OR deleted IS NULL )
        ORDER BY username
        ");
$statement->execute();
$users = $statement->fetchAll();
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// user management
if (isset($_POST["login"])) {
  //if ($_SESSION['debug']) echo __LINE__ . " in " . __FILE__ . "<br>";
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf']))
    if ($_SESSION['debug']==1) {
      echo __LINE__ . " in " . __FILE__ . "<br>";
      //die();
    }
  $currentuserid = $_POST["user"];
  $statement     = $connection->prepare("
        SELECT id, username
        FROM users
        WHERE id = :id
        AND ( deleted = '0000-00-00 00:00:00' OR deleted IS NULL )
        ");
  $statement->bindValue(':id', $currentuserid);
  $statement->execute();
  $result                      = $statement->fetch(PDO::FETCH_ASSOC);
  $_SESSION["currentuserid"]   = $result['id'];
  $_SESSION["currentusername"] = $result['username'];
  unset($_POST["login"]);
}
if (isset($_POST["logout"])) {
  //if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  // remove all session variables
  session_unset();
  // destroy the session
  session_destroy();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
