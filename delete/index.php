<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");

$errors = array(1 => "Unexpected error");
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
		
		<form action="delete.php" method="post">
			<input type="hidden" name="confirm" value="true">
			<input type="submit" value="Are you sure?">
		</form>
	</body>
</html>