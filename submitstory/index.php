<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
		<?php
			$headerRefer = '/story/?id='.$_GET['id'];
			include("/hdd/elsanna-ssl/classes/header.php");
			date_default_timezone_set('UTC');
			$currentDate = date("Y-m-d");
		?>
		
		<form action="submit.php" method="post">
			<input type="text" name="Title" value="" placeholder="Title">
			
			<input type="text" name="Author" value="" placeholder="Author">
			
			<input type="number" name="Length" value="" min="1">
			
			<input type="radio" name="StoryType" value="Multi-Chapter">
			<input type="radio" name="StoryType" value="One-Shot">
			<input type="radio" name="StoryType" value="One-Shot Series">
			
			<input type="radio" name="Complete" value="Yes">
			<input type="radio" name="Complete" value="No">
			<input type="radio" name="Complete" value="Unknown">
			
			<input type="radio" name="Setting" value="Canon" >
			<input type="radio" name="Setting" value="Alternate Universe (AU)">
			<input type="radio" name="Setting" value="Modern Alternate Universe (mAU)">
			<input type="radio" name="Setting" value="Same Time and Place (STP)">
			<input type="radio" name="Setting" value="Unknown">
			
			<input type="text" name="ElsaCharacter" value="" placeholder="Elsa's Character">
			
			<input type="text" name="AnnaCharacter" value="" placeholder="Anna's Character">
			
			<input type="radio" name="ElsaPowers" value="Canon">
			<input type="radio" name="ElsaPowers" value="Different">
			<input type="radio" name="ElsaPowers" value="None">
			<input type="radio" name="ElsaPowers" value="Unknown">
			
			<input type="radio" name="AnnaPowers" value="No">
			<input type="radio" name="AnnaPowers" value="Yes">
			
			<input type="radio" name="Sisters" value="Yes">
			<input type="radio" name="Sisters" value="No">
			<input type="radio" name="Sisters" value="Unknown">
			
			<input type="radio" name="Age" value="K">
			<input type="radio" name="Age" value="K+">
			<input type="radio" name="Age" value="T">
			<input type="radio" name="Age" value="M">
			
			<input type="radio" name="SmutLevel" value="None">
			<input type="radio" name="SmutLevel" value="Plot Focused">
			<input type="radio" name="SmutLevel" value="Light">
			<input type="radio" name="SmutLevel" value="Medium">
			<input type="radio" name="SmutLevel" value="Heavy">
			<input type="radio" name="SmutLevel" value="Pure">
			
			<input type="text" name="Url" value="" placeholder="Url">
			
			<input type="date" name="DatePublished" value="" min="2013-11-27" max="<?php echo $currentDate ?>">
			
			<input type="submit" value="Submit">
		</form>
	</body>
</html>