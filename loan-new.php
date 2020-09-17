<?php
require "config/config.php";
require "common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
	$timestamp = date("Y-m-d H:i:s");
    
    $new_loan = array(
	  "created"     => $timestamp,
	  "lastupdated" => '0000-00-00 00:00:00',
	  "deleted"     => '0000-00-00 00:00:00',
      "active"      => $_POST['active'],
      "tool"        => $_POST['tool'],
      "owner"       => $_POST['owner'],
      "loanedto"    => $_POST['loanedto'],
      "agreedstart" => $_POST['agreedstart'],
      "agreedend"   => $_POST['agreedend'],
      "actualstart" => $_POST['actualstart'],
      "actualend"   => $_POST['actualend']
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "loans",
      implode(", ", array_keys($new_loan)),
      ":" . implode(", :", array_keys($new_loan))
    );
    $statement = $connection->prepare($sql);
    $statement->execute($new_loan);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote>Successfully added a loan to the <a href="loan-list.php">loans list</a>.</blockquote>
  <?php endif; ?>

  <h2>Add a loan</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="id">id</label><input type="text" name="id" id="id">
    <label for="created">created</label><input type="text" name="created" id="created">
    <label for="lastupdated">lastupdated</label><input type="text" name="lastupdated" id="lastupdated">
    <label for="deleted">deleted</label><input type="text" name="deleted" id="deleted">
    <label for="active">active</label><input type="text" name="active" id="active">
    <label for="tool">tool</label><input type="text" name="tool" id="tool">
    <label for="owner">owner</label><input type="text" name="owner" id="owner">
    <label for="loanedto">loanedto</label><input type="text" name="loanedto" id="loanedto">
    <label for="agreedstart">agreedstart</label><input type="text" name="agreedstart" id="agreedstart">
    <label for="agreedend">agreedend</label><input type="text" name="agreedend" id="agreedend">
    <label for="actualstart">actualstart</label><input type="text" name="actualstart" id="actualstart">
    <label for="actualend">actualend</label><input type="text" name="actualend" id="actualend">
    <input type="submit" name="submit" value="Submit">
  </form>

<?php require "templates/footer.php"; ?>
