<?php
require "config/config.php";
require "common.php";

$success = null;

if (isset($_POST["submit"])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);
  
    $id = $_POST["submit"];

    $sql = "UPDATE users 
            SET deleted = 'CURRENT_TIMESTAMP()'
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

  $sql = "SELECT * FROM users";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>
        
<h2>Delete users</h2>

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
          <td><button type="submit" name="submit" value="<?php echo escape($row["id"]); ?>">Delete!</button></td>
          <td><?php echo escape($row["id"]); ?></td>
          <td><?php echo escape($row["creation"]); ?> </td>
          <td><?php echo escape($row["lastupdated"]); ?> </td>
          <td><?php echo escape($row["deleted"]); ?> </td>
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