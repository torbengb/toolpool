<?php
require "../common/common.php";
require "../common/header.php";
?>

<h2>Add new loan</h2>

<?php
if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $timestamp = date("Y-m-d H:i:s");
    
    $new_loan = array(
      "created"     => $timestamp,
	  //"lastupdated" => '0000-00-00 00:00:00',
	  //"deleted"     => '0000-00-00 00:00:00',
      "active"      => $_POST['active'],
      "tool"        => $_POST['tool'],
      "owner"       => $_POST['owner'],
      "loanedto"    => $_POST['loanedto'],
      "agreedstart" => $_POST['agreedstart'],
      "agreedend"   => $_POST['agreedend'],
      "actualstart" => $_POST['actualstart'],
      "actualend"   => $_POST['actualend']
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "loans",
      implode(", ", array_keys($new_loan)),
      ":" . implode(", :", array_keys($new_loan))
    );
    $statement = $connection->prepare($sql);
    $statement->execute($new_loan);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote>Successfully added a loan to the <a href="list.php">loans list</a>.</blockquote>
  <?php endif; ?>

  <form method="post"><input class="submit" type="submit" name="submit" value="Submit">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">

    <label class="label" for="active"><input type="checkbox" name="active" id="active" value=1 checked>active</label>
    <label class="label" for="tool">tool<input type="text" name="tool" id="tool"></label>
    <label class="label" for="owner">owner<input type="text" name="owner" id="owner"></label>
    <label class="label" for="loanedto">loanedto<input type="text" name="loanedto" id="loanedto"></label>
    <label class="label" for="agreedstart">agreedstart<input type="text" name="agreedstart" id="agreedstart"></label>
    <label class="label" for="agreedend">agreedend<input type="text" name="agreedend" id="agreedend"></label>
    <label class="label" for="actualstart">actualstart<input type="text" name="actualstart" id="actualstart"></label>
    <label class="label" for="actualend">actualend<input type="text" name="actualend" id="actualend"></label>

    <input class="submit" type="submit" name="submit" value="Submit">
  </form>

<?php require "../common/footer.php"; ?>
