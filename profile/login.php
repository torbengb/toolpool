<?php
require "../common/common.php";
require "../common/header.php";

if ( isset($_GET["action"]) && $_GET["action"] == 'register' ) {
	try { // load foreign tables:
		// list of countries:
		$statement = $connection->prepare("
	        SELECT code, name FROM countries
	        WHERE ( deleted = '0000-00-00 00:00:00' OR deleted IS NULL )
	        ORDER BY code
	        ");
		$statement->execute();
		$countries = $statement->fetchAll();
		// list for regions:
		$statement = $connection->prepare("
	        SELECT code, name FROM regions
	        WHERE ( deleted = '0000-00-00 00:00:00' OR deleted IS NULL )
	        ORDER BY code
	        ");
		$statement->execute();
		$regions = $statement->fetchAll();
	} catch (PDOException $error) {
		showMessage(__LINE__, __FILE__, $sql . "<br>" . $error->getMessage());
	}
}
?>

<?php if ( isset($_GET["action"])
			  && $_GET["action"] == 'register' ) : ?>

    <h2>Register || <a href="login.php">Login instead?</a></h2>

	<form method="post"  action="profile-created.php">
		<input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">

		<label class="label" for="username">User name
			<input class="input" type="text" name="username" id="username">
			<span class="formhint">This is the only name we will show other users.</span> </label>
		<label class="label" for="password">Password
			<input class="input" type="password" name="password" id="password">
			<span class="formhint">Be safe: don't reuse passwords! May we recommend using a password manager?</span> </label>
		<label class="label" for="email">Email address
			<input class="input" type="text" name="email" id="email">
			<span class="formhint">We use this to validate your account, and to send you information about loans and requests.</span></label>
		<label class="label" for="firstname">First name
			<input class="input" type="text" name="firstname" id="firstname">
			<span class="formhint">Not presently used.</span> </label>
		<label class="label" for="lastname">Last name
			<input class="input" type="text" name="lastname" id="lastname">
			<span class="formhint">Not presently used.</span> </label>
		<label class="label" for="phone">Phone number
			<input class="input" type="text" name="phone" id="phone">
			<span class="formhint">Not presently used, but may be used for SMS notifications later.</span> </label>
		<label class="label" for="addr_country">Country
			<select class="input" name="addr_country" id="addr_country">
				<?php foreach ( $countries as $row ) : ?>
					<option value="<?php echo escape($row["code"]); ?>">
						<?php echo(escape($row["code"]) == "0" ? escape($row["name"]) : escape($row["code"]) . "&nbsp;&nbsp;&nbsp;" . escape($row["name"])); ?>
					</option>
				<?php endforeach; ?>
			</select>
            <span class="formhint">We use country and region to help you find tools in your area.</span>
        </label>
		<label class="label" for="addr_region">Region
			<select class="input" name="addr_region" id="addr_region">
				<?php foreach ( $regions as $row ) : ?>
					<option value="<?php echo escape($row["code"]); ?>">
						<?php echo(escape($row["code"]) == "0" ? escape($row["name"]) . " " : escape($row["code"]) . "&nbsp;&nbsp;&nbsp;" . escape($row["name"])); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</label>
		<label class="label" for="addr_zip">ZIP code
			<input class="input" type="text" name="addr_zip" id="addr_zip">
			<span class="formhint">Not presently used.</span> </label>
		<label class="label" for="addr_city">City
			<input class="input" type="text" name="addr_city" id="addr_city">
			<span class="formhint">Not presently used.</span> </label>
		<label class="label" for="addr_street">Street name
			<input class="input" type="text" name="addr_street" id="addr_street">
			<span class="formhint">Not presently used.</span>
		</label>
		<label class="label" for="addr_number">House number
			<input class="input" type="text" name="addr_number" id="addr_number">
			<span class="formhint">Not presently used.</span>
		</label>
		<label class="label" for="privatenotes">Private notes
			<input class="input" type="text" name="privatenotes" id="privatenotes">
			<span class="formhint">Only you can see these notes.</span>
		</label>
		<label class="label" for="publicnotes">Public notes
			<input class="input" type="text" name="publicnotes" id="publicnotes">
			<span class="formhint">Is there anything you want to say to others?</span>
		</label>

		<button class="button submit" type="submit" name="create" value="create">Register</button>
	</form>

<?php else : ?>

	<h2>Login || <a href="login.php?action=register">Register instead?</a></h2>

	<form method="post" action="/profile/">
        <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">
        <label class="label" for="user"><span class="labeltext">select user:</span>
            <select class="input" name="user" id="user">
				<?php foreach ( $users as $row ) : ?>
                    <option
                            name="user"
                            id="user"
                            value="<?php echo escape($row['id']); ?>"
						<?php echo(escape($row["id"]) == (isset($_SESSION["currentuserid"]) ? escape($_SESSION["currentuserid"]) : NULL) ? "selected='selected'" : NULL) ?>
                    ><?php echo escape($row['username']); ?></option>
				<?php endforeach; ?>
            </select>
        </label>
        <button class="button submit" type="submit" name="login" value="login">Switch!</button>
    </form>
<?php endif; ?>

<?php require "../common/footer.php"; ?>
