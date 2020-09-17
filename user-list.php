<?php
require "config/config.php";
require "common.php";

$success = null;

if (isset($_POST["submit"])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);
	
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
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM users WHERE deleted = '0000-00-00 00:00:00'";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>
        
<h2>Manage users</h2>

<?php if ($success) echo $success; ?>

<div><a href="user-new.php">Add new user</a></div>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <table>
    <thead>
      <tr>
          <th>Action</th>
          <th>ID</th>
          <th>User name</th>
          <th>Email</th>
          <th>First name</th>
          <th>Last name</th>
          <th>Phone</th>
          <th>Country</th>
          <th>Region</th>
          <th>City</th>
          <th>Postal code</th>
          <th>Street</th>
          <th>House number</th>
          <th>Private notes</th>
          <th>Public notes</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
          <td><a href="user-edit.php?id=<?php echo escape($row["id"]); ?>">Edit</a>&nbsp;<button type="submit" name="submit" value="<?php echo escape($row["id"]); ?>">Delete!</button></td>
          <td><?php echo escape($row["id"]); ?></td>
          <td><?php echo escape($row["username"]); ?></td>
          <td><?php echo escape($row["email"]); ?></td>
          <td><?php echo escape($row["firstname"]); ?></td>
          <td><?php echo escape($row["lastname"]); ?></td>
          <td><?php echo escape($row["phone"]); ?></td>
          <td><?php echo escape($row["addr_country"]); ?></td>
          <td><?php echo escape($row["addr_region"]); ?></td>
          <td><?php echo escape($row["addr_city"]); ?></td>
          <td><?php echo escape($row["addr_zip"]); ?></td>
          <td><?php echo escape($row["addr_street"]); ?></td>
          <td><?php echo escape($row["addr_number"]); ?></td>
          <td><?php echo escape($row["privatenotes"]); ?></td>
          <td><?php echo escape($row["publicnotes"]); ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>