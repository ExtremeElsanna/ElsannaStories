<?php
	function generateCode($length) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$code = '';
		for ($i = 0; $i < $length; $i++) {
			$code .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $code;
	}
	
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
	if ($_SESSION['loggedIn'] != 1) {
		// Not logged in
		header("Location: /");
		die();
	}
	
	$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
	$newUser = $_POST['username'];
	$newUpperUser = mb_strtoupper($newUser, "UTF-8");
	$userId = $_SESSION['userId'];
	$stmt = $pdo->prepare('SELECT Id FROM Users WHERE UpperUser = :upperUser');
	$stmt->bindParam(':upperUser', $newUpperUser, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	$row = $stmt->fetch();
	if ($row['Id'] == "") {
		// Username not taken
		if (preg_match("/(?:.*[^abcdefghijklmnopqrstuvwxyz0123456789].*)+/i",$newUser) == 0) {
			// Username contains valid chars
			$stmt = $pdo->prepare("UPDATE Users SET Username = :newUser WHERE Id = :id");
			$stmt->bindParam(':newUser', $newUser, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
			$stmt->bindParam(':id', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->execute();
			$stmt = $pdo->prepare("UPDATE Users SET UpperUser = :newUpperUser WHERE Id = :id");
			$stmt->bindParam(':newUpperUser', $newUpperUser, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
			$stmt->bindParam(':id', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->execute();
			header("Location: /");
			die();
		} else {
			// Username contains invalid chars
			header("Location: /changeuser/");
			die();
		}
	} else {
		// Username already exists
		header("Location: /changeuser/");
		die();
	}
?>