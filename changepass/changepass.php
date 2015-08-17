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
	
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
	if ($_SESSION['loggedIn'] != 1) {
		// Not logged in
		header("Location: /?code=3");
		die();
	}
	
	// Connect to DB
	$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
	$userId = $_SESSION['userId'];
	
	// Get the current password hash of the user
	$stmt = $pdo->prepare('SELECT Hash,Salt FROM Users WHERE Id = :userId;');
	$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	$row = $stmt->fetch();
	$hash = $row['Hash'];
	$salt = $row['Salt'];
	$options = [
			'cost' => $config['PsaltCost'],
			'salt' => $salt.$config['Ppepper'],
		];
	// Create hash of their 'old password' entry
	$oldHash = password_hash($_POST['old_password'], $config['PhashPattern'], $options);
	
	if ($oldHash == $hash) {
		// Old Password Correct
		if ($_POST['new_password'] == $_POST['new_password_confirm']) {
			// New Password == Password confirmation
			if (strlen($_POST['new_password']) >= 7) {
				// Password >= 7 chars
				if (strlen($_POST['new_password']) <= 20) {
					// Password <= 20 chars
					if (preg_match("/(?:.*[^abcdefghijklmnopqrstuvwxyz0123456789\[\]\(\)\{\}\@\#\!\£\$\%\^\&\*\?\<\>].*)+/i",$_POST['new_password']) == 0) {
						// Password contains valid characters
						if ($_POST['old_password'] != $_POST['new_password']) {
							// New password is different from old password
							$newSalt = generateCode($config['PsaltLength']);
							$options = [
								'cost' => $config['PsaltCost'],
								'salt' => $newSalt.$config['Ppepper'],
							];
							// Generate new hash + salt for new password
							$newHash = password_hash($_POST['new_password'], $config['PhashPattern'], $options);
							
							$stmt = $pdo->prepare("UPDATE Users SET Hash = :newHash WHERE Id = :id;");
							$stmt->bindParam(':newHash', $newHash, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
							$stmt->bindParam(':id', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
							$stmt->execute();
							
							$stmt = $pdo->prepare("UPDATE Users SET Salt = :newSalt WHERE Id = :id;");
							$stmt->bindParam(':newSalt', $newSalt, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
							$stmt->bindParam(':id', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
							$stmt->execute();
							
							// Logout
							include("/hdd/elsanna-ssl/scripts/logout.php");
							header("Location: /login/?code=2");
							die();
						} else {
							// New password is same as old password
							header("Location: /changepass/?code=6");
							die();
						}
					} else {
						// Password contains invalid characters
						header("Location: /changepass/?code=5");
						die();
					}
				} else {
					// Password > 20 chars
					header("Location: /changepass/?code=4");
					die();
				}
			} else {
				// Password < 7 chars
				header("Location: /changepass/?code=3");
				die();
			}
		} else {
			// New Password != Password Confirmation
			header("Location: /changepass/?code=2");
			die();
		}
	} else {
		// Old Password Incorrect
		header("Location: /changepass/?code=1");
		die();
	}
?>