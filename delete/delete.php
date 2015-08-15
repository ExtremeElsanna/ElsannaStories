<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
	if ($_SESSION['loggedIn'] != 1) {
		// Not logged in
		header("Location: /");
		die();
	}
	if (!isset($_SERVER)) {
		// SERVER data doesn't exist
		header("Location: /user/".$_SESSION['username']);
		die();
	}
	if (!isset($_POST['confirm']) or $_POST['confirm'] != "true") {
		// Not referred by /delete/
		header("Location: /user/".$_SESSION['username']);
		die();
	}
	if (!isset($_SERVER['HTTP_REFERER'])) {
		// Not referred by /delete/
		header("Location: /user/".$_SESSION['username']);
		die();
	}
	if (!isset($_SERVER['HTTP_HOST'])) {
		// HTTP_HOST data not present for some reason
		header("Location: /user/".$_SESSION['username']);
		die();
	}
	$httpLength = 7;
	if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == "on") {
		$httpLength = 8;
	}
	$noProtocol = mb_substr($_SERVER['HTTP_REFERER'],$httpLength,null,"UTF-8");
	$hostLength = mb_strlen($_SERVER['HTTP_HOST'],"UTF-8");
	$referrer = mb_strtolower(mb_substr($noProtocol,$hostLength,null,"UTF-8"),"UTF-8");
	if (mb_substr($referrer,-9,null,"UTF-8") == "index.php") {
		$referrer = mb_substr($noHost,0,-9,"UTF-8");
	}
	if ($referrer != "/delete/") {
		// Not referred by /delete/
		header("Location: /user/".$_SESSION['username']);
		die();
	}
	
	$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);$stmt = $pdo->prepare('SELECT Id FROM Users WHERE Username = :user');
	$stmt = $pdo->prepare("DELETE FROM Users WHERE Id = :id");
	$userId = $_SESSION['userId'];
	$stmt->bindParam(':id', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	// Logout
	include("/hdd/elsanna-ssl/scripts/logout.php");
	// ReDirect to homepage
	header("Location: /");
	die();
?>