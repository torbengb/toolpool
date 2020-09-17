<?php
require "config/config.php";
require "common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
	$timestamp = date("Y-m-d H:i:s");
    
    $new_tool = array(
	  "created" => $timestamp,
      "owner" => $_POST['owner'],
      "offered" => $_POST['offered'],
      "toolname" => $_POST['toolname'],
      "brand" => $_POST['brand'],
      "model" => $_POST['model'],
      "dimensions" => $_POST['dimensions'],
      "weight" => $_POST['weight'],
      "privatenotes" => $_POST['privatenotes'],
      "publicnotes" => $_POST['publicnotes'],
      "taxonomy1" => $_POST['taxonomy1'],
      "taxonomy2" => $_POST['taxonomy2'],
      "taxonomy3" => $_POST['taxonomy3'],
      "taxonomy4" => $_POST['taxonomy4'],
      "taxonomy5" => $_POST['taxonomy5'],
      "electrical230v" => $_POST['electrical230v'],
      "electrical400v" => $_POST['electrical400v'],
      "hydraulic" => $_POST['hydraulic'],
      "pneumatic" => $_POST['pneumatic']
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "tools",
      implode(", ", array_keys($new_tool)),
      ":" . implode(", :", array_keys($new_tool))
    );
    
    $statement = $connection->prepare($sql);
    $statement->execute($new_tool);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote>Successfully added <b><?php echo escape($_POST['toolname']); ?></b>.</blockquote>
  <?php endif; ?>

  <h2>Add a tool</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="owner">owner</label><input type="text" name="owner" id="owner">
    <label for="offered">offered</label><input type="text" name="offered" id="offered">
    <label for="toolname">toolname</label><input type="text" name="toolname" id="toolname">
    <label for="brand">brand</label><input type="text" name="brand" id="brand">
    <label for="model">model</label><input type="text" name="model" id="model">
    <label for="dimensions">dimensions</label><input type="text" name="dimensions" id="dimensions">
    <label for="weight">weight</label><input type="text" name="weight" id="weight">
    <label for="privatenotes">privatenotes</label><input type="text" name="privatenotes" id="privatenotes">
    <label for="publicnotes">publicnotes</label><input type="text" name="publicnotes" id="publicnotes">
    <label for="taxonomy1">taxonomy1</label><input type="text" name="taxonomy1" id="taxonomy1">
    <label for="taxonomy2">taxonomy2</label><input type="text" name="taxonomy2" id="taxonomy2">
    <label for="taxonomy3">taxonomy3</label><input type="text" name="taxonomy3" id="taxonomy3">
    <label for="taxonomy4">taxonomy4</label><input type="text" name="taxonomy4" id="taxonomy4">
    <label for="taxonomy5">taxonomy5</label><input type="text" name="taxonomy5" id="taxonomy5">
    <label for="electrical230v">electrical230v</label><input type="checkbox" name="electrical230v" id="electrical230v" value=1>
    <label for="electrical400v">electrical400v</label><input type="checkbox" name="electrical400v" id="electrical400v" value=1>
    <label for="hydraulic">hydraulic</label><input type="checkbox" name="hydraulic" id="hydraulic" value=1>
    <label for="pneumatic">pneumatic</label><input type="checkbox" name="pneumatic" id="pneumatic" value=1>
    <input type="submit" name="submit" value="Submit">
  </form>

<?php require "templates/footer.php"; ?>

<!--
owner
offered
loanedto
toolname
brand
model
dimensions
weight
privatenotes
publicnotes
taxonomy1
taxonomy2
taxonomy3
taxonomy4
taxonomy5
electrical230v
electrical400v
hydraulic
pneumatic
-->
