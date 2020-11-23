<?php
require "../common/common.php";
require "../common/header.php";

// Action on LOAD:
try { // load the tool:
  $tool_id     = $_GET['id'];
  $statement = $connection->prepare("
    SELECT DISTINCT t.*, u.id AS userid, u.username, t1.name AS t1, t2.name AS t2, t3.name AS t3, t4.name AS t4, t5.name AS t5, l.active
    FROM tools t
    JOIN users u ON u.id = t.owner
    LEFT JOIN loans l ON l.tool = t.id 
    			AND l.active = 1 AND ( l.deleted = '0000-00-00 00:00:00' OR l.deleted IS NULL )
    LEFT JOIN taxonomy t1 ON t1.id = t.taxonomy1 -- LEFT includes tools without a taxonomy.
    LEFT JOIN taxonomy t2 ON t2.id = t.taxonomy2 
    LEFT JOIN taxonomy t3 ON t3.id = t.taxonomy3 
    LEFT JOIN taxonomy t4 ON t4.id = t.taxonomy4 
    LEFT JOIN taxonomy t5 ON t5.id = t.taxonomy5 
    WHERE t.id = :tool_id
    ");
	$statement->bindValue(':tool_id', $tool_id);
	$statement->execute();
	$tool = $statement->fetchAll();

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
}
?>

<h2><a href="list.php">Tool Pool</a> || <?php echo escape($tool["toolname"]); /* TODO: why is this not shown? */ ?></h2>

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
          <th>Hydraulic</th>
          <th>Pneumatic</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ( $tool as $row) : ?>
      <tr>
          <td><?php // when current_user != tool_owner then show LOAN button
              if ( isset($_SESSION['currentusername'])
                  && escape($row["userid"]) != $_SESSION['currentuserid'] ) : ?>
              <form method="post" action="/profile/loan-in.php">
                  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
                  <button class="button edit" type="submit" name="loan" value="<?php echo escape($row["id"]); ?>">Loan</button>
              </form>
              <?php endif; ?>
              <?php // when current_user == tool_owner then show EDIT button
              if ( isset($_SESSION['currentusername'])
                  && escape($row["userid"]) == $_SESSION['currentuserid'] ) : ?>
                  <a href="/tools/edit.php?id=<?php echo escape($row["id"]); ?>">Edit</a>
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

<?php require "../common/footer.php"; ?>
