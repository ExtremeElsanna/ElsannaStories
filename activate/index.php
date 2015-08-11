<?php
	include("/hdd/config/config.php");
	if (isset($_GET['code'])) {
		$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword']);
		$stmt = $pdo->prepare("SET NAMES 'utf8'");
		$stmt->execute();
		
		$stmt = $pdo->prepare('SELECT AccountActivationId,UserId FROM AccountActivation WHERE ActivationCode = :code');
		$stmt->bindParam(':code', $_GET['code'], PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
		$stmt->execute();
		$row = $stmt->fetch();
		$activationId = $row['AccountActivationId'];
		$userId = $row['UserId'];
		
		if($userId != "") {		
			$stmt = $pdo->prepare('UPDATE Users SET Activated = 1 WHERE Id = :id');
			$stmt->bindParam(':id', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->execute();
			
			$stmt = $pdo->prepare('DELETE FROM AccountActivation WHERE AccountActivationId = :id');
			$stmt->bindParam(':id', $activationId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->execute();
			
			//echo 'Activated Account UserID: '.$userId;
		}
	}
	header("Location: /login/");
	die();
?>