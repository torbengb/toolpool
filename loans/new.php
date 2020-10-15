<?php
require "../common/common.php";
require "../common/header.php";

// Action on LOAD:
try { 
  // load users:
  $statement = $connection->prepare("
      SELECT username, id FROM users
      WHERE ( deleted = '0000-00-00 00:00:00' OR deleted IS NULL )
      ORDER BY username
      ");
  $statement->execute();
  $users = $statement->fetchAll();
  // load tools and their owners:
  $statement = $connection->prepare("
      SELECT t.toolname, t.id, u.username
        FROM tools t
        JOIN users u ON u.id = t.owner
        WHERE ( t.deleted = '0000-00-00 00:00:00' OR t.deleted IS NULL )
        ORDER BY t.toolname
        ");
  $statement->execute();
  $tools = $statement->fetchAll();
} catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
?>

<h2>Add new loan</h2>

<form method="post" action="list.php">
  <button class="button submit" type="submit" name="create" value="create">Loan</button>
  <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">

  <label class="label" for="active"><input class="input" type="checkbox" name="active" id="active" value=1 checked>active</label>
  <label class="label" for="tool">Tool
    <select class="input" name="tool" id="tool">
      <?php foreach ($tools as $row) : ?><option value="<?php echo escape($row["id"]); ?>"><?php echo escape($row["toolname"]); ?></option>
      <?php endforeach; ?>
    </select></label>
  <label class="label" for="owner">owner<input class="input" readonly type="text" name="owner" id="owner" value="<?php echo escape($row["username"]); ?>"></label>
  <label class="label" for="loanedto">Loaned to
    <select class="input" name="loanedto" id="loanedto">
      <?php foreach ($users as $row) : ?><option value="<?php echo escape($row["id"]); ?>"><?php echo escape($row["username"]); ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <label class="label" for="agreedstart">agreedstart<input class="input" type="text" name="agreedstart" id="agreedstart"></label>
  <label class="label" for="agreedend"  >agreedend  <input class="input" type="text" name="agreedend"   id="agreedend"  ></label>
  <label class="label" for="actualstart">actualstart<input class="input" type="text" name="actualstart" id="actualstart"></label>
  <label class="label" for="actualend"  >actualend  <input class="input" type="text" name="actualend"   id="actualend"  ></label>

  <button class="button submit" type="submit" name="create" value="create">Loan</button>
</form>

<?php require "../common/footer.php"; ?>
