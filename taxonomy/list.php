<?php
require "../common/common.php";
require "../common/header.php";

if (isset($_POST['create'])) { // Action on SUBMIT:
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

if (isset($_POST['update'])) { // Action on SUBMIT:
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  try { // update the record:
    $timestamp = date("Y-m-d H:i:s");
    $record =[
        "id"            => $_POST['id'],
        "modified" => $timestamp,
        "name"          => $_POST['name'],
        "parent"        => $_POST['parent']
    ];
    $sql = "UPDATE taxonomy 
            SET modified = :modified,
              name = :name,
              parent = :parent
            WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->execute($record);
  } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
}

if (isset($_POST["delete"])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  try {
	$timestamp = date("Y-m-d H:i:s");
    $id = $_POST["delete"];
    $tax = "UPDATE taxonomy 
			SET deleted = '$timestamp'
            WHERE id = :id";
    $statement = $connection->prepare($tax);
    $statement->bindValue(':id', $id);
    $statement->execute();
  } catch(PDOException $error) {
    echo $tax . "<br>" . $error->getMessage();
  }
}

try {
  $sql = "SELECT t1.*, t2.name as parentname
    FROM taxonomy t1 
    LEFT OUTER JOIN taxonomy t2 ON t1.parent = t2.id
    WHERE ( t1.deleted = '0000-00-00 00:00:00'
        OR  t1.deleted IS NULL )
    AND ( t1.parent = t2.id 
       OR t1.parent = ''
    )
    ORDER BY parentname, name";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>

<h2>Taxonomy || <a href="new.php">add new</a></h2>

<?php if (isset($_POST['create']) && $statement) : ?>
    <blockquote class="success">Successfully added <b><?php echo escape($_POST['name']); ?></b>!</blockquote>
<?php endif; ?>

<?php if (isset($_POST['update']) && $statement) : ?>
    <blockquote class="success">Successfully updated <b><?php echo escape($_POST['name']); ?></b>.</blockquote>
<?php endif; ?>

<?php if (isset($_POST['delete']) && $statement) : ?>
    <blockquote class="success">Successfully deleted the taxonomy.</blockquote>
<?php endif; ?>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <table>
    <thead>
      <tr>
          <th>Action</th>
          <th>Name</th>
          <th>Parent</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
          <td><a href="edit.php?id=<?php echo escape($row["id"]); ?>" class="submit">Edit</a>&nbsp;<button class=" button submit" type="submit" name="delete" value="<?php echo escape($row["id"]); ?>">Delete!</button></td>
          <td><?php echo escape($row["name"]); ?></td>
          <td><?php echo escape($row["parentname"]); ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</form>

<?php require "../common/footer.php"; ?>
