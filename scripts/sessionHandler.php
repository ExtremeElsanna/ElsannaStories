<?php
	// Make sure session data exists for access
	if (!isset($_SESSION)) {
		session_start();
	}
	if (!isset($_SESSION['loggedIn'])) {
		$_SESSION['loggedIn'] = 0;
	}
	if (!isset($_SESSION['userId'])) {
		$_SESSION['userId'] = null;
	}
	if (!isset($_SESSION['username'])) {
		$_SESSION['username'] = null;
	}
	if (!isset($_SESSION['lastActive'])) {
		$_SESSION['lastActive'] = null;
	}
	if (!isset($_SESSION['changePassId'])) {
		$_SESSION['changePassId'] = null;
	}
	
	$httpLength = 7;
	if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == "on") {
		$httpLength = 8;
	}
	// Strip referer down to link extension
	$noProtocol = mb_substr($_SERVER['HTTP_REFERER'],$httpLength,null,"UTF-8");
	$hostLength = mb_strlen($_SERVER['HTTP_HOST'],"UTF-8");
	$refer = mb_strtolower(mb_substr($noProtocol,$hostLength,null,"UTF-8"),"UTF-8");
	
	if (isset($_POST['refer'])) {
		$refer = $_POST['refer'];
	} else if(isset($_GET['refer'])) {
		$refer = $_GET['refer'];
	}
	
	// Check user logged in
	if ($_SESSION['loggedIn'] == 1) {
		date_default_timezone_set('UTC');
		$currentTime = time();
		$difference = $currentTime - $_SESSION['lastActive'];
		// Check if not active for 15 minutes
		if ($difference > 900) {
			// Log the user out
			include("/hdd/elsanna-ssl/scripts/logout.php");
		} else {
			// Update the last active time
			$_SESSION['lastActive'] = $currentTime;
			$userId = $_SESSION['userId'];
			
			// Connect to DB
			include("/hdd/config/config.php");
			if(!isset($pdo)) {
				$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
			}
			$stmt = $pdo->prepare('SELECT Id,Banned FROM Users WHERE Id = :userId;');
			$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->execute();
			$row = $stmt->fetch();
			// Save important information
			$userId = $row['Id'];
			$banned = $row['Banned'];
			if ($userId != "") {
				// User exists
				if ($banned == 1) {
					// Log the user out as they have been banned since they logged in
					include("/hdd/elsanna-ssl/scripts/logout.php");
					// Account banned
					header("Location: /login/?refer=".$refer."&code=11");
					die();
				}
			} else {
				// Log the user out as an error has occurred
				include("/hdd/elsanna-ssl/scripts/logout.php");
			}
		}
	}
?>