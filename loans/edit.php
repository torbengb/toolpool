<?php
require "../common/common.php";
require "../common/header.php";
?>

<h2>Edit a loan</h2>

<?php
if (isset($_POST['submit'])) { // Action on SUBMIT:
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try { // update the record:
    $timestamp = date("Y-m-d H:i:s");
    $record =[
      "id" => $_POST['id'],
      "lastupdated" => $timestamp,
      "active" => $_POST['active'],
      "tool" => $_POST['tool'],
      "owner" => $_POST['owner'],
      "loanedto" => $_POST['loanedto'],
      "agreedstart" => $_POST['agreedstart'],
      "agreedend" => $_POST['agreedend'],
      "actualstart" => $_POST['actualstart'],
      "actualend" => $_POST['actualend'],
    ];
    $sql = "UPDATE loans 
            SET lastupdated = :lastupdated,
              active = :active,
              tool = :tool,
              owner = :owner,
              loanedto = :loanedto,
              agreedstart = :agreedstart,
              agreedend = :agreedend,
              actualstart = :actualstart,
              actualend = :actualend
            WHERE id = :id";
  $statement = $connection->prepare($sql);
    $statement->execute($record);
  } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
}
  
if (isset($_GET['id'])) { // Action on LOAD:
  try { 
    // load the record
    $id = $_GET['id'];
    $sql = "SELECT * FROM loans WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $loan = $statement->fetch(PDO::FETCH_ASSOC);

    // load users:
    $sql = "SELECT username, id FROM users
        WHERE deleted = '0000-00-00 00:00:00'
        ORDER BY username";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $users = $statement->fetchAll();

    // load tools and their owners:
    $sql = "SELECT t.toolname, t.id, u.username
      FROM tools t
      JOIN users u ON u.id = t.owner
      WHERE t.deleted = '0000-00-00 00:00:00'";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $tools = $statement->fetchAll();

  } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
} else {
    echo "Something went wrong!";
    exit;
}

//var_dump($tools);
?>

<?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote class="success">Successfully updated the loan in the <a href="list.php">loan list</a>.</blockquote>
<?php endif; ?>

<form method="post"><input class="submit" type="submit" name="submit" value="Submit">
  <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">
  <input type="hidden" name="id" value="<?php echo escape($loan['id']); ?>">

  <label class="label" for="active">Active<input class="input" type="checkbox" name="active" id="active" value="1" <?php echo ( escape($loan["active"]) ? "checked" : NULL ) ?>>Active</label>
  <label class="label" for="tool">Tool<input class="input" readonly type="text" name="tool" id="tool" value="<?php echo escape($loan["toolname"]); ?>"></label>
  <label class="label" for="owner">Owner<input class="input" readonly type="text" name="owner" id="owner" value="<?php echo escape($tools["username"]); ?>"></label>
  <label class="label" for="loanedto">Loaned to
    <select class="input" name="loanedto" id="loanedto">
      <?php foreach ($users as $row) : ?>
        <option value="<?php echo escape($row["id"]); ?>" <?php echo ( escape($loan["loanedto"]) == escape($row["id"]) ? "selected='selected'" : NULL ) ?>><?php echo escape($row["username"]); ?></option>
      <?php endforeach; ?>
    </select></label>
  <label class="label" for="agreedstart">Agreed start<input class="input" type="text" name="agreedstart" id="agreedstart" value="<?php echo escape($loan["agreedstart"]); ?>" ></label>
  <label class="label" for="agreedend">Agreed end<input class="input" type="text" name="agreedend" id="agreedend" value="<?php echo escape($loan["agreedend"]); ?>" ></label>
  <label class="label" for="actualstart">Actual start<input class="input" type="text" name="actualstart" id="actualstart" value="<?php echo escape($loan["actualstart"]); ?>" ></label>
  <label class="label" for="actualend">Actual end<input class="input" type="text" name="actualend" id="actualend" value="<?php echo escape($loan["actualend"]); ?>" ></label>

  <input class="submit" type="submit" name="submit" value="Submit">
</form>

<?php require "../common/footer.php"; ?>
