<?php
require "../common/common.php";
require "../common/header.php";

if (isset($_POST['submit'])) { // Action on SUBMIT:
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

// Action on LOAD:
try { 
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
    WHERE t.deleted = '0000-00-00 00:00:00'
    ORDER BY t.toolname";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $tools = $statement->fetchAll();
} catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
?>

<h2>Add new loan</h2>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote class="success">Successfully added a loan to the <a href="list.php">loans list</a>.</blockquote>
  <?php endif; ?>

<form method="post"><input class="button submit" type="submit" name="submit" value="Submit">
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

  <input class="button submit" type="submit" name="submit" value="Submit">
</form>

<?php require "../common/footer.php"; ?>
