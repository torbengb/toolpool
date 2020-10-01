<?php
require "../common/common.php";
require "../common/header.php";

if (isset($_POST['submit'])) { // Action on SUBMIT:
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try { // update the record:
    $timestamp = date("Y-m-d H:i:s");
    $record =[
      "id"            => $_POST['id'],
      "modified"   => $timestamp,
      "username"      => $_POST['username'],
      "email"         => $_POST['email'],
      "firstname"     => $_POST['firstname'],
      "lastname"      => $_POST['lastname'],
      "phone"         => $_POST['phone'],
      "addr_country"  => $_POST['addr_country'],
      "addr_region"   => $_POST['addr_region'],
      "addr_city"     => $_POST['addr_city'],
      "addr_zip"      => $_POST['addr_zip'],
      "addr_street"   => $_POST['addr_street'],
      "addr_number"   => $_POST['addr_number'],
      "privatenotes"  => $_POST['privatenotes'],
      "publicnotes"   => $_POST['publicnotes']
    ];
    $sql = "UPDATE users 
            SET modified = :modified,
              username = :username,
              email = :email,
              firstname = :firstname,
              lastname = :lastname,
              phone = :phone,
              addr_country = :addr_country,
              addr_region = :addr_region,
              addr_city = :addr_city,
              addr_zip = :addr_zip,
              addr_street = :addr_street,
              addr_number = :addr_number,
              privatenotes = :privatenotes,
              publicnotes = :publicnotes
            WHERE id = :id";
  $statement = $connection->prepare($sql);
    $statement->execute($record);
  } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
}
  
if (isset($_GET['id'])) { // Action on LOAD:
  try { // load the record
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // list of countries:
    $sql = "SELECT code, name FROM countries
        WHERE deleted = '0000-00-00 00:00:00'
        ORDER BY name";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $countries = $statement->fetchAll();
    // list for regions:
    $sql = "SELECT code, name FROM regions
        WHERE deleted = '0000-00-00 00:00:00'
        ORDER BY code";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $regions = $statement->fetchAll();

  } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<h2>Edit a user</h2>

<?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote class="success">Successfully updated <b><?php echo escape($_POST['username']); ?></b>'s user profile in the <a href="list.php">member list</a>.</blockquote>
<?php endif; ?>

<form method="post"><input class="submit" type="submit" name="submit" value="Submit">
  <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">
  <input type="hidden" name="id" value="<?php echo escape($user['id']); ?>">

  <label class="label" for="username">username<input class="input" type="text" name="username" id="username" value="<?php echo escape($user["username"]); ?>"></label>
  <label class="label" for="email">email<input class="input" type="text" name="email" id="email" value="<?php echo escape($user["email"]); ?>"></label>
  <label class="label" for="firstname">firstname<input class="input" type="text" name="firstname" id="firstname" value="<?php echo escape($user["firstname"]); ?>"></label>
  <label class="label" for="lastname">lastname<input class="input" type="text" name="lastname" id="lastname" value="<?php echo escape($user["lastname"]); ?>"></label>
  <label class="label" for="phone">phone<input class="input" type="text" name="phone" id="phone" value="<?php echo escape($user["phone"]); ?>"></label>
  <label class="label" for="addr_country">Country
  <select class="input" name="addr_country" id="addr_country">
    <?php foreach ($countries as $row) : ?>
      <option value="<?php echo escape($row["code"]); ?>"
        <?php echo ( escape($row["code"]) == escape($user["addr_country"]) ? "selected='selected'" : NULL ) ?>
      > <?php echo ( escape($row["code"])=="0" 
          ? escape($row["name"]) 
          : escape($row["code"]) . "&nbsp;&nbsp;&nbsp;" . escape($row["name"]) ) ; ?>
      </option>
    <?php endforeach; ?>
  </select></label>
  <label class="label" for="addr_region">Region
  <select class="input" name="addr_region" id="addr_region">
    <?php foreach ($regions as $row) : ?>
      <option value="<?php echo escape($row["code"]); ?>"
        <?php echo ( escape($row["code"]) == escape($user["addr_region"]) ? "selected='selected'" : NULL ) ?>
      > <?php echo ( escape($row["code"])=="0" 
          ? escape($row["name"]) 
          : escape($row["code"]) . "&nbsp;&nbsp;&nbsp;" . escape($row["name"]) ) ; ?>
      </option>
    <?php endforeach; ?>
  </select></label>
  <label class="label" for="addr_zip">addr_zip<input class="input" type="text" name="addr_zip" id="addr_zip" value="<?php echo escape($user["addr_zip"]); ?>"></label>
  <label class="label" for="addr_city">addr_city<input class="input" type="text" name="addr_city" id="addr_city" value="<?php echo escape($user["addr_city"]); ?>"></label>
  <label class="label" for="addr_street">addr_street<input class="input" type="text" name="addr_street" id="addr_street" value="<?php echo escape($user["addr_street"]); ?>"></label>
  <label class="label" for="addr_number">addr_number<input class="input" type="text" name="addr_number" id="addr_number" value="<?php echo escape($user["addr_number"]); ?>"></label>
  <label class="label" for="privatenotes">privatenotes<input class="input" type="text" name="privatenotes" id="privatenotes" value="<?php echo escape($user["privatenotes"]); ?>"></label>
  <label class="label" for="publicnotes">publicnotes<input class="input" type="text" name="publicnotes" id="publicnotes" value="<?php echo escape($user["publicnotes"]); ?>"></label>

  <input class="submit" type="submit" name="submit" value="Submit">
</form>

<?php require "../common/footer.php"; ?>
