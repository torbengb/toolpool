<?php
require "../common/common.php";
require "../common/header.php";

// Action on LOAD:
try { // load the record
  $connection = new PDO($dsn, $username, $password, $options);
  $sql = "USE " . $dbname;
  $connection->exec($sql);
  $userid = $_SESSION['currentuserid'];
  $statement = $connection->prepare("
        SELECT l.*, t.toolname, u1.username AS username1, u2.username AS username2 FROM loans l
		JOIN tools t ON l.tool = t.id
		JOIN users u1 ON l.owner = u1.id
		JOIN users u2 ON l.loanedto = u2.id
		WHERE ( l.deleted = '0000-00-00 00:00:00' OR l.deleted IS NULL )
        AND l.active = 0
        AND l.loanedto = :userid
		ORDER BY l.created DESC -- l.active DESC, t.toolname
    ");
  $statement->bindValue('userid', $userid);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>

<h2><a href="index.php"><?php echo escape($_SESSION['currentusername']); ?></a> || <a href="loan-in.php">current loans</a> || past loans</h2>

  <table>
    <thead>
    <tr>
      <th>Action</th>
      <th>Tool</th>
      <th>Owner</th>
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
        <td>[message to owner]</td>
        <td><?php echo escape($row["toolname"]); ?></td>
        <td><a href="/users/view.php?id=<?php echo escape($row["owner"]); ?>"><?php echo escape($row["username1"]); ?></a></td>
        <td><?php echo escape($row["created"]); ?></td>
        <td><?php echo escape($row["agreedstart"]); ?></td>
        <td><?php echo escape($row["agreedend"]); ?></td>
        <td><?php echo escape($row["actualstart"]); ?></td>
        <td><?php echo escape($row["actualend"]); ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>

<?php require "../common/footer.php"; ?>
