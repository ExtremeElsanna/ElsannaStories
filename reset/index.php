<?php
include("../headers/utf8Headers.php");
if (!isset($_GET['refer'])) {
	$_GET['refer'] = "/";
} else {
	$_GET['refer'] = Decode($_GET['refer']);
}
include("../scripts/sessionHandler.php");
include_once("../scripts/functions.php");
include("../headers/HTMLvariables.php");

$errors = array(1 => "Unexpected Error :(",
				2 => "Email does not exist.");
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
		<form action="reset.php" method="post">
			<input type="text" name="email" value="" placeholder="Email">
<?php
				// Pass refer link given from referer to the login.php page
				echo '<input type="hidden" name="refer" value="'.$_GET['refer'].'">';
?>
			
			<input type="submit" value="Recover">
		</form>
	</body>
</html>
