<?php
require "../common/common.php";
require "../common/header.php";

if (isset($_POST['create'])) { // Action on SUBMIT:
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
  } catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
}

if (isset($_POST['update'])) {
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
    $statement = $connection->prepare("
        UPDATE tools 
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
            WHERE id = :id
        ");
    $statement->execute($record);
  } catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
}

if (isset($_POST['delete'])) { // Action on SUBMIT:
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  try { // update the record:
    $timestamp = date("Y-m-d H:i:s");
    $id = $_POST['id'];
    $statement = $connection->prepare("
        UPDATE tools 
			SET deleted = '$timestamp'
			WHERE id = :id
        ");
    $statement->bindValue(':id', $id);
    $statement->execute();
  } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
}

// Action on LOAD:
try { // load the record:
  $sql = "SELECT DISTINCT t.*, u.username, u.id AS userid, t1.name AS t1, t2.name AS t2, t3.name AS t3, t4.name AS t4, t5.name AS t5, l.active
    FROM tools t
    JOIN users u ON u.id = t.owner
    LEFT JOIN loans l ON l.tool = t.id 
    			AND l.active = 1
    			AND ( l.deleted = '0000-00-00 00:00:00' OR  l.deleted IS NULL )
    LEFT JOIN taxonomy t1 ON t1.id = t.taxonomy1 -- LEFT includes tools without a taxonomy.
    LEFT JOIN taxonomy t2 ON t2.id = t.taxonomy2 
    LEFT JOIN taxonomy t3 ON t3.id = t.taxonomy3 
    LEFT JOIN taxonomy t4 ON t4.id = t.taxonomy4 
    LEFT JOIN taxonomy t5 ON t5.id = t.taxonomy5 
    WHERE ( t.deleted = '0000-00-00 00:00:00' OR  t.deleted IS NULL )
      AND t.offered = 1 -- comment this line to show notoffered items in the tools list.
      AND ( u.deleted = '0000-00-00 00:00:00' OR  u.deleted IS NULL ) -- hide tools from deleted owners.
    ORDER BY t.toolname -- t1, t2, t3, T4, t5 -- TODO: order the list meaningfully.
    ";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();

  // list for taxonomy columns:
  $statement = $connection->prepare("
        SELECT name, id, parent FROM taxonomy
        WHERE deleted = '0000-00-00 00:00:00'
        ORDER BY name
        ");
  $statement->execute();
  $tax = $statement->fetchAll();

} catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
?>

<h2>Tool Pool</h2>

  <table>
    <thead>
      <tr>
          <th>Action</th>
          <th>Owner</th>
          <th>Availability</th>
          <th>Tool name</th>
          <th>Brand</th>
          <th>Model</th>
          <th>Dimensions</th>
          <th>Taxonomy1</th>
          <th>Taxonomy2</th>
          <th>Taxonomy3</th>
          <th>230V</th>
          <th>400V</th>
          <th>Battery</th>
          <th>Hydraulic</th>
          <th>Pneumatic</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
          <td>
              <?php if (isset($_SESSION['currentusername'])
                  && escape($row["userid"]) == $_SESSION['currentuserid'] ) : ?>
                  (your tool)
              <?php elseif (isset($_SESSION['currentusername'])
                  && escape($row["userid"]) != $_SESSION['currentuserid'] ) : ?>
              <form method="post" action="/profile/loan-in.php">
                  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
                  <button class="button edit" type="submit" name="loan" value="<?php echo escape($row["id"]); ?>">Loan</button>
              </form>
              <?php else: ?>
              &nbsp;<!-- no actions when not logged in! -->
              <?php endif; ?>
          </td>
          <td><a href="/users/view.php?id=<?php echo escape($row["userid"]); ?>"><?php echo escape($row["username"]); ?></a></td>
	      <?php
            echo(escape($row["offered"]) ?
                (escape($row["active"]) ?
                    '<td class="loaned" title="currently loaned">waiting list</td>' :
                    '<td class="offered">available</td>')
                : '<td class="notoffered" title="currently not offered">not offered</td>')
	      ?>
          <td><a href="/tools/view.php?id=<?php echo escape($row["id"]); ?>"><?php echo escape($row["toolname"]); ?></a></td>
          <td><?php echo escape($row["brand"]); ?></td>
          <td><?php echo escape($row["model"]); ?></td>
          <td><?php echo escape($row["dimensions"]); ?></td>
          <td><?php echo escape($row["taxonomy1"])==0 ? '-' : escape($row["t1"]) ; ?></td>
          <td><?php echo escape($row["taxonomy2"])==0 ? '-' : escape($row["t2"]) ; ?></td>
          <td><?php echo escape($row["taxonomy3"])==0 ? '-' : escape($row["t3"]) ; ?></td>
          <td><?php echo escape($row["electrical230v"]) ? '230V' : '-' ; ?></td>
          <td><?php echo escape($row["electrical400v"]) ? '400V' : '-' ; ?></td>
          <td><?php echo escape($row["electricalbatt"]) ? 'batt' : '-' ; ?></td>
          <td><?php echo escape($row["hydraulic"]) ? 'hydr' : '-' ; ?></td>
          <td><?php echo escape($row["pneumatic"]) ? 'pneu' : '-' ; ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>

<?php require "../common/footer.php"; ?>
