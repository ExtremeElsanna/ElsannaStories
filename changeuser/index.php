<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");

$errors = array(1 => "Username already exists",
				2 => "Username contains invalid characters a=>z,A=>Z,0=>9",
				3 => "Username < 4 chars",
				4 => "Username > 25 chars");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
		<?php
			// Include header in page
			$headerRefer = "/";
			include("/hdd/elsanna-ssl/classes/header.php");
		?>
		
		<?php
			if (isset($_GET['code']) and is_numeric($_GET['code'])) {
				echo $errors[intval($_GET['code'])]."<br>";
			}
		?>
		
		<form action="changeuser.php" method="post">
			<input type="text" name="username" value="" placeholder="New Username">
			<input type="submit" value="Change Username">
		</form>
	</body>
</html>