<?php
require "../common/common.php";
require "../common/header.php";

if (isset($_POST['create'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  { // create the record:
    $timestamp = date("Y-m-d H:i:s");
    $record = array(
        "created" => $timestamp,
        "active"      => $_POST['active'],
        "tool"        => $_POST['tool'],
        "owner"       => $_POST['owner'],
        "loanedto"    => $_POST['loanedto'],
        "agreedstart" => $_POST['agreedstart'],
        "agreedend"   => $_POST['agreedend'],
        "actualstart" => $_POST['actualstart'],
        "actualend"   => $_POST['actualend']
    );
    $sql = sprintf(
        "INSERT INTO %s (%s) values (%s)",
        "loans",
        implode(", ", array_keys($record)),
        ":" . implode(", :", array_keys($record))
    );
    $statement = $connection->prepare($sql);
    $statement->execute($record);
  } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
}

if (isset($_POST['update'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  try { // update the record:
    $timestamp = date("Y-m-d H:i:s");
    $record =[
        "id" => $_POST['id'],
        "modified" => $timestamp,
        "active" => $_POST['active'],
        "tool" => $_POST['tool'],
        "owner" => $_POST['owner'],
        "loanedto" => $_POST['loanedto'],
        "agreedstart" => $_POST['agreedstart'],
        "agreedend" => $_POST['agreedend'],
        "actualstart" => $_POST['actualstart'],
        "actualend" => $_POST['actualend'],
    ];
    $statement = $connection->prepare("
        UPDATE loans 
            SET modified = :modified,
              active = :active,
              tool = :tool,
              owner = :owner,
              loanedto = :loanedto,
              agreedstart = :agreedstart,
              agreedend = :agreedend,
              actualstart = :actualstart,
              actualend = :actualend
            WHERE id = :id
        ");
    $statement->execute($record);
  } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
}

if (isset($_POST['delete'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  try {
	$timestamp = date("Y-m-d H:i:s");
    $id = $_POST["delete"];
    $statement = $connection->prepare("
        UPDATE loans 
		SET deleted = '$timestamp'
        WHERE id = :id
        ");
    $statement->bindValue(':id', $id);
    $statement->execute();
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

// Action on LOAD:
try { // load the record
$connection = new PDO($dsn, $username, $password, $options);
$sql = "USE " . $dbname;
$connection->exec($sql);
  $statement = $connection->prepare("
        SELECT l.*, t.toolname, u1.username AS username1, u2.username AS username2 FROM loans l
		JOIN tools t ON l.tool = t.id
		JOIN users u1 ON l.owner = u1.id
		JOIN users u2 ON l.loanedto = u2.id
		WHERE ( l.deleted = '0000-00-00 00:00:00' OR l.deleted IS NULL )
		ORDER BY l.active DESC, t.toolname
    ");
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>

<h2>Loans || <a href="new.php">add new</a></h2>

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
          <td><a href="edit.php?id=<?php echo escape($row["id"]); ?>">Edit</a>&nbsp;
              <button class="button submit" type="submit" name="delete" value="<?php echo escape($row["id"]); ?>">Delete!</button></td>
          <td><?php echo ( escape($row["active"]) ? "active" : "-" ); ?></td>
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
