<?php
require "../common/common.php";
require "../common/header.php";
?>

<h2>Add new tool</h2>

<?php
if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $timestamp = date("Y-m-d H:i:s");
    
    $new_tool = array(
      "created" => $timestamp,
      "owner" => $_POST['owner'],
      "offered" => $_POST['offered'],
      "toolname" => $_POST['toolname'],
      "brand" => $_POST['brand'],
      "model" => $_POST['model'],
      "dimensions" => $_POST['dimensions'],
      "weight" => $_POST['weight'],
      "privatenotes" => $_POST['privatenotes'],
      "publicnotes" => $_POST['publicnotes'],
      "taxonomy1" => $_POST['taxonomy1'],
      "taxonomy2" => $_POST['taxonomy2'],
      "taxonomy3" => $_POST['taxonomy3'],
      "taxonomy4" => $_POST['taxonomy4'],
      "taxonomy5" => $_POST['taxonomy5'],
      "electrical230v" => $_POST['electrical230v'],
      "electrical400v" => $_POST['electrical400v'],
      "hydraulic" => $_POST['hydraulic'],
      "pneumatic" => $_POST['pneumatic']
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "tools",
      implode(", ", array_keys($new_tool)),
      ":" . implode(", :", array_keys($new_tool))
    );
    $statement = $connection->prepare($sql);
    $statement->execute($new_tool);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $owners = "SELECT username, id FROM users u
      WHERE u.deleted = '0000-00-00 00:00:00'
      ORDER BY username";

  $statement = $connection->prepare($owners);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $owners . "<br>" . $error->getMessage();
}
?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote>Successfully added <b><?php echo escape($_POST['toolname']); ?></b> to the <a href="list.php">tool pool</a>.</blockquote>
  <?php endif; ?>

  <form method="post"><input class="submit" type="submit" name="submit" value="Submit">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">

    <label class="label" for="owner">owner
      <select name="owner" id="owner">
        <?php foreach ($result as $row) : ?>
          <option value="<?php echo escape($row["id"]); ?>"><?php echo escape($row["username"]); ?></option>
        <?php endforeach; ?>
      </select></label>
    <label class="label" for="offered"><input type="checkbox" name="offered" id="offered" value=1 checked>offered</label>
    <label class="label" for="toolname">toolname<input type="text" name="toolname" id="toolname"></label>
    <label class="label" for="brand">brand<input type="text" name="brand" id="brand"></label>
    <label class="label" for="model">model<input type="text" name="model" id="model"></label>
    <label class="label" for="dimensions">dimensions<input type="text" name="dimensions" id="dimensions"></label>
    <label class="label" for="weight">weight<input type="text" name="weight" id="weight"></label>
    <label class="label" for="privatenotes">privatenotes<input type="text" name="privatenotes" id="privatenotes"></label>
    <label class="label" for="publicnotes">publicnotes<input type="text" name="publicnotes" id="publicnotes"></label>
    <label class="label" for="taxonomy1">taxonomy1<input type="text" name="taxonomy1" id="taxonomy1"></label>
    <label class="label" for="taxonomy2">taxonomy2<input type="text" name="taxonomy2" id="taxonomy2"></label>
    <label class="label" for="taxonomy3">taxonomy3<input type="text" name="taxonomy3" id="taxonomy3"></label>
    <label class="label" for="taxonomy4">taxonomy4<input type="text" name="taxonomy4" id="taxonomy4"></label>
    <label class="label" for="taxonomy5">taxonomy5<input type="text" name="taxonomy5" id="taxonomy5"></label>
    <label class="label" for="electrical230v"><input type="checkbox" name="electrical230v" id="electrical230v" value=1>electrical230v</label>
    <label class="label" for="electrical400v"><input type="checkbox" name="electrical400v" id="electrical400v" value=1>electrical400v</label>
    <label class="label" for="hydraulic"><input type="checkbox" name="hydraulic" id="hydraulic" value=1>hydraulic</label>
    <label class="label" for="pneumatic"><input type="checkbox" name="pneumatic" id="pneumatic" value=1>pneumatic</label>

    <input class="submit" type="submit" name="submit" value="Submit">
  </form>

<?php require "../common/footer.php"; ?>
