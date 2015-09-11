<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");

	foreach ($_POST as $key => $param) {
		echo $key." : ".$param."<br>";
	}
	die;
	header("Location: /?search=".$_POST['search']);
?>