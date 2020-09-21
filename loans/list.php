<?php
require "../common/common.php";
require "../common/header.php";
?>

<h2>Loans || <a href="new.php">add new</a></h2>

<?php
$success = null;

if (isset($_POST["submit"])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);
	
	$timestamp = date("Y-m-d H:i:s");
  
    $id = $_POST["submit"];
    $sql = "UPDATE loans 
			SET deleted = '$timestamp'
            WHERE id = :id";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $success = "Successfully deleted the loan.";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $sql = "SELECT l.*, t.toolname, u1.username AS username1, u2.username AS username2 FROM loans l
		  JOIN tools t ON l.tool = t.id
		  JOIN users u1 ON l.owner = u1.id
		  JOIN users u2 ON l.loanedto = u2.id
		  WHERE l.deleted = '0000-00-00 00:00:00'";

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
          <th>Active</th>
          <th>Tool</th>
          <th>Owner</th>
          <th>Loaned to</th>
          <th>Agreed start</th>
          <th>Agreed end</th>
          <th>Actual start</th>
          <th>Actual end</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
          <td><a href="edit.php?id=<?php echo escape($row["id"]); ?>">Edit</a>&nbsp;<button class="submit" type="submit" name="submit" value="<?php echo escape($row["id"]); ?>">Delete!</button></td>
          <td><?php echo escape($row["active"]); ?></td>
          <td><?php echo escape($row["toolname"]); ?></td>
          <td><?php echo escape($row["username1"]); ?></td>
          <td><?php echo escape($row["username2"]); ?></td>
          <td><?php echo escape($row["agreedstart"]); ?></td>
          <td><?php echo escape($row["agreedend"]); ?></td>
          <td><?php echo escape($row["actualstart"]); ?></td>
          <td><?php echo escape($row["actualend"]); ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</form>

<?php require "../common/footer.php"; ?>

<!--
id
created
lastupdated
deleted
active
owner
loanedto
agreedstart
agreedend
actualstart
actualend
-->