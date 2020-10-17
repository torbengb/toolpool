<?php
require "../common/common.php";
require "../common/header.php";

// Action on LOAD:
try { // load foreign tables:
  // list of countries:
  $statement = $connection->prepare("
        SELECT code, name FROM countries
        WHERE ( deleted = '0000-00-00 00:00:00' OR deleted IS NULL )
        ORDER BY code
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
} catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }

//var_dump($countries);
//var_dump($regions);
?>

<h2>Register || <a href="list.php">back to list</a></h2>

<div><a href="/profile/">Login instead?</a></div>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote class="success">Successfully added <b><?php echo escape($_POST['username']); ?></b> to the <a href="list.php">member list</a>.</blockquote>
  <?php endif; ?>

<form method="post" action="/profile/index.php">
  <button class="button submit" type="submit" name="create" value="create">Register</button>
  <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">

    <label class="label" for="username">User name<input class="input" type="text" name="username" id="username"> <span class="formhint">This is the only name we will show other users.</span> </label>
    <label class="label" for="email">Email address<input class="input" type="text" name="email" id="email"> <span class="formhint">We use this to validate your account, and to send you information about loans and requests.</span> </label>
    <label class="label" for="firstname">First name<input class="input" type="text" name="firstname" id="firstname"> <span class="formhint">Not presently used.</span> </label>
    <label class="label" for="lastname">Last name<input class="input" type="text" name="lastname" id="lastname"> <span class="formhint">Not presently used.</span> </label>
    <label class="label" for="phone">Phone number<input class="input" type="text" name="phone" id="phone"> <span class="formhint">Not presently used, but may be used for SMS notifications later.</span> </label>
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
  </select> <span class="formhint">We use country and region to help you find tools in your proximity.</span> </label>
  <label class="label" for="addr_zip">ZIP code<input class="input" type="text" name="addr_zip" id="addr_zip"> <span class="formhint">Not presently used.</span> </label>
  <label class="label" for="addr_city">City<input class="input" type="text" name="addr_city" id="addr_city"> <span class="formhint">Not presently used.</span> </label>
  <label class="label" for="addr_street">Street name<input class="input" type="text" name="addr_street" id="addr_street"> <span class="formhint">Not presently used.</span> </label>
  <label class="label" for="addr_number">House number<input class="input" type="text" name="addr_number" id="addr_number"> <span class="formhint">Not presently used.</span> </label>
  <label class="label" for="privatenotes">Private notes<input class="input" type="text" name="privatenotes" id="privatenotes"> <span class="formhint">Only you cam see these notes.</span> </label>
  <label class="label" for="publicnotes">Public notes<input class="input" type="text" name="publicnotes" id="publicnotes"> <span class="formhint">Is there anything you want to say to others?</span> </label>

  <button class="button submit" type="submit" name="create" value="create">Register</button>
</form>

<?php require "../common/footer.php"; ?>
