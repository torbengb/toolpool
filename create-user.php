<?php
require "config/config.php";
require "common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $new_user = array(
	  "creation"     => 'CURRENT_TIMESTAMP()',
      "username"     => $_POST['username'],
      "email"        => $_POST['email'],
      "firstname"    => $_POST['firstname'],
      "lastname"     => $_POST['lastname'],
      "phone"        => $_POST['phone'],
      "addr_country" => $_POST['addr_country'],
      "addr_region"  => $_POST['addr_region'],
      "addr_city"    => $_POST['addr_city'],
      "addr_zip"     => $_POST['addr_zip'],
      "addr_street"  => $_POST['addr_street'],
      "addr_number"  => $_POST['addr_number'],
      "privatenotes" => $_POST['privatenotes'],
      "publicnotes"  => $_POST['publicnotes']
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "users",
      implode(", ", array_keys($new_user)),
      ":" . implode(", :", array_keys($new_user))
    );
    
    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote>Successfully added user <b><?php echo escape($_POST['username']); ?></>.</blockquote>
  <?php endif; ?>

  <h2>Add a user</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">

    <label for="username">User name</label><input type="text" name="username" id="username">
    <label for="email">Email address</label><input type="text" name="email" id="email">
    <label for="firstname">First name</label><input type="text" name="firstname" id="firstname">
    <label for="lastname">Last name</label><input type="text" name="lastname" id="lastname">
    <label for="phone">Phone number</label><input type="text" name="phone" id="phone">
	<label for="addr_country">Country</label><input type="text" name="addr_country" id="addr_country">
	<label for="addr_region">Region</label><input type="text" name="addr_region" id="addr_region">
	<label for="addr_city">City</label><input type="text" name="addr_city" id="addr_city">
	<label for="addr_zip">ZIP code</label><input type="text" name="addr_zip" id="addr_zip">
	<label for="addr_street">Street name</label><input type="text" name="addr_street" id="addr_street">
	<label for="addr_number">House number</label><input type="text" name="addr_number" id="addr_number">
	<label for="privatenotes">Private notes</label><input type="text" name="privatenotes" id="privatenotes">
	<label for="publicnotes">Public notes</label><input type="text" name="publicnotes" id="publicnotes">

    <input type="submit" name="submit" value="Submit">
  </form>

  <a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
