<?php
require "../common/common.php";
require "../common/header.php";

if (isset($_GET['id'])) { // Action on LOAD:
  try { // load the record
    $id        = $_GET['id'];
    $statement = $connection->prepare("SELECT * FROM users WHERE id = :id");
    $statement->bindValue(':id', $id);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    // list of countries:
    $statement = $connection->prepare("
        SELECT code, name FROM countries
        WHERE ( deleted = '0000-00-00 00:00:00' OR deleted IS NULL )
        ORDER BY name
        ");
    $statement->execute();
    $countries = $statement->fetchAll();
    // list for regions:
    $statement = $connection->prepare("
        SELECT code, name FROM regions
        WHERE ( deleted = '0000-00-00 00:00:00' OR deleted IS NULL )
        ORDER BY code
        ");
    $statement->execute();
    $regions = $statement->fetchAll();
  } catch (PDOException $error) {
    showMessage(__LINE__, __FILE__, $sql . "<br>" . $error->getMessage());
  }
} else {
  showMessage(__LINE__, __FILE__, "No user was specified!");
  exit;
}

// Action on LOAD:
try { // load the record:
  $owner     = $_GET['id'];
  $statement = $connection->prepare("
    SELECT DISTINCT t.*, u.username, t1.name AS t1, t2.name AS t2, t3.name AS t3, t4.name AS t4, t5.name AS t5, l.active
    FROM tools t
    JOIN users u ON u.id = t.owner
    LEFT JOIN loans l ON l.tool = t.id 
    			AND l.active = 1
    			AND ( l.deleted = '0000-00-00 00:00:00'
    			  OR  l.deleted IS NULL
    			)
    LEFT JOIN taxonomy t1 ON t1.id = t.taxonomy1 -- LEFT includes tools without a taxonomy.
    LEFT JOIN taxonomy t2 ON t2.id = t.taxonomy2 
    LEFT JOIN taxonomy t3 ON t3.id = t.taxonomy3 
    LEFT JOIN taxonomy t4 ON t4.id = t.taxonomy4 
    LEFT JOIN taxonomy t5 ON t5.id = t.taxonomy5 
    WHERE ( t.deleted = '0000-00-00 00:00:00'
      OR  t.deleted IS NULL )
      AND t.owner = :owner
      AND t.offered = 1
    ORDER BY t.toolname -- t1, t2, t3, T4, t5 -- TODO: order the list meaningfully.
    ");
  $statement->bindValue(':owner', $owner);
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
} catch (PDOException $error) {
  showMessage(__LINE__, __FILE__, $sql . "<br>" . $error->getMessage());
}?>

<h2>View user profile || <a href="list.php">back to list</a></h2>

<table>
    <tr>
        <td><b>Username</b></td>
        <td><?php echo escape($user["username"]); ?></td>
    </tr>
    <tr>
        <td><b>Country</b></td>
        <td><?php echo escape($user["addr_country"]); ?></td>
    </tr>
    <tr>
        <td><b>Region</b></td>
        <td><?php echo escape($user["addr_region"]); ?></td>
    </tr>
    <tr>
        <td><b>ZIP</b></td>
        <td><?php echo escape($user["addr_zip"]); ?></td>
    </tr>
    <tr>
        <td><b>Public notes</b></td>
        <td><?php echo escape($user["publicnotes"]); ?></td>
    </tr>
</table>


<h3>Tools</h3>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
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
            <th>Taxonomy1</th>
            <th>Taxonomy2</th>
            <th>Taxonomy3</th>
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
                  <?php if (isset($_SESSION['currentusername'])
                      && $_SESSION['currentuserid'] != $_GET['id'] ) : ?>
                      <button class="button edit" type="submit" name="loan" value="<?php echo escape($row["id"]); ?>">Loan</button>
                  <?php endif; ?>
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
                          ? "waiting list"
                          : "available" )
                      : "not offered" )
                  ?></td>
                <td><?php echo escape($row["toolname"]); ?></td>
                <td><?php echo escape($row["brand"]); ?></td>
                <td><?php echo escape($row["model"]); ?></td>
                <td><?php echo escape($row["dimensions"]); ?></td>
                <td><?php echo escape($row["taxonomy1"])==0 ? '-' : escape($row["t1"]) ; ?></td>
                <td><?php echo escape($row["taxonomy2"])==0 ? '-' : escape($row["t2"]) ; ?></td>
                <td><?php echo escape($row["taxonomy3"])==0 ? '-' : escape($row["t3"]) ; ?></td>
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
