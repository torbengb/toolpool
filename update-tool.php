<?php
require "config/config.php";
require "common.php";

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM tools";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>
        
<h2>Update tools</h2>

<table>
    <thead>
        <tr>
          <th>Action</th>
          <th>ID</th>
          <th>Last updated</th>
          <th>Owner</th>
          <th>Offered</th>
          <th>Toolname</th>
          <th>Brand</th>
          <th>Model</th>
          <th>Dimensions</th>
          <th>Weight</th>
          <th>Privatenotes</th>
          <th>Publicnotes</th>
          <th>Taxonomy1</th>
          <th>Taxonomy2</th>
          <th>Taxonomy3</th>
          <th>Taxonomy4</th>
          <th>Taxonomy5</th>
          <th>Electrical230v</th>
          <th>Electrical400v</th>
          <th>Hydraulic</th>
          <th>Pneumatic</th>
          <th>Created</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
        <tr>
          <td><a href="update-tool-single.php?id=<?php echo escape($row["id"]); ?>">Edit</a></td>
          <td><?php echo escape($row["id"]); ?></td>
          <td><?php echo escape($row["lastupdated"]); ?></td>
          <td><?php echo escape($row["owner"]); ?></td>
          <td><?php echo escape($row["offered"]); ?></td>
          <td><?php echo escape($row["toolname"]); ?></td>
          <td><?php echo escape($row["brand"]); ?></td>
          <td><?php echo escape($row["model"]); ?></td>
          <td><?php echo escape($row["dimensions"]); ?></td>
          <td><?php echo escape($row["weight"]); ?></td>
          <td><?php echo escape($row["privatenotes"]); ?></td>
          <td><?php echo escape($row["publicnotes"]); ?></td>
          <td><?php echo escape($row["taxonomy1"]); ?></td>
          <td><?php echo escape($row["taxonomy2"]); ?></td>
          <td><?php echo escape($row["taxonomy3"]); ?></td>
          <td><?php echo escape($row["taxonomy4"]); ?></td>
          <td><?php echo escape($row["taxonomy5"]); ?></td>
          <td><?php echo escape($row["electrical230v"]); ?></td>
          <td><?php echo escape($row["electrical400v"]); ?></td>
          <td><?php echo escape($row["hydraulic"]); ?></td>
          <td><?php echo escape($row["pneumatic"]); ?></td>
          <td><?php echo escape($row["created"]); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
