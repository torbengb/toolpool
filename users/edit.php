<?php
require "/common/config.php";
require "/common/common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $timestamp = date("Y-m-d H:i:s");
	
	$user =[
      "id"            => $_POST['id'],
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
      "publicnotes"   => $_POST['publicnotes'],
	  "lastupdated"   => $_POST['lastupdated']
    ];

    $sql = "UPDATE users 
            SET lastupdated = '$timestamp',
              id = :id,
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
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
  
if (isset($_GET['id'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    
    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote>Successfully updated <b><?php echo escape($_POST['username']); ?></b>'s user profile in the <a href="user-list.php">member list</a>.</blockquote>
<?php endif; ?>

<h2>Edit a user</h2>

<form method="post"><input class="submit" type="submit" name="submit" value="Submit">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">

    <label class="label" for="id">id<input type="text" name="id" id="id" value="<?php echo escape($tax["id"]); ?>"></label>
    <label class="label" for="created">created<input type="text" name="created" id="created" value="<?php echo escape($tax["created"]); ?>"></label>
    <label class="label" for="lastupdated">lastupdated<input type="text" name="lastupdated" id="lastupdated" value="<?php echo escape($tax["lastupdated"]); ?>"></label>
    <label class="label" for="deleted">deleted<input type="text" name="deleted" id="deleted" value="<?php echo escape($tax["deleted"]); ?>"></label>
    <label class="label" for="username">username<input type="text" name="username" id="username" value="<?php echo escape($tax["username"]); ?>"></label>
    <label class="label" for="email">email<input type="text" name="email" id="email" value="<?php echo escape($tax["email"]); ?>"></label>
    <label class="label" for="firstname">firstname<input type="text" name="firstname" id="firstname" value="<?php echo escape($tax["firstname"]); ?>"></label>
    <label class="label" for="lastname">lastname<input type="text" name="lastname" id="lastname" value="<?php echo escape($tax["lastname"]); ?>"></label>
    <label class="label" for="phone">phone<input type="text" name="phone" id="phone" value="<?php echo escape($tax["phone"]); ?>"></label>
    <label class="label" for="addr_country">addr_country<input type="text" name="addr_country" id="addr_country" value="<?php echo escape($tax["addr_country"]); ?>"></label>
    <label class="label" for="addr_region">addr_region<input type="text" name="addr_region" id="addr_region" value="<?php echo escape($tax["addr_region"]); ?>"></label>
    <label class="label" for="addr_city">addr_city<input type="text" name="addr_city" id="addr_city" value="<?php echo escape($tax["addr_city"]); ?>"></label>
    <label class="label" for="addr_zip">addr_zip<input type="text" name="addr_zip" id="addr_zip" value="<?php echo escape($tax["addr_zip"]); ?>"></label>
    <label class="label" for="addr_street">addr_street<input type="text" name="addr_street" id="addr_street" value="<?php echo escape($tax["addr_street"]); ?>"></label>
    <label class="label" for="addr_number">addr_number<input type="text" name="addr_number" id="addr_number" value="<?php echo escape($tax["addr_number"]); ?>"></label>
    <label class="label" for="privatenotes">privatenotes<input type="text" name="privatenotes" id="privatenotes" value="<?php echo escape($tax["privatenotes"]); ?>"></label>
    <label class="label" for="publicnotes">publicnotes<input type="text" name="publicnotes" id="publicnotes" value="<?php echo escape($tax["publicnotes"]); ?>"></label>

    <?php foreach ($user as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?>>
      </label>
    <?php endforeach; ?> 

    <input class="submit" type="submit" name="submit" value="Submit">
</form>

<?php require "../common/footer.php"; ?>
