<?php
require "../common/common.php";
require "../common/header.php";
?>

<h2>Members || <a href="new.php">add new</a></h2>

<?php
$success = null;

if (isset($_POST["submit"])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $timestamp = date("Y-m-d H:i:s");
    $id = $_POST["submit"];
    $sql = "UPDATE users 
			SET deleted = '$timestamp'
            WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $success = "Successfully deleted the user.";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $sql = "SELECT * FROM users WHERE deleted = '0000-00-00 00:00:00'";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>

<?php if ($success) echo $success; ?>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <table>
    <thead>
      <tr>
          <th>Action</th>
          <th>User name</th>
          <th>Email</th>
          <th>First name</th>
          <th>Last name</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
          <td><a href="edit.php?id=<?php echo escape($row["id"]); ?>">Edit</a>&nbsp;<button class="submit" type="submit" name="submit" value="<?php echo escape($row["id"]); ?>">Delete!</button></td>
          <td><?php echo escape($row["username"]); ?></td>
          <td><?php echo escape($row["email"]); ?></td>
          <td><?php echo escape($row["firstname"]); ?></td>
          <td><?php echo escape($row["lastname"]); ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</form>

<?php require "../common/footer.php"; ?>
