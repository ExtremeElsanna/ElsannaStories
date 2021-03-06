<?php
	if (!isset($_POST['refer'])) {
		$_POST['refer'] = "/";
	}
	include("../scripts/sessionHandler.php");
	include("../config.php");
	
	if (!isset($_POST['user'])) {
		// User not set
		header("Location: /login/?refer=".$_POST['refer']."&code=6");
		die();
	}
	if (!isset($_POST['password'])) {
		// Password not set
		header("Location: /login/?refer=".$_POST['refer']."&code=6");
		die();
	}
	
	// Connect to DB
	if(!isset($pdo)) {
		try {
			$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
			die;
		}
	}

	
	$upperUser = mb_strtoupper($_POST['user'], 'UTF-8');
	
	// Get important details about user
	$stmt = $pdo->prepare('SELECT UserId,Username,Hash,Salt,LoginCount,Activated,ChangePass,Banned FROM Users WHERE UpperUser = :upperUser;');
	$stmt->bindParam(':upperUser', $upperUser, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	$row = $stmt->fetch();
	// Save important information
	$userId = $row['UserId'];
	$user = $row['Username'];
	$hash = $row['Hash'];
	$salt = $row['Salt'];
	$activated = $row['Activated'];
	$changePass = $row['ChangePass'];
	$loginCount = $row['LoginCount'];
	$banned = $row['Banned'];
	if ($userId != "") {
		// Correct username
		if ($banned == 0) {
			// Account not banned
			if ($activated == 1) {
				// Account activated
				$options = [
						'cost' => $config['PsaltCost'],
						'salt' => $salt.$config['Ppepper'],
					];
				$newHash = password_hash($_POST['password'], $config['PhashPattern'], $options);
				
				if ($newHash == $hash) {
					// Update last login and login count
					date_default_timezone_set('UTC');
					$newTime = time();
					
					$stmt = $pdo->prepare("UPDATE Users SET LastLoggedIn = :newTime WHERE UserId = :userId;");
					$stmt->bindParam(':newTime', $newTime, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
					$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
					$stmt->execute();
					
					$newCount = intval($loginCount) + 1;
					$stmt = $pdo->prepare("UPDATE Users SET LoginCount = :newCount WHERE UserId = :userId;");
					$stmt->bindParam(':newCount', $newCount, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
					$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
					$stmt->execute();
					
					// Password correct
					if ($changePass == 0) {
						$_SESSION['loggedIn'] = 1;
						$_SESSION['userId'] = $userId;
						$_SESSION['username'] = $user;
						$_SESSION['lastActive'] = time();
						$_SESSION['banned'] = 0;
						header("Location: ".$_POST['refer']);
						die();
					} else {
						$_SESSION['changePassId'] = $userId;
						header("Location: /changepass/?code=7&refer=".$_POST['refer']);
						die();
					}
				} else {
					// Password wrong
					header("Location: /login/?refer=".$_POST['refer']."&code=3");
					die();
				}
			} else {
				// Account not activated
				header("Location: /login/?refer=".$_POST['refer']."&code=4&id=".$userId);
				die();
			}
		} else {
			// Account banned
			header("Location: /login/?refer=".$_POST['refer']."&code=10");
			die();
		}
	} else {
		// Wrong username
		header("Location: /login/?refer=".$_POST['refer']."&code=3");
		die();
	}
?>
