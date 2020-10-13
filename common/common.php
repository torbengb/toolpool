<?php
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

// connect to the database:
require "dbconfig.php";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
$connection = new PDO($dsn, $username, $password, $options);
$sql = "USE " . $dbname;
$connection->exec($sql);

// common functions:
function escape($html) {
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

function showMessage($line = 0 , $file = "not specified" , $message = "") {
  // usage: showMessage( __LINE__ , __FILE__ , "optional hint message" )
  //    or: showMessage( __LINE__ , __FILE__ )
  echo "An error occurred at line " . $line . " in file " . $file . "!" .
      ( $message
          ? "<br>Additional information:<br>" . $message
          : "<br>No additional details were provided. Sorry about that."
      );
}

