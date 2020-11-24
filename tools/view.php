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

<h2><a href="list.php">Tool Pool</a> || <?php echo escape($tool["toolname"]); ?></h2>

<ul>
    <li><a href="/users/view.php?id=<?php echo escape($tool["userid"]); ?>"><?php echo escape($tool["username"]); ?></a></li>
    <li><?php echo(escape($tool["offered"]) ? "offered" : "not offered") ?></li>
    <li><?php echo escape($tool["toolname"]); ?></li>
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

<?php require "../common/footer.php"; ?>
