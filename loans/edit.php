<?php
require "../common/common.php";
require "../common/header.php";

if (isset($_POST['submit'])) { // Action on SUBMIT:
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
    $sql = "UPDATE loans 
            SET modified = :modified,
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
    // load the record:
    $id = $_GET['id'];
    $sql = "SELECT l.*, t.toolname, u.username
      FROM loans l
      JOIN tools t ON t.id = l.tool
      JOIN users u ON u.id = l.owner
      WHERE l.id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $loan = $statement->fetch(PDO::FETCH_ASSOC);
    //echo $loan;
    //var_dump(loan);

    // load user list:
    $sql = "SELECT username, id FROM users
        WHERE deleted = '0000-00-00 00:00:00'
        ORDER BY username";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $users = $statement->fetchAll();

  } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
} else { echo "Something went wrong!"; exit; }
?>

<h2>Edit a loan</h2>

<?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote class="success">Successfully updated the loan in the <a href="list.php">loan list</a>.</blockquote>
<?php endif; ?>

<form method="post"><input class="button submit" type="submit" name="submit" value="Submit">
  <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">
  <input type="hidden" name="id" value="<?php echo escape($loan['id']); ?>">
  <input type="hidden" name="tool" id="tool" value="<?php echo escape($loan["tool"]); ?>"></label>
  <input type="hidden" name="owner" id="owner" value="<?php echo escape($loan["owner"]); ?>"></label>

  <label class="label" for="active">Active<input class="input" type="checkbox" name="active" id="active" value="1" <?php echo ( escape($loan["active"]) ? "checked" : NULL ) ?>>Active</label>
  <label class="label" for="tool">Tool<input class="input" readonly type="text" xname="tool" xid="tool" value="<?php echo escape($loan["toolname"]); ?>"></label>
  <label class="label" for="owner">Owner<input class="input" readonly type="text" xname="owner" xid="owner" value="<?php echo escape($loan["username"]); ?>"></label>
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

  <input class="button submit" type="submit" name="submit" value="Submit">
</form>

<?php require "../common/footer.php"; ?>
