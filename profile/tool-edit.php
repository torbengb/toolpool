<?php
require "../common/common.php";
require "../common/header.php";
  
if (isset($_GET['id'])) { // Action on LOAD:
  try { 
    // load the record
    $id = $_GET['id'];
    $statement = $connection->prepare("
        SELECT * FROM tools WHERE id = :id
        ");
    $statement->bindValue(':id', $id);
    $statement->execute();
    $tool = $statement->fetch(PDO::FETCH_ASSOC);
    
    // load usernames:
    $statement = $connection->prepare("
        SELECT username, id FROM users
        WHERE ( deleted = '0000-00-00 00:00:00' OR deleted IS NULL )
        ORDER BY username
        ");
    $statement->execute();
    $users = $statement->fetchAll();

    // list for taxonomy columns:
    $statement = $connection->prepare("
        SELECT name, id
        FROM taxonomy
        WHERE ( deleted = '0000-00-00 00:00:00' OR deleted IS NULL )
        AND id > 1 -- defaults to '(not specified)' while suppressing '(none)'.
        AND parent = 1 -- this gets us only first-level categories.
        ORDER BY name
        ");
    $statement->execute();
    $tax1 = $statement->fetchAll();

    // list for taxonomy columns:
    $statement = $connection->prepare("
        SELECT name, id
        FROM taxonomy
        WHERE ( deleted = '0000-00-00 00:00:00' OR deleted IS NULL )
        ORDER BY name
        ");
    $statement->execute();
    $tax = $statement->fetchAll();

  } catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
} else { showMessage( __LINE__ , __FILE__ ); exit; }
?>

<h2><a href="index.php"><?php echo escape($_SESSION['currentusername']); ?></a> || Edit a tool || <a href="tool-list.php">back to list</a></h2>

<form action="tool-list.php" method="post">
  <button class="button delete" type="submit" name="update" value="update">Update</button>
  <button class="button delete" type="submit" name="delete" value="delete">Delete</button>
  <input type="hidden" name="csrf"  value="<?php echo escape($_SESSION['csrf']); ?>">
  <input type="hidden" name="id"    value="<?php echo escape($tool['id']); ?>">
  <input type="hidden" name="owner" value="<?php echo escape($tool['owner']); ?>">

  <label class="label" for="offered"><input class="input" type="checkbox" name="offered" id="offered" value="1" <?php echo ( escape($tool["offered"]) ? "checked" : NULL ) ?>>Offered</label>
  <label class="label" for="toolname">Tool name<input class="input" type="text" name="toolname" id="toolname" type="text" value="<?php echo escape($tool["toolname"]); ?>"></label>
  <label class="label" for="brand">Brand<input class="input" type="text" name="brand" id="brand" value="<?php echo escape($tool["brand"]); ?>"></label>
  <label class="label" for="model">Model<input class="input" type="text" name="model" id="model" value="<?php echo escape($tool["model"]); ?>"></label>
  <label class="label" for="weight">Weight<input class="input" type="text" name="weight" id="weight" value="<?php echo escape($tool["weight"]); ?>"></label>
  <label class="label" for="dimensions">Dimensions<input class="input" type="text" name="dimensions" id="dimensions" value="<?php echo escape($tool["dimensions"]); ?>"></label>
  <label class="label" for="privatenotes">Privatenotes<input class="input" type="text" name="privatenotes" id="privatenotes" value="<?php echo escape($tool["privatenotes"]); ?>"></label>
  <label class="label" for="publicnotes">Publicnotes<input class="input" type="text" name="publicnotes" id="publicnotes" value="<?php echo escape($tool["publicnotes"]); ?>"></label>
  <label class="label" for="taxonomy1"><span class="labeltext">Taxonomy 1</span>
    <select class="input" name="taxonomy1" id="taxonomy1">
      <?php foreach ($tax1 as $row) : ?>
        <option 
          name="taxonomy1" 
          id="taxonomy1"
          value="<?php echo escape($row["id"]); ?>" 
            <?php echo ( escape($row["id"]) == escape($tool["taxonomy1"]) ? "selected='selected'" : NULL ) ?>
        ><?php echo escape($row["name"]) ; ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <label class="label" for="taxonomy2"><span class="labeltext">Taxonomy 2</span>
    <select class="input" name="taxonomy2" id="taxonomy2">
      <?php foreach ($tax as $row) : ?>
        <option 
          name="taxonomy2" 
          id="taxonomy2"
          value="<?php echo escape($row["id"]); ?>" 
            <?php echo ( escape($row["id"]) == escape($tool["taxonomy2"]) ? "selected='selected'" : NULL ) ?>
        ><?php echo escape($row["name"]) ; ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <label class="label" for="taxonomy3"><span class="labeltext">Taxonomy 3</span>
    <select class="input" name="taxonomy3" id="taxonomy3">
      <?php foreach ($tax as $row) : ?>
        <option 
          name="taxonomy3" 
          id="taxonomy3"
          value="<?php echo escape($row["id"]); ?>" 
            <?php echo ( escape($row["id"]) == escape($tool["taxonomy3"]) ? "selected='selected'" : NULL ) ?>
        ><?php echo escape($row["name"]) ; ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <label class="label" for="taxonomy4"><span class="labeltext">Taxonomy 4</span>
    <select class="input" name="taxonomy4" id="taxonomy4">
      <?php foreach ($tax as $row) : ?>
        <option 
          name="taxonomy4" 
          id="taxonomy4"
          value="<?php echo escape($row["id"]); ?>" 
            <?php echo ( escape($row["id"]) == escape($tool["taxonomy4"]) ? "selected='selected'" : NULL ) ?>
        ><?php echo escape($row["name"]) ; ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <label class="label" for="taxonomy5"><span class="labeltext">Taxonomy 5</span>
    <select class="input" name="taxonomy5" id="taxonomy5">
      <?php foreach ($tax as $row) : ?>
        <option 
          name="taxonomy5" 
          id="taxonomy5"
          value="<?php echo escape($row["id"]); ?>" 
            <?php echo ( escape($row["id"]) == escape($tool["taxonomy5"]) ? "selected='selected'" : NULL ) ?>
        ><?php echo escape($row["name"]) ; ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <label class="label" for="electrical230v"><input class="input" type="checkbox" name="electrical230v" id="electrical230v" value="1" <?php echo ( escape($tool["electrical230v"]) ? "checked" : NULL ) ?>>Electrical230v</label>
  <label class="label" for="electrical400v"><input class="input" type="checkbox" name="electrical400v" id="electrical400v" value="1" <?php echo ( escape($tool["electrical400v"]) ? "checked" : NULL ) ?>>Electrical400v</label>
  <label class="label" for="hydraulic">     <input class="input" type="checkbox" name="hydraulic"      id="hydraulic"      value="1" <?php echo ( escape($tool["hydraulic"]     ) ? "checked" : NULL ) ?>>Hydraulic</label>
  <label class="label" for="pneumatic">     <input class="input" type="checkbox" name="pneumatic"      id="pneumatic"      value="1" <?php echo ( escape($tool["pneumatic"]     ) ? "checked" : NULL ) ?>>Pneumatic</label>

  <button class="button delete" type="submit" name="update" value="update">Update</button>
</form>

<?php require "../common/footer.php"; ?>
