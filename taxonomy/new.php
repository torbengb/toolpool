<?php
require "../common/common.php";
require "../common/header.php";

// Action on LOAD:
try { // load foreign tables:
  $statement = $connection->prepare("
      SELECT name, id FROM taxonomy
      WHERE ( deleted = '0000-00-00 00:00:00' OR deleted IS NULL )
      ORDER BY name
      ");
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

<form method="post" action="list.php">
  <button class="button submit" type="submit" name="create" value="create">Add</button>
  <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">

  <label class="label" for="name">Name<input type="text" name="name" id="name"></label>
  <label class="label" for="parent">Parent
    <select class="input" name="parent" id="parent">
      <?php foreach ($parents as $row) : ?>
        <option value="<?php echo escape($row["id"]); ?>"><?php echo escape($row["name"]); ?></option>
      <?php endforeach; ?>
    </select>
  </label>

  <button class="button submit" type="submit" name="create" value="create">Add</button>
</form>

<?php require "../common/footer.php"; ?>
