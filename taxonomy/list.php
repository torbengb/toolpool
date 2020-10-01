<?php
require "../common/common.php";
require "../common/header.php";

$success = null;

if (isset($_POST["submit"])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);
	
	$timestamp = date("Y-m-d H:i:s");
  
    $id = $_POST["submit"];
    $tax = "UPDATE taxonomy 
			SET deleted = '$timestamp'
            WHERE id = :id";

    $statement = $connection->prepare($tax);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $success = "Successfully deleted the taxonomy.";
  } catch(PDOException $error) {
    echo $tax . "<br>" . $error->getMessage();
  }
}

try {
  $sql = "SELECT t1.*, t2.name as parentname
    FROM taxonomy t1 
    LEFT OUTER JOIN taxonomy t2 ON t1.parent = t2.id
    WHERE t1.deleted = '0000-00-00 00:00:00'
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

<?php if ($success) echo $success; ?>

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
          <td><a href="edit.php?id=<?php echo escape($row["id"]); ?>" class="submit">Edit</a>&nbsp;<button class="submit" type="submit" name="submit" value="<?php echo escape($row["id"]); ?>">Delete!</button></td>
          <td><?php echo escape($row["name"]); ?></td>
          <td><?php echo escape($row["parentname"]); ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</form>

<?php require "../common/footer.php"; ?>
