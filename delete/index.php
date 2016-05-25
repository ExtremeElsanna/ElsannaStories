<?php
include("../headers/utf8Headers.php");
include("../scripts/sessionHandler.php");
include("../headers/HTMLvariables.php");
if ($_SESSION['loggedIn'] != 1) {
	// Not logged in
	header("Location: /?code=3");
	die();
}

$errors = array(1 => "Unexpected Error :(");
?>
<?php echo $doctype; ?>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
<?php
			// Include header in page
			$headerRefer = "/";
			include("../classes/header.php");
?>
<?php
			if (isset($_GET['code']) and is_numeric($_GET['code']) and isset($errors[intval($_GET['code'])])) {
				echo "\t\t".$errors[intval($_GET['code'])]."<br />\n";
			}
?>
		<form action="delete.php" method="post">
			<input type="hidden" name="confirm" value="true">
			<input type="submit" value="Are you sure?">
		</form>
	</body>
</html>