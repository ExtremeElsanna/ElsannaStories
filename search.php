<?php
	include("scripts/sessionHandler.php");
	include("scripts/functions.php");

	if (!isset($_POST['search'])) {
		$_POST['search'] = "";
	} else {
		$_POST['search'] = Encode($_POST['search']);
	}
	header("Location: /?search=".$_POST['search']);
	
?>
