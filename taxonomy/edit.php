<?php
require "../common/common.php";
require "../common/header.php";

if (isset($_GET['id'])) { // Action on LOAD:
  try { // load the record
    $id = $_GET['id'];
    $sql = "SELECT * FROM taxonomy WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $tax = $statement->fetch(PDO::FETCH_ASSOC);
    
  try { // load foreign tables:
    $sql = "SELECT name, id, parent FROM taxonomy
        WHERE deleted = '0000-00-00 00:00:00'
        ORDER BY name";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $parents = $statement->fetchAll();
    } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
  try { // load foreign tables:
    $sql = "SELECT name, id, parent FROM taxonomy
        WHERE deleted = '0000-00-00 00:00:00'
        ORDER BY name";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $parents = $statement->fetchAll();
    } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
  } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
} else {
    echo "Something went wrong!";
    exit;
}

?>

<h2>Edit a taxonomy</h2>

<?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote class="success">Successfully updated <b><?php echo escape($_POST['name']); ?></b> in the <a href="list.php">taxonomy list</a>.</blockquote>
<?php endif; ?>

<form method="post" action="list.php">
  <button class="button submit" type="submit" name="update" value="update">Save</button>
  <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">
  <input type="hidden" name="id" value="<?php echo escape($tax['id']); ?>">
  
  <label class="label" for="name"><span class="labeltext">Name</span><input class="input" type="text" name="name" id="name" value="<?php echo escape($tax["name"]); ?>"></label>
  <label class="label" for="parent"><span class="labeltext">Parent</span>
    <select class="input" name="parent" id="parent">
      <?php foreach ($parents as $row) : ?>
        <option 
          name="parent" 
          id="parent"
          value="<?php echo escape($row["id"]); ?>" 
            <?php echo ( escape($row["id"]) == escape($tax["parent"]) ? "selected='selected'" : NULL ) ?>
        ><?php echo escape($row["name"]) ; ?></option>
      <?php endforeach; ?>
    </select>
  </label>

  <button class="button submit" type="submit" name="update" value="update">Save</button>
</form>

<?php require "../common/footer.php"; ?>
