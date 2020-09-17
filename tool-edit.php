<?php
require "config/config.php";
require "common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $timestamp = date("Y-m-d H:i:s");

    $tool =[
      "id" => $_POST['id'],
      "owner" => $_POST['owner'],
      "offered" => $_POST['offered'],
      "toolname" => $_POST['toolname'],
      "brand" => $_POST['brand'],
      "model" => $_POST['model'],
      "dimensions" => $_POST['dimensions'],
      "weight" => $_POST['weight'],
      "privatenotes" => $_POST['privatenotes'],
      "publicnotes" => $_POST['publicnotes'],
      "taxonomy1" => $_POST['taxonomy1'],
      "taxonomy2" => $_POST['taxonomy2'],
      "taxonomy3" => $_POST['taxonomy3'],
      "taxonomy4" => $_POST['taxonomy4'],
      "taxonomy5" => $_POST['taxonomy5'],
      "electrical230v" => $_POST['electrical230v'],
      "electrical400v" => $_POST['electrical400v'],
      "hydraulic" => $_POST['hydraulic'],
      "pneumatic" => $_POST['pneumatic'],
      "lastupdated"   => $_POST['lastupdated']
    ];

    $sql = "UPDATE tools 
            SET id = :id, 
              owner = :owner,
              offered = :offered,
              toolname = :toolname,
              brand = :brand,
              model = :model,
              dimensions = :dimensions,
              weight = :weight,
              privatenotes = :privatenotes,
              publicnotes = :publicnotes,
              taxonomy1 = :taxonomy1,
              taxonomy2 = :taxonomy2,
              taxonomy3 = :taxonomy3,
              taxonomy4 = :taxonomy4,
              taxonomy5 = :taxonomy5,
              electrical230v = :electrical230v,
              electrical400v = :electrical400v,
              hydraulic = :hydraulic,
              pneumatic = :pneumatic,
              lastupdated = '$timestamp'
            WHERE id = :id";
  
  $statement = $connection->prepare($sql);
  $statement->execute($tool);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
  
if (isset($_GET['id'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['id'];

    $sql = "SELECT * FROM tools WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    
    $tool = $statement->fetch(PDO::FETCH_ASSOC);
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
    <blockquote>Successfully updated tool <b><?php echo escape($_POST['toolname']); ?></>.</blockquote>
<?php endif; ?>

<h2>Edit a tool</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <?php foreach ($tool as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?>>
    <?php endforeach; ?> 
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
