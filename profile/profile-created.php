<?php
require "../common/common.php";
require "../common/header.php";

if ( isset($_POST['create']) ) { // Action on SUBMIT:
	if ( !hash_equals($_SESSION['csrf'], $_POST['csrf']) ) {
		die();
	}
	try { // create the record:
		$timestamp = date("Y-m-d H:i:s");
		$record    = ["created" => $timestamp, "username" => $_POST['username'], "hashedpassword" => password_hash($_POST['password'], PASSWORD_DEFAULT), "email" => $_POST['email'], "firstname" => $_POST['firstname'], "lastname" => $_POST['lastname'], "phone" => $_POST['phone'], "addr_country" => $_POST['addr_country'], "addr_region" => $_POST['addr_region'], "addr_city" => $_POST['addr_city'], "addr_zip" => $_POST['addr_zip'], "addr_street" => $_POST['addr_street'], "addr_number" => $_POST['addr_number'], "privatenotes" => $_POST['privatenotes'], "publicnotes" => $_POST['publicnotes']];
		$sql       = sprintf("INSERT INTO %s (%s) VALUES (%s)", "users", implode(", ", array_keys($record)), ":" . implode(", :", array_keys($record)));
		$statement = $connection->prepare($sql);
		$statement->execute($record);
	} catch (PDOException $error) {
		showMessage(__LINE__, __FILE__, $sql . "<br>" . $error->getMessage());
	}
}
?>

<?php if ( isset($_POST['create']) && $statement ) : ?>
    <blockquote class="success">Successfully registered your username <b><?php echo escape($_POST['username']); ?></b>!
        Now you can <a href="login.php">log in</a>.
    </blockquote>

<?php else : ?>
	<blockquote class="warning">Something went wrong</b>! <a href="/">try again</a>.</blockquote>

<?php endif; ?>

<?php require "../common/footer.php"; ?>
