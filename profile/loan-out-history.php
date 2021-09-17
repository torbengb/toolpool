<?php
require "../common/common.php";
require "../common/header.php";

// Action on LOAD:
try {
  $userid = $_SESSION['currentuserid'];
  $statement = $connection->prepare("
        SELECT l.*, t.toolname, u1.username AS username1, u2.username AS username2 FROM loans l
		JOIN tools t ON l.tool = t.id
		JOIN users u1 ON l.owner = u1.id
		JOIN users u2 ON l.loanedto = u2.id
		WHERE ( l.deleted = '0000-00-00 00:00:00' OR l.deleted IS NULL )
        AND l.active IS NULL
        AND l.owner = :userid
		ORDER BY l.active DESC, l.created DESC -- l.active DESC, t.toolname
    ");
  $statement->bindValue('userid', $userid);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>

<h2><a href="index.php"><?php echo escape($_SESSION['currentusername']); ?></a> || <a href="loan-out.php">current lending</a> || past lending</h2>

<?php if (isset($_POST['create']) && $statement) : ?>
  <blockquote class="success">Successfully loaned the tool!</blockquote>
<?php endif; ?>

<?php if (isset($_POST['update']) && $statement) : ?>
  <blockquote class="success">Successfully updated the loan of the <b><?php echo escape($_POST['toolname']); ?></b>.</blockquote>
<?php endif; ?>

<?php if (isset($_POST['delete']) && $statement) : ?>
  <blockquote class="success">Successfully deleted the loan.</blockquote>
<?php endif; ?>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <table>
    <thead>
    <tr>
      <th>Action</th>
      <th>Tool</th>
      <th>Status</th>
      <th>Loaned to</th>
      <th>Created</th>
      <th>Agreed start</th>
      <th>Agreed end</th>
      <th>Actual start</th>
      <th>Actual end</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
        <td><a href="/loans/edit.php?id=<?php echo escape($row["id"]); ?>">Edit</a>&nbsp;
          <button class="button submit" type="submit" name="delete" value="<?php echo escape($row["id"]); ?>">Delete!</button></td>
        <td><?php echo escape($row["toolname"]); ?></td>
        <td><?php echo escape($row["active"]); ?></td>
        <td><a href="/users/view.php?id=<?php echo escape($row["loanedto"]); ?>"><?php echo escape($row["username2"]); ?></a></td>
        <td><?php echo escape($row["created"]); ?></td>
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
