<?php
require "../common/common.php";
require "../common/header.php";

if ( isset($_POST["delete"]) ) {
	if ( !hash_equals($_SESSION['csrf'], $_POST['csrf']) ) {
		die();
	}
	try { // Action on SUBMIT:
		$timestamp = date("Y-m-d H:i:s");
		$id        = $_SESSION['currentuserid'];
		$statement = $connection->prepare("UPDATE users  SET deleted = '$timestamp' WHERE id = :id");
		$statement->bindValue(':id', $id);
		$statement->execute();
		// remove all session variables
		session_unset();
		// destroy the session
		session_destroy();
	} catch (PDOException $error) {
		showMessage(__LINE__, __FILE__, $sql . "<br>" . $error->getMessage());
	}
}
?>

<?php if ( isset($_POST['delete']) && $statement ) : ?>
    <blockquote class="success">Successfully deleted your profile! <a href="/">Start fresh?</a></blockquote>

<?php else : ?>
    <blockquote class="warning">Something went wrong</b>! <a href="/">try again</a>.</blockquote>

<?php endif; ?>

<?php require "../common/footer.php"; ?>
