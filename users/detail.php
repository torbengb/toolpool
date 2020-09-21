<?php
require "/common/config.php";
require "/common/common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * 
            FROM users
            WHERE username = :username";

    $username = $_POST['username'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
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
          <th>User name</th>
          <th>Email</th>
          <th>First name</th>
          <th>Last name</th>
          <th>Phone</th>
          <th>Country</th>
          <th>Region</th>
          <th>City</th>
          <th>Postal code</th>
          <th>Street</th>
          <th>House number</th>
          <th>Private notes</th>
          <th>Public notes</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["id"]); ?></td>
          <td><?php echo escape($row["created"]); ?> </td>
          <td><?php echo escape($row["lastupdated"]); ?> </td>
          <td><?php echo escape($row["username"]); ?></td>
          <td><?php echo escape($row["email"]); ?></td>
          <td><?php echo escape($row["firstname"]); ?></td>
          <td><?php echo escape($row["lastname"]); ?></td>
          <td><?php echo escape($row["phone"]); ?></td>
          <td><?php echo escape($row["addr_country"]); ?></td>
          <td><?php echo escape($row["addr_region"]); ?></td>
          <td><?php echo escape($row["addr_city"]); ?></td>
          <td><?php echo escape($row["addr_zip"]); ?></td>
          <td><?php echo escape($row["addr_street"]); ?></td>
          <td><?php echo escape($row["addr_number"]); ?></td>
          <td><?php echo escape($row["privatenotes"]); ?></td>
          <td><?php echo escape($row["publicnotes"]); ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <blockquote>No results found for user <b><?php echo escape($_POST['username']); ?></b>.</blockquote>
    <?php } 
} ?> 

<h2>Find username</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="username">User name</label>
  <input type="text" id="username" name="username">
  <input class="submit" type="submit" name="submit" value="View Results">
</form>

<?php require "../common/footer.php"; ?>
