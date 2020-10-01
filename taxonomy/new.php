<?php
require "../common/common.php";
require "../common/header.php";

if (isset($_POST['submit'])) { // Action on SUBMIT:
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  { // create the record:
    $timestamp = date("Y-m-d H:i:s");
    
    $record = array(
      "created"      => $timestamp,
      "name"         => $_POST['name'],
      "parent"       => $_POST['parent']
    );
    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "taxonomy",
      implode(", ", array_keys($record)),
      ":" . implode(", :", array_keys($record))
    );
    $statement = $connection->prepare($sql);
    $statement->execute($record);
  } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
}

// Action on LOAD:
try { // load foreign tables:
  $sql = "SELECT name, id FROM taxonomy
      WHERE deleted = '0000-00-00 00:00:00'
      ORDER BY name";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $parents = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>

<h2>Add new taxonomy</h2>

<?php if (isset($_POST['submit']) && $statement) : ?>
  <blockquote>Successfully added <b><?php echo escape($_POST['name']); ?></b> to the <a href="list.php">taxonomy list</a>.</blockquote>
<?php endif; ?>

<form method="post"><input class="button submit" type="submit" name="submit" value="Submit">
  <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">

  <label class="label" for="name">Name<input type="text" name="name" id="name"></label>
  <label class="label" for="parent">Parent
    <select class="input" name="parent" id="parent">
      <?php foreach ($parents as $row) : ?>
        <option value="<?php echo escape($row["id"]); ?>"><?php echo escape($row["name"]); ?></option>
      <?php endforeach; ?>
    </select>
  </label>

  <input class="button submit" type="submit" name="submit" value="Submit">
</form>

<?php require "../common/footer.php"; ?>
