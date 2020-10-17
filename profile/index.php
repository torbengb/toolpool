<?php
require "../common/common.php";
require "../common/header.php";

if (isset($_POST['create'])) { // Action on SUBMIT:
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
  } catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
}

if (isset($_POST['update'])) { // Action on SUBMIT:
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
    $statement = $connection->prepare("
        UPDATE users 
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
            WHERE id = :id
        ");
    $statement->execute($record);
  } catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
}

if (isset($_POST["delete"])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try { // Action on SUBMIT:
    $timestamp = date("Y-m-d H:i:s");
    $id = $_SESSION['currentuserid'];
    $statement = $connection->prepare("UPDATE users  SET deleted = '$timestamp' WHERE id = :id");
    $statement->bindValue(':id', $id);
    $statement->execute();
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();
  } catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
}

$userid = $_SESSION['currentuserid'];
$statement = $connection->prepare("
                SELECT 'You are offering', COUNT(*) AS count FROM tools WHERE owner=:userid AND ( deleted = '0000-00-00 00:00:00' OR  deleted IS NULL ) AND offered=1
                UNION 
                SELECT 'You are lending',  COUNT(*) AS count FROM loans WHERE owner=:userid AND ( deleted = '0000-00-00 00:00:00' OR  deleted IS NULL ) AND active=1
                UNION 
                SELECT 'Past lending',     COUNT(*) AS count FROM loans WHERE owner=:userid AND ( deleted = '0000-00-00 00:00:00' OR  deleted IS NULL ) AND active=0
                UNION 
                SELECT 'You are loaning',  COUNT(*) AS count FROM loans WHERE loanedto=:userid AND ( deleted = '0000-00-00 00:00:00' OR  deleted IS NULL ) AND active=1
            ");
$statement->bindValue('userid', $userid);
$statement->execute();
$stats = $statement->fetchAll();
$numoffers=$stats[0][1][0];
$numlends =$stats[1][1][0];
$numlendspast =$stats[2][1][0];
$numloans =$stats[3][1][0];
?>

<?php if (isset($_SESSION['currentusername'])) : ?>
    <h2><?php echo escape($_SESSION['currentusername']); ?> || My profile || <a href="profile-edit.php">edit</a></h2>

    <form method="post">
        <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">
        <button style="float: right;" class="button submit" type="submit" name="delete" value="<?php echo escape($row["id"]); ?>">Delete this account</button>
    </form>

    <form method="post" action="/index.php">
        <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">
        <button style="float: right;" class="button submit" type="submit" name="logout" value="logout">Log out!</button>
    </form>
    <?php if (isset($_POST['update']) && $statement) : ?>
        <blockquote class="success">Successfully updated your user profile.</blockquote>
    <?php endif; ?>
    <p> You are <a href="/profile/tool-list.php">offering <span style="font-size: 200%"><?php echo $numoffers; ?></span></a> tools. <a href="tool-new.php">Add another!</a><br>
        You are <a href="/profile/loan-out.php" >lending  <span style="font-size: 200%"><?php echo $numlends;  ?></span></a> tools to others,
        plus <span style="font-size: 200%"><?php echo $numlendspast; ?></span> in the <a href="/profile/loan-out-history.php">past</a>.
            <?php
            if     ($numlends + $numlendspast > 5) echo "Great job!";
            elseif ($numlends + $numlendspast > 0) echo "Good start!";
            elseif ($numlends + $numlendspast = 0) echo "That's okay.";
            ?><br>
        You are <a href="/profile/loan-in.php"  >loaning  <span style="font-size: 200%"><?php echo $numloans;  ?></span></a> tools from others.<br>
    </p>
    <hr />
<?php else : ?>
    <?php if (isset($_POST['create']) && $statement) : ?>
        <blockquote class="success">Successfully registered your username <b><?php echo escape($_POST['username']); ?></b>! Now you can <a href="/profile/">log in</a>.</blockquote>
    <?php endif; ?>
    <?php if (isset($_POST['delete']) && $statement) : ?>
        <blockquote class="success">Successfully deleted your profile!</blockquote>
    <?php endif; ?>
    <a href="/profile/">Login</a> or <a href="/users/new.php">register!</a>
<?php endif; ?>

<?php require "../common/footer.php"; ?>
