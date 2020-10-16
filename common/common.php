<?php
session_start();
if (empty($_SESSION['csrf'])) {
  if (function_exists('random_bytes')) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
  } elseif (function_exists('mcrypt_create_iv')) {
    $_SESSION['csrf'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
  } else {
    $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
  }
}
// connect to the database:
require "dbconfig.php";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
$connection = new PDO($dsn, $username, $password, $options);
$sql        = "USE " . $dbname;
$connection->exec($sql);
// common functions:
function escape($html)
{
  return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

function showMessage($line = 0, $file = "not specified", $message = "")
{
  // usage: showMessage( __LINE__ , __FILE__ , "optional hint message" )
  //    or: showMessage( __LINE__ , __FILE__ )
  echo "An error occurred at line " . $line . " in file " . $file . "!" .
      ($message ? "<br>Additional information:<br>" . $message : "<br>No additional details were provided. Sorry about that.");
}

if (isset($_POST["login"])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf']))
    die();
  $currentuserid = $_POST["user"];
  $statement = $connection->prepare("
        SELECT id, username
        FROM users
        WHERE id = :id
        ");
  $statement->bindValue(':id', $currentuserid);
  $statement->execute();
  $result = $statement->fetch(PDO::FETCH_ASSOC);
  var_dump($result);echo "<br>";
  //$currentuserid  =$result[0][0];
  echo __LINE__."/".$result[0].".<br>";
  echo __LINE__."/".$result[1].".<br>";
  echo __LINE__."/".$result[0][2].".<br>";
  echo __LINE__."/".$result[1][0].".<br>";
  echo __LINE__."/".$result[1][1].".<br>";
  echo __LINE__."/".$result[1][2].".<br>";
  //$currentusername=$result[0][1];
  //echo __LINE__."/".$currentuserid."/".$currentusername.".<br>";

//  $_SESSION["currentusername"] = $_POST["username"];
  //echo $_SESSION["currentuserid"]."/".$_SESSION["currentusername"];

//*/
}
echo __LINE__."/".$_SESSION["currentuser"]."/".$_SESSION["currentuserid"]."/".$_SESSION["currentusername"].".<br>";

$statement = $connection->prepare("
        SELECT id, username FROM users
        WHERE ( deleted = '0000-00-00 00:00:00' OR deleted IS NULL )
        ORDER BY username
        ");
$statement->execute();
$users = $statement->fetchAll();
//var_dump($users);

