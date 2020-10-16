<?php
if ($_SESSION['debug']) echo __FILE__."<br>";
require "../common/common.php";
if ($_SESSION['debug']) echo __FILE__."<br>";
require "../common/header.php";
if ($_SESSION['debug']) echo __FILE__."<br>";

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

?>

<?php if (isset($_SESSION['currentusername'])) : ?>
    <h2><a href="index.php"><?php echo escape($_SESSION['currentusername']); ?></a> || My profile || <a href="profile-edit.php">edit</a></h2>

    <div style="float:right;background-color:#eee;sborder:3px double black;xpadding:1em;margin:1em;">
        <?php
        $userid = $_SESSION['currentuserid'];
            $statement = $connection->prepare("
                SELECT 'Your are offering', COUNT(*) AS count FROM tools WHERE owner=:userid AND ( deleted = '0000-00-00 00:00:00' OR  deleted IS NULL ) AND offered=1
                UNION 
                SELECT 'You are lending',   COUNT(*) AS count FROM loans WHERE owner=:userid AND ( deleted = '0000-00-00 00:00:00' OR  deleted IS NULL ) AND active=1
                UNION 
                SELECT 'You are loaning',   COUNT(*) AS count FROM loans WHERE loanedto=:userid AND ( deleted = '0000-00-00 00:00:00' OR  deleted IS NULL ) AND active=1
            ");
            $statement->bindValue('userid', $userid);
            $statement->execute();
            $stats = $statement->fetchAll();
        ?>
        <table>
            <tr>
                <th colspan=2 align="center">Statistics</th>
            </tr>
          <?php foreach ($stats as $row) : ?>
              <tr>
                  <td><?php echo $row["0"]; ?></td>
                  <td><?php echo $row["count"]; ?></td>
              </tr>
          <?php endforeach; ?>
        </table>
    </div>

    <form method="post">
        <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">
        <button class="button submit" type="submit" name="logout" value="logout">Log out!</button>
    </form><br>
    <?php if (isset($_POST['update']) && $statement) : ?>
        <blockquote class="success">Successfully updated your user profile.</blockquote>
    <?php endif; ?>
    <div><a href="tool-list.php">My tools</a></div>
    <hr />
<?php endif; ?>

<form method="post">
    <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">
    <input type="hidden" name="id" value="<?php echo escape($user['id']); ?>">
    <label class="label" for="user"><span class="labeltext">select user:</span>
        <select class="input" name="user" id="user">
          <?php foreach ($users as $row) : ?>
              <option
                      name="user"
                      id="user"
                      value="<?php echo escape($row['id']); ?>"
                  <?php echo(escape($row["id"]) == escape($_SESSION["currentuserid"]) ? "selected='selected'" : NULL) ?>
              ><?php echo escape($row['username']); ?></option>
          <?php endforeach; ?>
        </select>
    </label>
    <button class="button submit" type="submit" name="login" value="login">Switch!</button>
</form>

<?php require "../common/footer.php"; ?>
