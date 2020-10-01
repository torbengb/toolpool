<?php
require "../common/common.php";
require "../common/header.php";

if (isset($_POST['submit'])) { // Action on SUBMIT:
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try { // update the record:
    $timestamp = date("Y-m-d H:i:s");
    $record =array(
      "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxid" => $_POST['id'],
      "modified" => $timestamp,
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
    $sql = 'UPDATE tools 
            SET modified = :modified,
              owner = :owner,
              offered = :offered,
              toolname = :toolname,
              brand = :brand,
              model = :model,
              dimensions = :dimensions,
              weight = :weight,
              privatenotes = :privatenotes,
              publicnotes = :publicnotes,
              taxonomy1 = :taxonomy1,
              taxonomy2 = :taxonomy2,
              taxonomy3 = :taxonomy3,
              taxonomy4 = :taxonomy4,
              taxonomy5 = :taxonomy5,
              electrical230v = :electrical230v,
              electrical400v = :electrical400v,
              hydraulic = :hydraulic,
              pneumatic = :pneumatic
            WHERE id = :id';
    $statement = $connection->prepare($sql);
    $statement->execute($record);
  } catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
}
  
if (isset($_GET['id'])) { // Action on LOAD:
  try { 
    // load the record
    $id = $_GET['id'];
    $sql = "SELECT t.*, u.username, t1.name AS t1, t2.name AS t2, t3.name AS t3, t4.name AS t4, t5.name AS t5
      FROM tools t
      JOIN users u ON u.id = t.owner
      LEFT JOIN loans l ON l.tool = t.id
      LEFT JOIN taxonomy t1 ON t1.id = t.taxonomy1
      LEFT JOIN taxonomy t2 ON t2.id = t.taxonomy2
      LEFT JOIN taxonomy t3 ON t3.id = t.taxonomy3
      LEFT JOIN taxonomy t4 ON t4.id = t.taxonomy4
      LEFT JOIN taxonomy t5 ON t5.id = t.taxonomy5
      WHERE t.id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $tool = $statement->fetch(PDO::FETCH_ASSOC);
    
    // load usernames:
    $sql = "SELECT username, id FROM users u
        WHERE u.deleted = '0000-00-00 00:00:00'
        ORDER BY username";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $users = $statement->fetchAll();
    
    // list for taxonomy columns:
    $sql = "SELECT name, id, parent FROM taxonomy
        WHERE deleted = '0000-00-00 00:00:00'
        ORDER BY name";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $tax = $statement->fetchAll();

  } catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<h2>View a tool</h2>

<?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote class="success">Successfully updated your <b><?php echo escape($_POST['toolname']); ?></b> in the <a href="list.php">tool pool</a>.</blockquote>
<?php endif; ?>

<form method="post"><input class="button submit" type="submit" name="submit" value="Submit">
  <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">
  <input type="hidden" name="id" value="<?php echo escape($tool['id']); ?>">

  <label class="label" for="owner">Owner<input class="input" readonly type="text" name="owner" id="owner" value="<?php echo escape($tool["username"]); ?>"></label>
  <label class="label" for="offered"><input class="input" readonly type="checkbox" name="offered" id="offered" value="1" <?php echo ( escape($tool["offered"]) ? "checked" : NULL ) ?>>Offered</label>
  <label class="label" for="toolname">Tool name<input class="input" readonly type="text" name="toolname" id="toolname" value="<?php echo escape($tool["toolname"]); ?>"></label>
  <label class="label" for="brand">Brand<input class="input" readonly type="text" name="brand" id="brand" value="<?php echo escape($tool["brand"]); ?>"></label>
  <label class="label" for="model">Model<input class="input" readonly type="text" name="model" id="model" value="<?php echo escape($tool["model"]); ?>"></label>
  <label class="label" for="weight">Weight<input class="input" readonly type="text" name="weight" id="weight" value="<?php echo escape($tool["weight"]); ?>"></label>
  <label class="label" for="dimensions">Dimensions<input class="input" readonly type="text" name="dimensions" id="dimensions" value="<?php echo escape($tool["dimensions"]); ?>"></label>
  <label class="label" for="privatenotes">Privatenotes<input class="input" readonly type="text" name="privatenotes" id="privatenotes" value="<?php echo escape($tool["privatenotes"]); ?>"></label>
  <label class="label" for="publicnotes">Publicnotes<input class="input" readonly type="text" name="publicnotes" id="publicnotes" value="<?php echo escape($tool["publicnotes"]); ?>"></label>
  <label class="label" for="taxonomy1">Taxonomy 1<input class="input" readonly type="text" name="taxonomy1" id="taxonomy1" value="<?php echo escape($tool["taxonomy1"])==0 ? '-' : escape($tool["t1"]) ; ?>"></label>
  <label class="label" for="taxonomy2">Taxonomy 2<input class="input" readonly type="text" name="taxonomy2" id="taxonomy2" value="<?php echo escape($tool["taxonomy2"])==0 ? '-' : escape($tool["t2"]) ; ?>"></label>
  <label class="label" for="taxonomy3">Taxonomy 3<input class="input" readonly type="text" name="taxonomy3" id="taxonomy3" value="<?php echo escape($tool["taxonomy3"])==0 ? '-' : escape($tool["t3"]) ; ?>"></label>
  <label class="label" for="taxonomy4">Taxonomy 4<input class="input" readonly type="text" name="taxonomy4" id="taxonomy4" value="<?php echo escape($tool["taxonomy4"])==0 ? '-' : escape($tool["t4"]) ; ?>"></label>
  <label class="label" for="taxonomy5">Taxonomy 5<input class="input" readonly type="text" name="taxonomy5" id="taxonomy5" value="<?php echo escape($tool["taxonomy5"])==0 ? '-' : escape($tool["t5"]) ; ?>"></label>
  <label class="label" for="electrical230v"><input class="input" type="checkbox" name="electrical230v" id="electrical230v" value="1" <?php echo ( escape($tool["electrical230v"]) ? "checked" : NULL ) ?>>Electrical230v</label>
  <label class="label" for="electrical400v"><input class="input" type="checkbox" name="electrical400v" id="electrical400v" value="1" <?php echo ( escape($tool["electrical400v"]) ? "checked" : NULL ) ?>>Electrical400v</label>
  <label class="label" for="hydraulic">     <input class="input" type="checkbox" name="hydraulic"      id="hydraulic"      value="1" <?php echo ( escape($tool["hydraulic"]     ) ? "checked" : NULL ) ?>>Hydraulic</label>
  <label class="label" for="pneumatic">     <input class="input" type="checkbox" name="pneumatic"      id="pneumatic"      value="1" <?php echo ( escape($tool["pneumatic"]     ) ? "checked" : NULL ) ?>>Pneumatic</label>

  <input class="button submit" type="submit" name="submit" value="Submit">
</form>

<?php require "../common/footer.php"; ?>
