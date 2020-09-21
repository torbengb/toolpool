<?php
require "config/config.php";
require "common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $timestamp = date("Y-m-d H:i:s");
	
	$loan =[
      "id" => $_POST['id'],
      "created" => $_POST['created'],
      "lastupdated" => $_POST['lastupdated'],
      "deleted" => $_POST['deleted'],
      "active" => $_POST['active'],
      "tool" => $_POST['tool'],
      "owner" => $_POST['owner'],
      "loanedto" => $_POST['loanedto'],
      "agreedstart" => $_POST['agreedstart'],
      "agreedend" => $_POST['agreedend'],
      "actualstart" => $_POST['actualstart'],
      "actualend" => $_POST['actualend'],
    ];

    $sql = "UPDATE loans 
            SET id = :id, 
              created = :created,
              lastupdated = '$timestamp',
              deleted = :deleted,
              active = :active,
              tool = :tool,
              owner = :owner,
              loanedto = :loanedto,
              agreedstart = :agreedstart,
              agreedend = :agreedend,
              actualstart = :actualstart,
              actualend = :actualend
            WHERE id = :id";
  
  $statement = $connection->prepare($sql);
  $statement->execute($loan);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
  
if (isset($_GET['id'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['id'];

    $sql = "SELECT * FROM loans WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    
    $loan = $statement->fetch(PDO::FETCH_ASSOC);
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
    <blockquote>Successfully updated the loan in the <a href="loan-list.php">loan list</a>.</blockquote>
<?php endif; ?>

<h2>Edit a loan</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <?php foreach ($loan as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?>>
    <?php endforeach; ?> 
    <input type="submit" name="submit" value="Submit">
</form>

<?php require "templates/footer.php"; ?>
