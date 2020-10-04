<?php
require "../common/common.php";
require "../common/header.php";

if (isset($_POST['update'])) {
  echo __LINE__ . ":update:" . $_POST["id"] . "<br>";
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try { // update the record:
    $timestamp = date("Y-m-d H:i:s");
    $record =array(
        "id" => $_POST['id'],
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

if (isset($_POST['delete'])) { // Action on SUBMIT:
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try { // update the record:
    $timestamp = date("Y-m-d H:i:s");
    $id = $_POST['id'];
    $sql = "UPDATE tools 
			SET deleted = '$timestamp'
			WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
  } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
}

if (isset($_POST['loan'])) { // Action on SUBMIT:
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  try {
// first collect the necessary data:
    $id = $_POST["loan"];
    $sql = "SELECT t.owner, t.toolname, u.username 
      FROM tools t
      JOIN users u ON u.id = t.owner
      WHERE t.id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $result = $statement->fetchAll();
    //var_dump($result);
    $owner     = $result[0][0]; // gives first value in a "multidimensional array", in this case the only value.
    $toolname  = $result[0][1];
    $ownername = $result[0][2];
// create a new loan record:
    $timestamp = date("Y-m-d H:i:s");
    $loanedto  = 12; // TODO: get the current user id. This is currently hardcoded! :(
    $record = array(
      "created" => $timestamp,
      "active" => 1,
      "tool" => $id,
      "owner" => $owner,
      "loanedto" => $loanedto
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

// Action on LOAD:
try { // load the record:
  $sql = "SELECT t.*, u.username, t1.name AS t1, t2.name AS t2, t3.name AS t3, t4.name AS t4, t5.name AS t5, l.active
    FROM tools t
    JOIN users u ON u.id = t.owner
    LEFT JOIN loans l ON l.tool = t.id 
    			AND l.active = 1
    			AND l.deleted = '0000-00-00 00:00:00'
    LEFT JOIN taxonomy t1 ON t1.id = t.taxonomy1 -- LEFT includes tools without a taxonomy.
    LEFT JOIN taxonomy t2 ON t2.id = t.taxonomy2 
    LEFT JOIN taxonomy t3 ON t3.id = t.taxonomy3 
    LEFT JOIN taxonomy t4 ON t4.id = t.taxonomy4 
    LEFT JOIN taxonomy t5 ON t5.id = t.taxonomy5 
    WHERE t.deleted = '0000-00-00 00:00:00'
    ORDER BY t.toolname -- t1, t2, t3, T4, t5 -- TODO: order the list meaningfully.
    ";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();

  // list for taxonomy columns:
  $sql = "SELECT name, id, parent FROM taxonomy
    WHERE deleted = '0000-00-00 00:00:00'
    ORDER BY name";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $tax = $statement->fetchAll();

} catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
?>

<h2>Tool Pool || <a href="new.php">add new</a></h2>

<?php if (isset($_POST['update']) && $statement) : ?>
    <blockquote class="success">Successfully updated your <b><?php echo escape($_POST['toolname']); ?></b> in the <a href="list.php">tool pool</a>.</blockquote>
<?php endif; ?>

<?php if (isset($_POST['delete']) && $statement) : ?>
    <blockquote class="success">Successfully deleted your <b><?php echo escape($_POST['toolname']); ?></b>!</blockquote>
<?php endif; ?>

<?php if (isset($_POST['loan']) && $statement) : ?>
    <blockquote>Successfully recorded <a href="../loans/list.php">your new loan</a>. Now you may pick up the <b><?php echo escape($toolname) ?></b> from <b><?php echo escape($ownername) ?></b>.</blockquote>
<?php endif; ?>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <table><tr><td width="25%" align="right">Legend:</td>
            <td width="25%" align="center" class="offered">Available</td>
            <td width="25%" align="center" class="loaned">Waiting list</td>
            <td width="25%" align="center" class="notoffered">Currently not loanable</td></tr></table>
  <table>
    <thead>
      <tr>
          <th align="center">Action</th>
          <th>Owner</th>
          <th>Availability</th>
          <th>Tool name</th>
          <th>Brand</th>
          <th>Model</th>
          <th>Dimensions</th>
          <th>Weight</th>
          <th>Taxonomy1</th>
          <th>Taxonomy2</th>
          <th>Taxonomy3</th>
          <th>Taxonomy4</th>
          <th>Taxonomy5</th>
          <th>230V</th>
          <th>400V</th>
          <th>Hydraulic</th>
          <th>Pneumatic</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
          <td align="center">
            <button class="button edit" type="submit" name="loan" value="<?php echo escape($row["id"]); ?>">Loan</button>
            <a href="edit.php?id=<?php echo escape($row["id"]); ?>">Edit</a>
            <!--button class="button delete" type="submit" name="delete" value="<?php echo escape($row["id"]); ?> action="list.php">Delete!</button-->
          </td>
          <td><?php echo escape($row["username"]); ?></td>
          <td
              <?php echo
              ( escape($row["offered"])
                  ? ( escape($row["active"])
                      ? 'class="loaned" title="currently loaned"'
                      : 'class="offered"' )
                  : 'class="notoffered" title="currently not offered"' )
              ?>
          >
            <?php echo
            ( escape($row["offered"])
                ? ( escape($row["active"])
                    ? "loaned"
                    : "available" )
                : "not offered" )
            ?></td>
          <td><?php echo escape($row["toolname"]); ?></td>
          <td><?php echo escape($row["brand"]); ?></td>
          <td><?php echo escape($row["model"]); ?></td>
          <td><?php echo escape($row["dimensions"]); ?></td>
          <td><?php echo escape($row["weight"]); ?></td>
          <td><?php echo escape($row["taxonomy1"])==0 ? '-' : escape($row["t1"]) ; ?></td>
          <td><?php echo escape($row["taxonomy2"])==0 ? '-' : escape($row["t2"]) ; ?></td>
          <td><?php echo escape($row["taxonomy3"])==0 ? '-' : escape($row["t3"]) ; ?></td>
          <td><?php echo escape($row["taxonomy4"])==0 ? '-' : escape($row["t4"]) ; ?></td>
          <td><?php echo escape($row["taxonomy5"])==0 ? '-' : escape($row["t5"]) ; ?></td>
          <td><?php echo escape($row["electrical230v"]) ? '230V' : '-' ; ?></td>
          <td><?php echo escape($row["electrical400v"]) ? '400V' : '-' ; ?></td>
          <td><?php echo escape($row["hydraulic"]) ? 'hydr' : '-' ; ?></td>
          <td><?php echo escape($row["pneumatic"]) ? 'pneu' : '-' ; ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</form>

<?php require "../common/footer.php"; ?>
