<?php
require "../common/common.php";
require "../common/header.php";

if (isset($_GET['id'])) { // Action on LOAD:
	try { // load the record
        $tool_id   = $_GET['id'];
        $statement = $connection->prepare("
            SELECT DISTINCT t.*, u.id AS userid, u.username, t1.name AS t1, t2.name AS t2, t3.name AS t3, t4.name AS t4, t5.name AS t5, l.active
            FROM tools t
            JOIN users u ON u.id = t.owner
            LEFT JOIN loans l ON l.tool = t.id AND l.active = 1 AND ( l.deleted = '0000-00-00 00:00:00' OR l.deleted IS NULL )
            LEFT JOIN taxonomy t1 ON t1.id = t.taxonomy1 -- LEFT includes tools without a taxonomy.
            LEFT JOIN taxonomy t2 ON t2.id = t.taxonomy2 
            LEFT JOIN taxonomy t3 ON t3.id = t.taxonomy3 
            LEFT JOIN taxonomy t4 ON t4.id = t.taxonomy4 
            LEFT JOIN taxonomy t5 ON t5.id = t.taxonomy5 
            WHERE t.id = :tool_id
            ");
			$statement->bindValue(':tool_id', $tool_id);
			$statement->execute();
			$tool = $statement->fetch(PDO::FETCH_ASSOC);
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
} else {
	echo "Error " . __LINE__ . ": No tool was specified!" . "<br>";
	exit;
}
?>

<h2><a href="list.php">Tool Pool</a> || <?php echo escape($tool["toolname"]); ?>
	<?php if (isset($_SESSION['currentusername']) && escape($tool["userid"]) == $_SESSION['currentuserid']) : ?>
        || <a href="edit.php?id=<?php echo escape($tool_id); ?>">edit</a>
    <?php endif; ?>
</h2>

<div style="float:right"><img
    src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=http%3A%2F%2F<?php
    if ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ) {$protocol = "https";}
    else {$protocol = "http";}
    $domain         = $_SERVER['HTTP_HOST'];
    $resource       = $_SERVER['REQUEST_URI'];
    $siteurl        = $protocol . "://" . $domain;
    $pageurl        = $siteurl . $resource;
    $pageurlencoded = urlencode($pageurl);
    echo urlencode($pageurlencoded) ?>&choe=UTF-8" title="QR code with link to this page"/>
</div>

<div><h3>Tool details</h3>
<ul>
    <li><?php echo escape($tool["toolname"]); ?></li>
    <li><?php echo escape($tool["username"]); ?></li>
    <li><?php echo(escape($tool["offered"]) ? "offered" : "not offered") ?></li>
    <li><?php echo escape($tool["brand"]); ?></li>
    <li><?php echo escape($tool["model"]); ?></li>
    <li><?php echo escape($tool["weight"]); ?></li>
    <li><?php echo escape($tool["dimensions"]); ?></li>
    <li><?php echo escape($tool["privatenotes"]); ?></li>
    <li><?php echo escape($tool["publicnotes"]); ?></li>
    <li><?php echo escape($tool["t1"]); ?></li>
    <li><?php echo escape($tool["t2"]); ?></li>
    <li><?php echo escape($tool["t3"]); ?></li>
    <li><?php echo escape($tool["t4"]); ?></li>
    <li><?php echo escape($tool["t5"]); ?></li>
    <li><?php echo(escape($tool["electrical230v"]) ? "230V" : NULL) ?></li>
    <li><?php echo(escape($tool["electrical400v"]) ? "400V" : NULL) ?></li>
    <li><?php echo(escape($tool["hydraulic"]) ? "hydr" : NULL) ?></li>
    <li><?php echo(escape($tool["pneumatic"]) ? "pneu" : NULL) ?></li>
</ul>
</div>

<h3>Lending history</h3>

<?php
$numlends  = 0;
try { // load the record
	$statement = $connection->prepare("
            SELECT count(l.id) as count
            FROM loans l 
            WHERE l.tool = :tool_id
            AND ( l.deleted = '0000-00-00 00:00:00' OR l.deleted IS NULL )
            ");
	$statement->bindValue(':tool_id', $tool_id);
	$statement->execute();
	$statement = $statement->fetchAll();
} catch (PDOException $error)
{ echo $sql . "<br>" . $error->getMessage();
}
    $numlends  = $statement[0][0][0];
    if ( $numlends == 1 ) {
        $times = " time";
    }
    else {
        $times = " times";
    }

if ( isset($_SESSION['currentusername']) && escape($tool["userid"]) == $_SESSION['currentuserid'] && $numlends > 0 ) :
	try { // load the record
		$connection = new PDO($dsn, $username, $password, $options);
		$sql        = "USE " . $dbname;
		$connection->exec($sql);
		$statement = $connection->prepare("
        SELECT l.*, u.username AS lender
        FROM loans l
		JOIN users u ON u.id = l.loanedto
        WHERE ( l.deleted = '0000-00-00 00:00:00' OR l.deleted IS NULL )
        AND l.tool = $tool_id
		ORDER BY l.agreedstart DESC
		");
		$statement->execute();
		$result = $statement->fetchAll();
	} catch (PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}
	?>
    You have lent this tool <?php echo $numlends . $times; ?> so far:
    <table>
        <thead>
        <tr>
            <th>Action</th>
            <th>Active</th>
            <th>Loaned to</th>
            <th>Created</th>
            <th>Agreed start</th>
            <th>Agreed end</th>
            <th>Actual start</th>
            <th>Actual end</th>
        </tr>
        </thead>
        <tbody>
				<?php foreach ( $result as $row ) : ?>
            <tr>
                <td><?php if ( escape($row["active"]) == 1 ) : ?>
                        <form method="post">
                            <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
                            <a href="/loans/edit.php?id=<?php echo escape($row["id"]); ?>">Edit</a>
                        </form>
									<?php endif; ?>
                </td>
                <td><?php echo(escape($row["active"]) ? "active" : "-"); ?></td>
                <td><a href="/users/view.php?id=<?php echo escape($row["userid"]); ?>">
										<?php echo escape($row["lender"]); ?></a>
                </td>
                <td><?php echo escape($row["created"]); ?></td>
                <td><?php echo escape($row["agreedstart"]); ?></td>
                <td><?php echo escape($row["agreedend"]); ?></td>
                <td><?php echo escape($row["actualstart"]); ?></td>
                <td><?php echo escape($row["actualend"]); ?></td>
            </tr>
				<?php endforeach; ?>
        </tbody>
    </table><br/>

<?php elseif ( isset($_SESSION['currentusername']) && $numlends > 0 ) :
	try { // load the record
		$connection = new PDO($dsn, $username, $password, $options);
		$sql        = "USE " . $dbname;
		$connection->exec($sql);
		$loanedto2 = $_SESSION['currentuserid'];
		$statement = $connection->prepare("
        SELECT l.*
        FROM loans l
		WHERE ( l.deleted = '0000-00-00 00:00:00' OR l.deleted IS NULL )
        AND l.tool = $tool_id
        AND l.loanedto = $loanedto2
		ORDER BY l.agreedstart DESC
		");
		$statement->execute();
		$result = $statement->fetchAll();
	} catch (PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}
	?>
    <table>
        <thead>
        <tr>
            <th>Active</th>
            <th>Created</th>
            <th>Agreed start</th>
            <th>Agreed end</th>
            <th>Actual start</th>
            <th>Actual end</th>
        </tr>
        </thead>
        <tbody>
				<?php foreach ( $result as $row ) : ?>
            <tr>
                <td><?php echo(escape($row["active"]) ? "active" : "-"); ?></td>
                <td><?php echo escape($row["created"]); ?></td>
                <td><?php echo escape($row["agreedstart"]); ?></td>
                <td><?php echo escape($row["agreedend"]); ?></td>
                <td><?php echo escape($row["actualstart"]); ?></td>
                <td><?php echo escape($row["actualend"]); ?></td>
            </tr>
				<?php endforeach; ?>
        </tbody>
    </table><br/>

<?php else : ?>
    <div>This tool has been lent <?php echo $numlends . $times; ?> so far.</div>
<?php endif ?>

<?php require "../common/footer.php"; ?>
