<?php
require "../common/common.php";
require "../common/header.php";

if (isset($_POST['submit'])) { // Action on SUBMIT:
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  { // create the record:
    $timestamp = date("Y-m-d H:i:s");
    $record =[
      "created"       => $timestamp,
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
    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "users",
      implode(", ", array_keys($record)),
      ":" . implode(", :", array_keys($record))
    );
    $statement = $connection->prepare($sql);
    $statement->execute($record);
  } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
}

// Action on LOAD:
try { // load foreign tables:
  // list of countries:
  $sql = "SELECT code, name FROM countries
      WHERE deleted = '0000-00-00 00:00:00'
      ORDER BY code";
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

//var_dump($countries);
//var_dump($regions);
?>

<h2>Add new user</h2>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote class="success">Successfully added <b><?php echo escape($_POST['username']); ?></b> to the <a href="list.php">member list</a>.</blockquote>
  <?php endif; ?>

<form method="post"><input class="submit" type="submit" name="submit" value="Submit">
  <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">

  <label class="label" for="username">User name<input class="input" type="text" name="username" id="username"></label>
  <label class="label" for="email">Email address<input class="input" type="text" name="email" id="email"></label>
  <label class="label" for="firstname">First name<input class="input" type="text" name="firstname" id="firstname"></label>
  <label class="label" for="lastname">Last name<input class="input" type="text" name="lastname" id="lastname"></label>
  <label class="label" for="phone">Phone number<input class="input" type="text" name="phone" id="phone"></label>
  <label class="label" for="addr_country">Country
  <select class="input" name="addr_country" id="addr_country">
    <?php foreach ($countries as $row) : ?>
      <option value="<?php echo escape($row["code"]); ?>">
        <?php echo ( escape($row["code"])=="0" 
          ? escape($row["name"]) 
          : escape($row["code"]) . "&nbsp;&nbsp;&nbsp;" . escape($row["name"]) ) ; ?>
      </option>
    <?php endforeach; ?>
  </select></label>
  <label class="label" for="addr_region">Region
  <select class="input" name="addr_region" id="addr_region">
    <?php foreach ($regions as $row) : ?>
      <option value="<?php echo escape($row["code"]); ?>">
        <?php echo ( escape($row["code"])=="0" 
          ? escape($row["name"]) . " " 
          : escape($row["code"]) . "&nbsp;&nbsp;&nbsp;" . escape($row["name"]) ) ; ?>
      </option>
    <?php endforeach; ?>
  </select></label>
  <label class="label" for="addr_zip">ZIP code<input class="input" type="text" name="addr_zip" id="addr_zip"></label>
  <label class="label" for="addr_city">City<input class="input" type="text" name="addr_city" id="addr_city"></label>
  <label class="label" for="addr_street">Street name<input class="input" type="text" name="addr_street" id="addr_street"></label>
  <label class="label" for="addr_number">House number<input class="input" type="text" name="addr_number" id="addr_number"></label>
  <label class="label" for="privatenotes">Private notes<input class="input" type="text" name="privatenotes" id="privatenotes"></label>
  <label class="label" for="publicnotes">Public notes<input class="input" type="text" name="publicnotes" id="publicnotes"></label>

  <input class="submit" type="submit" name="submit" value="Submit">
</form>

<?php require "../common/footer.php"; ?>
