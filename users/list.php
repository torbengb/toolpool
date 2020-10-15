<?php
require "../common/common.php";
require "../common/header.php";

if (isset($_POST['create'])) { // Action on SUBMIT:
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  { // create the record:
    $timestamp = date("Y-m-d H:i:s");
    $record =[
        "created"       => $timestamp,
        "username"      => $_POST['username'],
        "email"         => $_POST['email'],
        "firstname"     => $_POST['firstname'],
        "lastname"      => $_POST['lastname'],
        "phone"         => $_POST['phone'],
        "addr_country"  => $_POST['addr_country'],
        "addr_region"   => $_POST['addr_region'],
        "addr_city"     => $_POST['addr_city'],
        "addr_zip"      => $_POST['addr_zip'],
        "addr_street"   => $_POST['addr_street'],
        "addr_number"   => $_POST['addr_number'],
        "privatenotes"  => $_POST['privatenotes'],
        "publicnotes"   => $_POST['publicnotes']
    ];
    $sql = sprintf(
        "INSERT INTO %s (%s) values (%s)",
        "users",
        implode(", ", array_keys($record)),
        ":" . implode(", :", array_keys($record))
    );
    $statement = $connection->prepare($sql);
    $statement->execute($record);
  } catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
}

if (isset($_POST['update'])) { // Action on SUBMIT:
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try { // update the record:
    $timestamp = date("Y-m-d H:i:s");
    $record =[
        "id"            => $_POST['id'],
        "modified"   => $timestamp,
        "username"      => $_POST['username'],
        "email"         => $_POST['email'],
        "firstname"     => $_POST['firstname'],
        "lastname"      => $_POST['lastname'],
        "phone"         => $_POST['phone'],
        "addr_country"  => $_POST['addr_country'],
        "addr_region"   => $_POST['addr_region'],
        "addr_city"     => $_POST['addr_city'],
        "addr_zip"      => $_POST['addr_zip'],
        "addr_street"   => $_POST['addr_street'],
        "addr_number"   => $_POST['addr_number'],
        "privatenotes"  => $_POST['privatenotes'],
        "publicnotes"   => $_POST['publicnotes']
    ];
    $statement = $connection->prepare("
        UPDATE users 
            SET modified = :modified,
              username = :username,
              email = :email,
              firstname = :firstname,
              lastname = :lastname,
              phone = :phone,
              addr_country = :addr_country,
              addr_region = :addr_region,
              addr_city = :addr_city,
              addr_zip = :addr_zip,
              addr_street = :addr_street,
              addr_number = :addr_number,
              privatenotes = :privatenotes,
              publicnotes = :publicnotes
            WHERE id = :id
        ");
    $statement->execute($record);
  } catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
}

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
          <td><a href="edit.php?id=<?php echo escape($row["id"]); ?>">Edit</a>&nbsp;
              <button class=" button submit" type="submit" name="delete" value="<?php echo escape($row["id"]); ?>">Delete!</button></td>
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
