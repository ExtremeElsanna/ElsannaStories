<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");

	if (!isset($_POST['search'])) {
		$_POST['search'] = "";
	} else {
		set_error_handler(function() { /* ignore errors */ });
		$_POST['search'] = bin2hex(mb_convert_encoding($_POST['search'], 'UCS-2', 'UTF-8'));
		restore_error_handler();
	}
	header("Location: /?search=".$_POST['search']);
?>