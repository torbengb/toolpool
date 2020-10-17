<?php
require "../common/common.php";
require "../common/header.php";

if (isset($_POST["delete"])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try { // Action on SUBMIT:
    $timestamp = date("Y-m-d H:i:s");
    $id = $_POST["delete"];
    $statement = $connection->prepare("UPDATE users  SET deleted = '$timestamp' WHERE id = :id");
    $statement->bindValue(':id', $id);
    $statement->execute();
  } catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
}

try { // Action on LOAD:
  $statement = $connection->prepare("
        SELECT u.*, r.name AS regionname
        FROM users u
        LEFT JOIN regions r ON r.code = u.addr_region -- LEFT includes users without a region.
        WHERE ( u.deleted = '0000-00-00 00:00:00' OR u.deleted IS NULL )
        ");
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
?>

<h2>Members || <a href="new.php">add new</a></h2>

<?php if (isset($_POST['create']) && $statement) : ?>
    <blockquote class="success">Successfully registered your username <b><?php echo escape($_POST['username']); ?></b>!</blockquote>
<?php endif; ?>

<?php if (isset($_POST['update']) && $statement) : ?>
    <blockquote class="success">Successfully updated <b><?php echo escape($_POST['username']); ?></b>'s user profile.</blockquote>
<?php endif; ?>

<?php if (isset($_POST['delete']) && $statement) : ?>
    <blockquote class="success">Successfully deleted the user profile.</blockquote>
<?php endif; ?>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <table>
    <thead>
      <tr>
          <th>User name</th>
          <th>Country</th>
          <th>Region</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
          <td><a href="view.php?id=<?php echo escape($row["id"]); ?>"><?php echo escape($row["username"]); ?></a></td>
          <td><?php echo ( escape($row["addr_country"]) == '0' ? NULL : escape($row["addr_country"]) . "&nbsp;&nbsp;&nbsp;" . escape($row["countryname"]) ) ; ?></td>
          <td><?php echo ( escape($row["addr_region"]) == '0' ? NULL : escape($row["addr_region"]) . "&nbsp;&nbsp;&nbsp;" . escape($row["regionname"]) ) ; ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</form>

<?php require "../common/footer.php"; ?>
