<?php
	include("../scripts/sessionHandler.php");
	include("../config.php");
	
	if (isset($_GET['code'])) {
		// Connect to DB
		if(!isset($pdo)) {
			try {
				$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
			} catch (PDOException $e) {
				echo 'Connection failed: ' . $e->getMessage();
				die;
			}
		}
		
		// Get users with given activation code
		$stmt = $pdo->prepare('SELECT AccountActivationId,UserId FROM AccountActivation WHERE ActivationCode = :code;');
		$stmt->bindParam(':code', $_GET['code'], PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
		$stmt->execute();
		$row = $stmt->fetch();
		$activationId = $row['AccountActivationId'];
		$userId = $row['UserId'];
		
		// Check the user exists
		if($userId != "") {
			// Activate the account
			$stmt = $pdo->prepare('UPDATE Users SET Activated = 1 WHERE Id = :id;');
			$stmt->bindParam(':id', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->execute();
			
			// Delete the activation code
			$stmt = $pdo->prepare('DELETE FROM AccountActivation WHERE AccountActivationId = :id;');
			$stmt->bindParam(':id', $activationId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->execute();
			// Account activated
			header("Location: /login/?code=1");
			die();
		} else {
			// No activation entry under that code
			header("Location: /?code=2");
			die();
		}
	} else {
		// No code supplied
		header("Location: /?code=2");
		die();
	}
?>
