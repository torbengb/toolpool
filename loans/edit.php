<?php
require "../common/common.php";
require "../common/header.php";
?>

<h2>Edit a loan</h2>

<?php
// Action on SUBMIT:
if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
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
  
// Action on LOAD:
if (isset($_GET['id'])) {
  try {
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

<?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote>Successfully updated the loan in the <a href="list.php">loan list</a>.</blockquote>
<?php endif; ?>

<form method="post"><input class="submit" type="submit" name="submit" value="Submit">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">

          <label for="id">Id	    <input type="text" name="id" id="id" value="<?php echo escape($loan["id"]); ?>" readonly></label>
          <label for="active">Active	    <input type="text" name="active" id="active" value="<?php echo escape($loan["active"]); ?>" ></label>
          <label for="tool">Tool	    <input type="text" name="tool" id="tool" value="6" ></label>
          <label for="owner">Owner	    <input type="text" name="owner" id="owner" value="8" ></label>
          <label for="loanedto">Loanedto	    <input type="text" name="loanedto" id="loanedto" value="3" ></label>
          <label for="agreedstart">Agreedstart	    <input type="text" name="agreedstart" id="agreedstart" value="0000-00-00" ></label>
          <label for="agreedend">Agreedend	    <input type="text" name="agreedend" id="agreedend" value="0000-00-00" ></label>
          <label for="actualstart">Actualstart	    <input type="text" name="actualstart" id="actualstart" value="0000-00-00" ></label>
          <label for="actualend">Actualend	    <input type="text" name="actualend" id="actualend" value="0000-00-00" ></label>

    <input class="submit" type="submit" name="submit" value="Submit">
</form>

<?php require "../common/footer.php"; ?>
