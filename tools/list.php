<?php
require "../common/common.php";
require "../common/header.php";
?>

<h2>Tool Pool || <a href="new.php">add new</a></h2>

<?php
$success = null;

if (isset($_POST['submit'])) { // Action on SUBMIT:
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try { // update the record:
    $timestamp = date("Y-m-d H:i:s");
    $id = $_POST["submit"];
    $sql = "UPDATE tools 
			SET deleted = '$timestamp'
			WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $success = "Successfully deleted the tool.";
  } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
}

// Action on LOAD:
try { // load the record:
  $sql = "SELECT t.*, u.username, t1.name AS t1, t2.name AS t2, t3.name AS t3, t4.name AS t4, t5.name AS t5, l.active
    FROM tools t
    JOIN users u ON u.id = t.owner
    LEFT JOIN loans l ON l.tool = t.id 
    			AND l.active = 1
    LEFT JOIN taxonomy t1 ON t1.id = t.taxonomy1 
    LEFT JOIN taxonomy t2 ON t2.id = t.taxonomy2 
    LEFT JOIN taxonomy t3 ON t3.id = t.taxonomy3 
    LEFT JOIN taxonomy t4 ON t4.id = t.taxonomy4 
    LEFT JOIN taxonomy t5 ON t5.id = t.taxonomy5 
    WHERE t.deleted = '0000-00-00 00:00:00'
    AND u.id = t.owner
    ORDER BY offered DESC, taxonomy1, taxonomy2, taxonomy3, taxonomy4, taxonomy5";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
  try { // load foreign tables:
    // list for taxonomy columns:
    $sql = "SELECT name, id, parent FROM taxonomy
      WHERE deleted = '0000-00-00 00:00:00'
      ORDER BY name";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $tax = $statement->fetchAll();
    } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
} catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
?>

<?php if ($success) echo $success; ?>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <table>
    <thead>
      <tr>
          <th>Action</th>
          <th>Owner</th>
          <th>Offered</th>
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
      <tr
        <?php echo
          ( escape($row["offered"])
          ? ( escape($row["active"]) 
            ? 'class="loaned" title="currently loaned"' 
            : 'class="offered"' 
            )
          : 'class="notoffered" title="currently not offered"'
          )
        ?>
      >
          <td><a href="edit.php?id=<?php echo escape($row["id"]); ?>">Edit</a>&nbsp;<button class="submit" type="submit" name="submit" value="<?php echo escape($row["id"]); ?>">Delete!</button></td>
          <td><?php echo escape($row["username"]); ?></td>
          <td><?php echo (escape($row["offered"])) ? 'o' : '-' ; ?></td>
          <td><?php echo escape($row["toolname"]); ?></td>
          <td><?php echo escape($row["brand"]); ?></td>
          <td><?php echo escape($row["model"]); ?></td>
          <td><?php echo escape($row["dimensions"]); ?></td>
          <td><?php echo escape($row["weight"]); ?></td>
          <td><?php echo ( escape($row["taxonomy1"])==0 ? '-' : escape($row["t1"]) ) ; ?></td>
          <td><?php echo ( escape($row["taxonomy2"])==0 ? '-' : escape($row["t2"]) ) ; ?></td>
          <td><?php echo ( escape($row["taxonomy3"])==0 ? '-' : escape($row["t3"]) ) ; ?></td>
          <td><?php echo ( escape($row["taxonomy4"])==0 ? '-' : escape($row["t4"]) ) ; ?></td>
          <td><?php echo ( escape($row["taxonomy5"])==0 ? '-' : escape($row["t5"]) ) ; ?></td>
          <td><?php echo (escape($row["electrical230v"])) ? '230V' : '-' ; ?></td>
          <td><?php echo (escape($row["electrical400v"])) ? '400V' : '-' ; ?></td>
          <td><?php echo (escape($row["hydraulic"])) ? 'hydr' : '-' ; ?></td>
          <td><?php echo (escape($row["pneumatic"])) ? 'pneu' : '-' ; ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</form>

<?php require "../common/footer.php"; ?>
