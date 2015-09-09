<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	if (!isset($_POST['search'])) {
		$_POST['search'] = "";
	} else {
		$_POST['search'] = bin2hex(iconv('UTF-8','UCS-2', $_POST['search']));
	}
	header("Location: /?search=".$_POST['search']);
?>