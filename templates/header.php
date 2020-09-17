<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Simple Database App</title>

	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<h1><?php echo $_SERVER['HTTP_HOST']; ?></h1>

<table>
<tr><td>
Users</td><td>
	<a href="create-user.php"><strong>Create</strong></a>
	<a href="read-user.php"><strong>Read</strong></a>
	<a href="update-user.php"><strong>Update</strong></a>
	<a href="delete-user.php"><strong>Delete</strong></a>
</td></tr>
<tr><td>
Tools</td><td>
	<a href="create-tool.php"><strong>Create</strong></a>
	<a href="read-tool.php"><strong>Read</strong></a>
	<a href="update-tool.php"><strong>Update</strong></a>
	<a href="delete-tool.php"><strong>Delete</strong></a>
</td></tr>
</table>
