<?php	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");	if (!isset($_POST['search'])) {		$_POST['search'] = "";	} else {		$_POST['search'] = bin2hex(mb_convert_encoding($headerRefer, 'UCS-2', 'UTF-8'));
		echo $_POST['search'];
		die;	}	header("Location: /?search=".$_POST['search']);?>