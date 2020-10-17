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
    <h1 class="sitename">TOOL||POOL</h1>
    <div class="navbar">
        <div class="topics">
            || <a href="/index.php"><strong>Home</strong></a>
            || <a href="/tools/list.php"><strong>Tools</strong></a>
            || <a href="/profile"><strong>My account</strong></a>
            || <span style="float:right"><?php
            if (isset($_SESSION['currentusername'])) {
              echo '<a href="/profile/">Hello <b>' . escape($_SESSION['currentusername']) . '</b>!</a>';
            } else {
              echo '<a href="/profile/">Login</a> or <a href="/users/new.php">register!</a>';
            }
            ?></span>
        </div>
    </div>
</div>
<div class="mainbody">
