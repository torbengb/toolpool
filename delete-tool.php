<?php
require "config/config.php";
require "common.php";

$success = null;

if (isset($_POST["submit"])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);
  
    $id = $_POST["submit"];
    $sql = "UPDATE tools 
			SET deleted = 'CURRENT_TIMESTAMP()' 
			WHERE id = :id";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $success = "Successfully deleted the tool.";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM tools";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>
        
<h2>Delete tools</h2>

<?php if ($success) echo $success; ?>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <table>
    <thead>
      <tr>
        <th>Action</th>
          <th>ID</th>
          <th>Created</th>
          <th>Last updated</th>
          <th>Deleted</th>
          <th>Owner</th>
          <th>Offered</th>
          <th>Toolname</th>
          <th>Brand</th>
          <th>Model</th>
          <th>Dimensions</th>
          <th>Weight</th>
          <th>Privatenotes</th>
          <th>Publicnotes</th>
          <th>Taxonomy1</th>
          <th>Taxonomy2</th>
          <th>Taxonomy3</th>
          <th>Taxonomy4</th>
          <th>Taxonomy5</th>
          <th>Electrical230v</th>
          <th>Electrical400v</th>
          <th>Hydraulic</th>
          <th>Pneumatic</th>
          <th>Created</th>
          <th>Last updated</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
        <td><button type="submit" name="submit" value="<?php echo escape($row["id"]); ?>">Delete!</button></td>
          <td><?php echo escape($row["id"]); ?></td>
          <td><?php echo escape($row["created"]); ?> </td>
          <td><?php echo escape($row["lastupdated"]); ?> </td>
          <td><?php echo escape($row["deleted"]); ?> </td>
          <td><?php echo escape($row["owner"]); ?></td>
          <td><?php echo escape($row["offered"]); ?></td>
          <td><?php echo escape($row["toolname"]); ?></td>
          <td><?php echo escape($row["brand"]); ?></td>
          <td><?php echo escape($row["model"]); ?></td>
          <td><?php echo escape($row["dimensions"]); ?></td>
          <td><?php echo escape($row["weight"]); ?></td>
          <td><?php echo escape($row["privatenotes"]); ?></td>
          <td><?php echo escape($row["publicnotes"]); ?></td>
          <td><?php echo escape($row["taxonomy1"]); ?></td>
          <td><?php echo escape($row["taxonomy2"]); ?></td>
          <td><?php echo escape($row["taxonomy3"]); ?></td>
          <td><?php echo escape($row["taxonomy4"]); ?></td>
          <td><?php echo escape($row["taxonomy5"]); ?></td>
          <td><?php echo escape($row["electrical230v"]); ?></td>
          <td><?php echo escape($row["electrical400v"]); ?></td>
          <td><?php echo escape($row["hydraulic"]); ?></td>
          <td><?php echo escape($row["pneumatic"]); ?></td>
          <td><?php echo escape($row["creation"]); ?></td>
          <td><?php echo escape($row["lastupdated"]); ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>