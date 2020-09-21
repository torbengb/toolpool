<?php
require "../common/common.php";
require "../common/header.php";
?>

<h2>Edit a taxonomy</h2>

<?php
// Action on SUBMIT:
if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $timestamp = date("Y-m-d H:i:s");
    $tax =[
      "id"            => $_POST['id'],
	    "lastupdated"   => $_POST['lastupdated'],
      "name"          => $_POST['name'],
      "parent"        => $_POST['parent']
    ];

    $sql = "UPDATE taxonomy 
            SET id = :id, 
              -- created = :created,
              lastupdated = '$timestamp',
              -- deleted = :deleted,
              name = :name,
              parent = :parent
            WHERE id = :id";
  $statement = $connection->prepare($sql);
  $statement->execute($tax);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

// Action on LOAD:
if (isset($_GET['id'])) {
  try {
    // Load the record:
    $id = $_GET['id'];
    $sql = "SELECT * FROM taxonomy WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $tax = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
  try {
    // Load foreign tables:
    $sql = "SELECT name, id, parent FROM taxonomy
        WHERE deleted = '0000-00-00 00:00:00'
        ORDER BY name";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $parents = $statement->fetchAll();
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}

?>

<?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote>Successfully updated <b><?php echo escape($_POST['name']); ?></b> in the <a href="list.php">taxonomy list</a>.</blockquote>
<?php endif; ?>

<form method="post"><input class="submit" type="submit" name="submit" value="Submit">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  
  <label class="label" for="name">Name<input type="text" name="name" id="name" value="<?php echo escape($tax["name"]); ?>"></label>
  <label class="label" for="parent">Parent
    <select class="input" name="parent" id="parent">
      <?php foreach ($parents as $row) : ?>
        <option 
          name="parent" 
          id="parent"
          value="<?php echo escape($row["id"]); ?>" 
            <?php echo ( escape($tax["parent"]) == escape($row["id"]) ? "selected='selected'" : NULL ) ?>
        ><?php echo escape($row["name"]); ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  
  <input class="submit" type="submit" name="submit" value="Submit">
</form>

<?php require "../common/footer.php"; ?>
