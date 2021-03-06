<?php
include("../headers/utf8Headers.php");
include_once("../scripts/functions.php");
if (!isset($_GET['refer'])) {
	$_GET['refer'] = "/";
} else {
	$_GET['refer'] = Decode($_GET['refer'])
}
include("../scripts/sessionHandler.php");
include("../headers/HTMLvariables.php");
if ($_SESSION['loggedIn'] != 1 and $_SESSION['changePassId'] == null) {
	// Not logged in
	header("Location: /?code=3");
	die();
}

$errors = array(1 => "Old Password is incorrect.",
				2 => "Password confirmation not equal to original password.",
				3 => "Password is shorter than 7 characters.",
				4 => "Password is longer than 20 characters.",
				5 => "Password contains invalid characters. You may use: a-z, A-Z, 0-9, [], (), {}, @, #, !, £, $, %, ^, &amp;, *, ?, &lt;>",
				6 => "New Password same as Old Password.",
				7 => "You need to change your password.",
				8 => "Unexpected Error :(");
?>
<?php echo $doctype; ?>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
<?php
			// Include header on page
			$headerRefer = "/";
			include("../classes/header.php");
?>
<?php
			if (isset($_GET['code']) and is_numeric($_GET['code']) and isset($errors[intval($_GET['code'])])) {
				echo "\t\t".$errors[intval($_GET['code'])]."<br />\n";
			}
?>
		<form action="changepass.php" method="post">
			<input type="password" name="old_password" value="" placeholder="Old Password">
			<input type="password" name="new_password" value="" placeholder="New Password">
			<input type="password" name="new_password_confirm" value="" placeholder="New Password Confirmation">
<?php
				// Pass refer link given from referer to the login.php page
				echo '<input type="hidden" name="refer" value="'.$_GET['refer'].'">';
?>
			<input type="submit" value="Change Password">
		</form>
	</body>
</html>
