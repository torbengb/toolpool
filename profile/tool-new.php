<?php
require "../common/common.php";
require "../common/header.php";
// Action on LOAD:
try { // load foreign tables:
  // list for taxonomy1:
  $statement = $connection->prepare("
        SELECT name, id FROM taxonomy
        WHERE ( deleted = '0000-00-00 00:00:00' OR deleted IS NULL )
        AND parent = 1 -- only fetch 1st level items
        AND id > 1 -- do not fetch '(none)'
        ORDER BY name
        ");
  $statement->execute();
  $tax1 = $statement->fetchAll();
} catch (PDOException $error) {
  showMessage(__LINE__, __FILE__, $sql . "<br>" . $error->getMessage());
}
?>

<h2>Add new tool</h2>

<form method="post" action="tool-list.php">
    <input class="button submit" type="submit" name="submit" value="Submit">
    <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">
    <input type="hidden" name="owner" value="<?php echo escape($_SESSION['currentusername']) ?>">
    <label class="label" for="offered"><input class="input" type="checkbox" name="offered" id="offered" value=1 checked>Offered</label>
    <label class="label" for="toolname">Tool name<input class="input" type="text" name="toolname" id="toolname"></label>
    <label class="label" for="brand">Brand<input class="input" type="text" name="brand" id="brand"></label>
    <label class="label" for="model">Model<input class="input" type="text" name="model" id="model"></label>
    <label class="label" for="dimensions">Dimensions<input class="input" type="text" name="dimensions" id="dimensions"></label>
    <label class="label" for="weight">Weight<input class="input" type="text" name="weight" id="weight"></label>
    <label class="label" for="privatenotes">Private notes<input class="input" type="text" name="privatenotes"
                                                                id="privatenotes"></label>
    <label class="label" for="publicnotes">Public notes<input class="input" type="text" name="publicnotes"
                                                              id="publicnotes"></label>
    <label class="label" for="taxonomy1">Taxonomy 1
        <select class="input" name="taxonomy1" id="taxonomy1">
          <?php // TODO: issue #10 https://github.com/torbengb/toolpool/issues/10
          foreach ($tax1 as $row) : ?>
              <option value="<?php echo escape($row["id"]); ?>"><?php echo escape($row["name"]); ?></option>
          <?php endforeach; ?>
        </select></label>
    <label class="label" for="taxonomy2">Taxonomy 2<input class="input" type="text" name="taxonomy2"
                                                          id="taxonomy2"></label>
    <label class="label" for="taxonomy3">Taxonomy 3<input class="input" type="text" name="taxonomy3"
                                                          id="taxonomy3"></label>
    <label class="label" for="taxonomy4">Taxonomy 4<input class="input" type="text" name="taxonomy4"
                                                          id="taxonomy4"></label>
    <label class="label" for="taxonomy5">Taxonomy 5<input class="input" type="text" name="taxonomy5"
                                                          id="taxonomy5"></label>
    <label class="label" for="electrical230v"><input class="input" type="checkbox" name="electrical230v"
                                                     id="electrical230v" value=1>Electrical 230v</label>
    <label class="label" for="electrical400v"><input class="input" type="checkbox" name="electrical400v"
                                                     id="electrical400v" value=1>Electrical 400v</label>
    <label class="label" for="hydraulic"><input class="input" type="checkbox" name="hydraulic" id="hydraulic" value=1>Hydraulic</label>
    <label class="label" for="pneumatic"><input class="input" type="checkbox" name="pneumatic" id="pneumatic" value=1>Pneumatic</label>

    <input class="button submit" type="submit" name="create" value="Submit">
</form>

<?php require "../common/footer.php"; ?>
