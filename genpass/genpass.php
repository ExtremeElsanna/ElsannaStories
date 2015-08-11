<?php include("/hdd/elsanna-ssl/scripts/utf8Headers.php"); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
<?php
	include("/hdd/config/config.php");
	
	//echo $_POST['user']."<br>";
	//echo $_POST['password']."<br>";
	//echo $_POST['email']."<br>";
	
	$salt = mcrypt_create_iv($config['PsaltLength'], $config['PsaltPattern']);
	$options = [
		'cost' => $config['PsaltCost'],
		'salt' => $salt,
	];
	$hash = password_hash($_POST['password'], $config['PhashPattern'], $options);
	
	$user = $_POST['user'];
	$userUpper = mb_strtoupper($_POST['user'], 'UTF-8');
	$email = mb_strtoupper($_POST['email'], 'UTF-8');
	date_default_timezone_set('UTC');
	$joinDate = date("Y-m-d");
	
	$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword']);
	$stmt = $pdo->prepare("SET NAMES 'utf8'");
	$stmt->execute();
	$stmt = $pdo->prepare('INSERT INTO Users (Username, UpperUser, Hash, Salt, Email, DateJoined) VALUES (:user,:upperuser,:hash,:salt,:email,:joindate);');
	$stmt->bindParam(':user', $user, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':upperuser', $userUpper, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':hash', $hash, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':salt', $salt, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':email', $email, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':joindate', $joinDate, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	//$stmt->execute();
	echo "Inserting Account = User : ".$user." | Hash : ".$hash." | Salt : ".$salt." | Email : ".$email." | Join Date : ".$joinDate."<br>";
?>
	</body>
</html>