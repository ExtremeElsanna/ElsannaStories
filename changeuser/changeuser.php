<?php
	function generateCode($length) {
		// Generate a $length character long string using characters from below
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$code = '';
		for ($i = 0; $i < $length; $i++) {
			$code .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $code;
	}
	
	include("../scripts/sessionHandler.php");
	include("../config.php");
	
	if (!isset($_POST['username'])) {
		// Username not set
		header("Location: /changeuser/?code=6");
		die();
	}
	
	if ($_SESSION['loggedIn'] != 1) {
		// Not logged in
		header("Location: /?code=3");
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

	$newUser = $_POST['username'];
	$newUpperUser = mb_strtoupper($newUser, "UTF-8");
	$userId = $_SESSION['userId'];
	
	// Get users with given new username
	$stmt = $pdo->prepare('SELECT UserId FROM Users WHERE UpperUser = :upperUser;');
	$stmt->bindParam(':upperUser', $newUpperUser, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	$row = $stmt->fetch();
	if ($row['UserId'] == "") {
		// Username not taken
		if (strlen($newUser) >= 4) {
			// Username >= 4 chars
			if (strlen($newUser) <= 25) {
				// Username <= 25 chars
				if (strcasecmp($_POST['user'],"guest") != 0) {
					// Username valid
					if (preg_match("/(?:.*[^abcdefghijklmnopqrstuvwxyz0123456789].*)+/i",$newUser) == 0) {
						// Username contains valid chars
						$stmt = $pdo->prepare("UPDATE Users SET Username = :newUser WHERE UserId = :userId;");
						$stmt->bindParam(':newUser', $newUser, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
						$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
						$stmt->execute();
						$stmt = $pdo->prepare("UPDATE Users SET UpperUser = :newUpperUser WHERE UserId = :userId;");
						$stmt->bindParam(':newUpperUser', $newUpperUser, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
						$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
						$stmt->execute();
						$_SESSION['username'] = $newUser;
						header("Location: /?code=1");
						die();
					} else {
						// Username contains invalid chars
						header("Location: /changeuser/?code=2");
						die();
					}
				} else {
					// Username is Guest
					header("Location: /changeuser/?code=5");
					die();
				}
			} else {
				// Username > 25 chars
				header("Location: /changeuser/?code=4");
				die();
			}
		} else {
			// Username < 4 chars
			header("Location: /changeuser/?code=3");
			die();
		}
	} else {
		// Username already exists
		header("Location: /changeuser/?code=1");
		die();
	}
?>
