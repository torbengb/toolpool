<?php
require "/common/config.php";
require "/common/common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * 
            FROM tools
            WHERE owner = :owner";

    $owner = $_POST['owner'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':owner', $owner, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>
        
<?php  
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Results</h2>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Created</th>
          <th>Last updated</th>
          <th>Owner</th>
          <th>Offered</th>
          <th>Loanedto</th>
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
        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["id"]); ?></td>
          <td><?php echo escape($row["created"]); ?></td>
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
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <blockquote>No results found for <?php echo escape($_POST['owner']); ?>.</blockquote>
    <?php } 
} ?> 

<h2>Find tool based on owner</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="owner">owner</label>
  <input type="text" id="owner" name="owner">
  <input class="submit" type="submit" name="submit" value="View Results">
</form>

<?php require "../common/footer.php"; ?>
