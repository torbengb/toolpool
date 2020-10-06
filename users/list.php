<?php
require "../common/common.php";
require "../common/header.php";

$success = null;

if (isset($_POST["submit"])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try { // Action on SUBMIT:
    $timestamp = date("Y-m-d H:i:s");
    $id = $_POST["submit"];
    $sql = "UPDATE users 
			SET deleted = '$timestamp'
            WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $success = "Successfully deleted the user.";
  } catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
}

try { // Action on LOAD:
  $sql = "SELECT u.*, r.name AS regionname
    FROM users u
    LEFT JOIN regions r ON r.code = u.addr_region -- LEFT includes users without a region.
    WHERE u.deleted = '0000-00-00 00:00:00'
      OR  u.deleted IS NULL ";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
?>

<h2>Members || <a href="new.php">add new</a></h2>

<?php if ($success) echo $success; ?>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <table>
    <thead>
      <tr>
          <th>Action</th>
          <th>User name</th>
          <th>Region</th>
          <th>Email</th>
          <th>First name</th>
          <th>Last name</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
          <td><a href="edit.php?id=<?php echo escape($row["id"]); ?>">Edit</a>&nbsp;<button class=" button submit" type="submit" name="submit" value="<?php echo escape($row["id"]); ?>">Delete!</button></td>
          <td><?php echo escape($row["username"]); ?></td>
          <td><?php echo ( escape($row["addr_region"]) == NULL
          ? NULL 
          : escape($row["addr_region"]) . "&nbsp;&nbsp;&nbsp;" . escape($row["regionname"]) ) ; ?></td>
          <td><?php echo escape($row["email"]); ?></td>
          <td><?php echo escape($row["firstname"]); ?></td>
          <td><?php echo escape($row["lastname"]); ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</form>

<?php require "../common/footer.php"; ?>
