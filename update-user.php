<?php
require "config/config.php";
require "common.php";

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM users";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>
        
<h2>Update users</h2>

<table>
    <thead>
        <tr>
          <th>#</th>
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
          <th>Created</th>
          <th>Last updated</th>
          <th>Edit</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["id"]); ?></td>
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
          <td><?php echo escape($row["creation"]); ?> </td>
          <td><?php echo escape($row["lastupdated"]); ?> </td>
          <td><a href="update-user-single.php?id=<?php echo escape($row["id"]); ?>">Edit</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
