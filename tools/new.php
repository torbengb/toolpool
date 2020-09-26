<?php
require "../common/common.php";
require "../common/header.php";
?>

<h2>Add new tool</h2>

<?php
if (isset($_POST['submit'])) { // Action on SUBMIT:
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  { // create the record:
    $timestamp = date("Y-m-d H:i:s");
    $record = array(
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
      implode(", ", array_keys($record)),
      ":" . implode(", :", array_keys($record))
    );
    $statement = $connection->prepare($sql);
    $statement->execute($record);
  } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
}

// Action on LOAD:
try { // load foreign tables:
    // list of usernames:
  $sql = "SELECT username, id FROM users u
      WHERE u.deleted = '0000-00-00 00:00:00'
      ORDER BY username";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $users = $statement->fetchAll();
    
  try { // load foreign tables:
    // list for taxonomy1:
    $sql = "SELECT name, id FROM taxonomy
        WHERE deleted = '0000-00-00 00:00:00'
        AND parent = 0 -- only fetch 1st level items
        AND id > 0 -- do not fetch '(none)'
        ORDER BY name";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $tax1 = $statement->fetchAll();
    } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
} catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }

//var_dump($tax1);
?>

<?php if (isset($_POST['submit']) && $statement) : ?>
  <blockquote class="success">Successfully added <b><?php echo escape($_POST['toolname']); ?></b> to the <a href="list.php">tool pool</a>.</blockquote>
<?php endif; ?>

<form method="post"><input class="submit" type="submit" name="submit" value="Submit">
  <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">

  <label class="label" for="owner">Owner
    <select class="input" name="owner" id="owner">
      <?php foreach ($users as $row) : ?>
        <option value="<?php echo escape($row["id"]); ?>"><?php echo escape($row["username"]); ?></option>
      <?php endforeach; ?>
    </select></label>
  <label class="label" for="offered"><input class="input" type="checkbox" name="offered" id="offered" value=1 checked>Offered</label>
  <label class="label" for="toolname">Tool name<input class="input" type="text" name="toolname" id="toolname"></label>
  <label class="label" for="brand">Brand<input class="input" type="text" name="brand" id="brand"></label>
  <label class="label" for="model">Model<input class="input" type="text" name="model" id="model"></label>
  <label class="label" for="dimensions">Dimensions<input class="input" type="text" name="dimensions" id="dimensions"></label>
  <label class="label" for="weight">Weight<input class="input" type="text" name="weight" id="weight"></label>
  <label class="label" for="privatenotes">Private notes<input class="input" type="text" name="privatenotes" id="privatenotes"></label>
  <label class="label" for="publicnotes">Public notes<input class="input" type="text" name="publicnotes" id="publicnotes"></label>
  <label class="label" for="taxonomy1">Taxonomy 1
    <select class="input" name="taxonomy1" id="taxonomy1">
      <?php foreach ($tax1 as $row) : ?>
        <option value="<?php echo escape($row["id"]); ?>"><?php echo escape($row["name"]); ?></option>
      <?php endforeach; ?>
    </select></label>
  <label class="label" for="taxonomy2">Taxonomy 2<input class="input" type="text" name="taxonomy2" id="taxonomy2"></label>
  <label class="label" for="taxonomy3">Taxonomy 3<input class="input" type="text" name="taxonomy3" id="taxonomy3"></label>
  <label class="label" for="taxonomy4">Taxonomy 4<input class="input" type="text" name="taxonomy4" id="taxonomy4"></label>
  <label class="label" for="taxonomy5">Taxonomy 5<input class="input" type="text" name="taxonomy5" id="taxonomy5"></label>
  <label class="label" for="electrical230v"><input class="input" type="checkbox" name="electrical230v" id="electrical230v" value=1>Electrical 230v</label>
  <label class="label" for="electrical400v"><input class="input" type="checkbox" name="electrical400v" id="electrical400v" value=1>Electrical 400v</label>
  <label class="label" for="hydraulic"><input class="input" type="checkbox" name="hydraulic" id="hydraulic" value=1>Hydraulic</label>
  <label class="label" for="pneumatic"><input class="input" type="checkbox" name="pneumatic" id="pneumatic" value=1>Pneumatic</label>

  <input class="submit" type="submit" name="submit" value="Submit">
</form>

<?php require "../common/footer.php"; ?>
