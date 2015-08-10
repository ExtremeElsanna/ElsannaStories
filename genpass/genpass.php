<!DOCTYPE html>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
<?php
	include("/hdd/database-config/config.php");
	
	echo $_POST['user']."<br>";
	echo $_POST['password']."<br>";
	
	/**
	 * Note that the salt here is randomly generated.
	 * Never use a static salt or one that is not randomly generated.
	 *
	 * For the VAST majority of use-cases, let password_hash generate the salt randomly for you
	 */
	$salt = mcrypt_create_iv($PsaltLength, $PsaltPattern);
	$options = [
		'cost' => $PsaltCost,
		'salt' => $salt,
	];
	echo $salt."<br>";
	$hash = password_hash($_POST['password'], $PhashPattern, $options);
	echo $hash."<br>";
	
	$pdo = new PDO('mysql:host='.$DBhost.';dbname='.$DBname, $DBusername, $DBpassword);
	$stmt = $pdo->prepare('INSERT INTO Users (Username, UpperUser, Hash, Salt, Email, DateJoined) VALUES ("Username","USERNAME",:hash,:salt,"Email","0000-00-00");');
	$stmt->bindParam(':hash', $hash, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':salt', $salt, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
?>
	</body>
</html>