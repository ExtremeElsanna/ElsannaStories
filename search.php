<?php	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");	if (!isset($_POST['search'])) {		$_POST['search'] = "";	} else {		$_POST['search'] = mb_convert_encoding(hex2bin($_POST['search']),'UTF-8','UCS-2');
		echo $_POST['search'];
		die;	}	header("Location: /?search=".$_POST['search']);?>