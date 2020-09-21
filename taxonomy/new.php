<?php
require "../common/common.php";
require "../common/header.php";
?>

<h2>Add new taxonomy</h2>

<?php
if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $timestamp = date("Y-m-d H:i:s");
    
    $new_tax = array(
      "created"      => $timestamp,
      "name"         => $_POST['name'],
      "parent"       => $_POST['parent']
    );
    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "taxonomy",
      implode(", ", array_keys($new_tax)),
      ":" . implode(", :", array_keys($new_tax))
    );
    $statement = $connection->prepare($sql);
    $statement->execute($new_tax);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

try {
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

<?php if (isset($_POST['submit']) && $statement) : ?>
  <blockquote>Successfully added <b><?php echo escape($_POST['name']); ?></b> to the <a href="list.php">taxonomy list</a>.</blockquote>
<?php endif; ?>

<form method="post"><input class="submit" type="submit" name="submit" value="Submit">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">

  <label class="label" for="name">Name<input type="text" name="name" id="name"></label>
  <label class="label" for="parent">Parent
    <select name="parent" id="parent">
      <?php foreach ($parents as $row) : ?>
        <option value="<?php echo escape($row["id"]); ?>"><?php echo escape($row["name"]); ?></option>
      <?php endforeach; ?>
    </select>
  </label>

  <input class="submit" type="submit" name="submit" value="Submit">
</form>

<?php require "../common/footer.php"; ?>
