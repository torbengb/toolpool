<?php
require "../common/common.php";
require "../common/header.php";
?>

<h2>Edit a tool</h2>

<?php
if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
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
            SET lastupdated = '$timestamp',
              id = :id, 
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
              pneumatic = :pneumatic
            WHERE id = :id";
  $statement = $connection->prepare($sql);
  $statement->execute($tool);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
  
if (isset($_GET['id'])) {
  try {
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

<?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote>Successfully updated your <b><?php echo escape($_POST['toolname']); ?></b> in the <a href="list.php">tool pool</a>.</blockquote>
<?php endif; ?>

<form method="post"><input class="submit" type="submit" name="submit" value="Submit">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <?php foreach ($tool as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?>>
    <?php endforeach; ?> 
    <input class="submit" type="submit" name="submit" value="Submit">
</form>

<?php require "../common/footer.php"; ?>
