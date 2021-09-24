<?php
require "../common/common.php";
require "../common/header.php";

if (isset($_GET['id'])) { // Action on LOAD:
  try { 
    // load the record:
    $id = $_GET['id'];
    $statement = $connection->prepare("
        SELECT l.*, t.toolname, u.username as lender, v.username as loanedto
        FROM loans l
        JOIN tools t ON t.id = l.tool
        JOIN users u ON u.id = l.owner
        JOIN users v ON v.id = l.loanedto
        WHERE l.id = :id
        ");
    $statement->bindValue(':id', $id);
    $statement->execute();
    $loan = $statement->fetch(PDO::FETCH_ASSOC);

    // load user list:
    $statement = $connection->prepare("
        SELECT username, id FROM users
        WHERE ( deleted = '0000-00-00 00:00:00' OR deleted IS NULL )
        ORDER BY username
        ");
    $statement->execute();
    $users = $statement->fetchAll();

  } catch(PDOException $error) { echo $sql . "<br>" . $error->getMessage(); }
} else { echo "Something went wrong!"; exit; }
?>

<h2>Edit a loan || <a href="/profile/loan-out.php">back to list</a> </h2>

<?php if (!isset($_SESSION['currentusername'])) : ?>
    <blockquote class="warning">You are not logged in. <a href="/profile/">Login</a> or <a href="/profile/login.php?action=registers">register!</a>
    </blockquote>
<?php elseif ( $_SESSION['currentuserid'] != escape($loan['owner']) ) : ?>
    <blockquote class="failure">This is not your tool!</blockquote>
<?php else : ?>

<form method="post" action="/profile/loan-out.php">
  <button class="button submit" type="submit" name="update" value="update">Save</button>
  <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">
  <input type="hidden" name="id" value="<?php echo escape($loan['id']); ?>">
  <input type="hidden" name="tool" id="tool" value="<?php echo escape($loan["tool"]); ?>">
  <input type="hidden" name="toolname" id="toolname" value="<?php echo escape($loan["toolname"]); ?>">
  <input type="hidden" name="owner" id="owner" value="<?php echo escape($loan["owner"]); ?>">

  <label class="label" for="active">Active<input class="input" type="checkbox" name="active" id="active" disabled
                                                 value="<?php echo(escape($loan["active"]) ? 1 : NULL) ?>"
                                                 <?php echo(escape($loan["active"]) ? "checked" : NULL) ?>>
	  <!--?php echo(escape($loan["active"]) ? "was checked" : "was unchecked") ?-->
  </label>
  <label class="label" for="tool">Tool
      <input class="input" readonly type="text" xname="tool" xid="tool" value="<?php echo escape($loan["toolname"]); ?>"></label>
  <label class="label" for="owner">Owner
      <input class="input" readonly type="text" xname="owner" xid="owner" value="<?php echo escape($loan["lender"]); ?>"></label>
  <label class="label" for="loanedto">Loaned to
      <input class="input" readonly type="text" name="loanedto" id="loanedto" value="<?php echo escape($loan["loanedto"]); ?>"></label>
  <label class="label" for="agreedstart">Agreed start
      <input class="input" type="text" name="agreedstart" id="agreedstart" value="<?php echo escape($loan["agreedstart"]); ?>" ></label>
  <label class="label" for="agreedend">Agreed end
      <input class="input" type="text" name="agreedend" id="agreedend" value="<?php echo escape($loan["agreedend"]); ?>" ></label>
  <label class="label" for="actualstart">Actual start
      <input class="input" type="text" name="actualstart" id="actualstart" value="<?php echo escape($loan["actualstart"]); ?>" ></label>
  <label class="label" for="actualend">Actual end
      <input class="input" type="text" name="actualend" id="actualend" value="<?php echo escape($loan["actualend"]); ?>" ></label>

  <button class="button submit" type="submit" name="update" value="update">Save</button>
</form>

<?php endif; ?>
<?php require "../common/footer.php"; ?>
