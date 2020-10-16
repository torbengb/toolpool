<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TOOL||POOL</title>

    <link rel="stylesheet" href="/common/style.css">
</head>

<body>
<div class="header">
    <h1 class="sitename"><a href="/index.php">TOOL||POOL</a> on <?php echo $_SERVER['HTTP_HOST']; ?></h1>
    <div class="navbar">
        <div class="topics">
            || <a href="/index.php"><strong>Home</strong></a>
            || <a href="/tools/list.php"><strong>Tools</strong></a>
            || <a href="/users/list.php"><strong>Members</strong></a>
            || <a href="/loans/list.php"><strong>Loans</strong></a>
            || <a href="/taxonomy/list.php"><strong>Taxonomy</strong></a>
            || <?php echo "Hello " . escape($_SESSION['currentusername']); ?>


            <form method="post" xaction="login.php">
                <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">
                <input type="hidden" name="id" value="<?php echo escape($user['id']); ?>">

                <label class="label" for="user"><span class="labeltext">Switch to user:</span>
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

                <button class="button submit" type="submit" name="login" value="login">Login</button>
            </form>


        </div>
    </div>
</div>
<div class="mainbody">
