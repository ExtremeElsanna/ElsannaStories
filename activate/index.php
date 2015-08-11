<?php
	include("/hdd/config/config.php");
	if (isset($_GET['code'])) {
		$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword']);
		$stmt = $pdo->prepare("SET NAMES 'utf8'");
		$stmt->execute();
		
		$stmt = $pdo->prepare('SELECT UserId FROM AccountActivation WHERE ActivationCode = :code');
		$stmt->bindParam(':code', $_GET['code'], PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
		$stmt->execute();
		$row = $stmt->fetch();
		$userId = $row['Id'];
		
		echo 'Activating Account UserId: '.$userId;
	}
?>