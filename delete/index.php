<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
		<?php
			$headerRefer = "/";
			include("/hdd/elsanna-ssl/classes/header.php");
		?>
		
		<a href="/register/">Register</a><br>
		<form action="delete.php" method="post">
			<input type="submit" value="Are you sure?">
		</form>
	</body>
</html>