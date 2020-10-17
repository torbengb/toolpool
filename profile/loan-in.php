<?php
require "../common/common.php";
require "../common/header.php";

if (isset($_POST['loan'])) { // Action on SUBMIT:
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  try {
    // first collect the necessary data:
    $id = $_POST["loan"];
    $statement = $connection->prepare("
        SELECT t.owner, t.toolname, u.username 
        FROM tools t
        JOIN users u ON u.id = t.owner
        WHERE t.id = :id
        ");
    $statement->bindValue(':id', $id);
    $statement->execute();
    $result = $statement->fetchAll();
    //var_dump($result);
    $owner     = $result[0][0]; // gives first value in a "multidimensional array", in this case the only value.
    $toolname  = $result[0][1];
    $ownername = $result[0][2];
    // create a new loan record:
    $timestamp = date("Y-m-d H:i:s");
    $loanedto  = escape($_SESSION['currentuserid']);
    $record = array(
        "created" => $timestamp,
        "active" => 1,
        "tool" => $id,
        "owner" => $owner,
        "loanedto" => $_SESSION['currentuserid']
    );
    $sql = sprintf(
        "INSERT INTO %s (%s) values (%s)",
        "loans",
        implode(", ", array_keys($record)),
        ":" . implode(", :", array_keys($record))
    );
    $statement = $connection->prepare($sql);
    $statement->execute($record);
    //var_dump($statement);
  } catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
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
  $userid = $_SESSION['currentuserid'];
  $statement = $connection->prepare("
        SELECT l.*, t.toolname, u1.username AS username1, u2.username AS username2 FROM loans l
		JOIN tools t ON l.tool = t.id
		JOIN users u1 ON l.owner = u1.id
		JOIN users u2 ON l.loanedto = u2.id
		WHERE ( l.deleted = '0000-00-00 00:00:00' OR l.deleted IS NULL )
        AND l.active = 1
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

<h2><a href="index.php"><?php echo escape($_SESSION['currentusername']); ?></a> || You are loaning from others || <a href="loan-in-history.php">history</a></h2>

<?php if (isset($_POST['loan']) && $statement) : ?>
    <blockquote class="success">Successfully recorded your new loan. Now you may pick up the <b><?php echo escape($toolname) ?></b> from
        <a href="/users/view.php?id=<?php echo escape($owner) ?>"><?php echo escape($ownername) ?></a></b>.</blockquote>
<?php endif; ?>

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
</form>

<?php require "../common/footer.php"; ?>
