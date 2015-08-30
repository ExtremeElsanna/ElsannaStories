<?php
include("/hdd/elsanna-ssl/headers/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
include("/hdd/config/config.php");
// Check we have a user name query
if (isset($_GET['user'])) {
	// Get username
	$user = $_GET['user'];
	$upperUser = mb_strtoupper($user, 'UTF-8');
	
	// Connect to DB
	if(!isset($pdo)) {
		try {
			$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
			die;
		}
	}

	// Get data about matching user
	$stmt = $pdo->prepare('SELECT Id,Username FROM Users WHERE UpperUser = :upperUser;');
	$stmt->bindParam(':upperUser', $upperUser, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	$row = $stmt->fetch();
	$userId = $row['Id'];
	$user = $row['Username'];
	// Check user exists
	if ($userId == "") {
		// User doesn't exist
		header("Location: /?code=6");
		die;
	}
} else {
	// No username passed
	header("Location: /?code=2");
	die;
}
// Check if this is logged in user's profile
if ($_SESSION['loggedIn'] == 1 and $_SESSION['userId'] == $userId) {
	$usersProfile = true;
} else {
	$usersProfile = false;
}
?>
<?php include("/hdd/elsanna-ssl/headers/doctype.php") ?>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
<?php
			// Include header in page
			$headerRefer = '/user/'.$user;
			include("/hdd/elsanna-ssl/classes/header.php");
?>
		
<?php
			// If logged in user's profile
			if ($usersProfile == true) {
				// Print user admin options
				echo "Welcome to your profile!<br />\n";
				echo "\t\t<a href='/changeuser/'>Change Username</a><br />\n";
				echo "\t\t<a href='/changepass/'>Change Password</a><br />\n";
				echo "\t\t<a href='/delete/'>Delete Account</a>";
			} else {
				// Print guest/other user information
				echo $user."'s profile!";
			}
?>
		
	</body>
</html>