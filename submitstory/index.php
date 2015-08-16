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
			$headerRefer = '/submitstory/';
			include("/hdd/elsanna-ssl/classes/header.php");
			date_default_timezone_set('UTC');
			$currentDate = date("Y-m-d");
		?>
		
		<form action="submit.php" method="post">
			<input type="text" name="Title" value="" placeholder="Title"><br>
			
			<input type="text" name="Author" value="" placeholder="Author"><br>
			
			<input type="number" name="Length" value="" min="1"><br>
			
			<input type="radio" name="StoryType" value="Multi-Chapter"><br>
			<input type="radio" name="StoryType" value="One-Shot"><br>
			<input type="radio" name="StoryType" value="One-Shot Series"><br>
			
			<input type="radio" name="Complete" value="Yes"><br>
			<input type="radio" name="Complete" value="No"><br>
			<input type="radio" name="Complete" value="Unknown"><br>
			
			<input type="radio" name="Setting" value="Canon"><br>
			<input type="radio" name="Setting" value="Alternate Universe (AU)"><br>
			<input type="radio" name="Setting" value="Modern Alternate Universe (mAU)"><br>
			<input type="radio" name="Setting" value="Same Time and Place (STP)"><br>
			<input type="radio" name="Setting" value="Unknown"><br>
			
			<input type="text" name="ElsaCharacter" value="" placeholder="Elsa's Character"><br>
			
			<input type="text" name="AnnaCharacter" value="" placeholder="Anna's Character"><br>
			
			<input type="radio" name="ElsaPowers" value="Canon"><br>
			<input type="radio" name="ElsaPowers" value="Different"><br>
			<input type="radio" name="ElsaPowers" value="None"><br>
			<input type="radio" name="ElsaPowers" value="Unknown"><br>
			
			<input type="radio" name="AnnaPowers" value="No"><br>
			<input type="radio" name="AnnaPowers" value="Yes"><br>
			
			<input type="radio" name="Sisters" value="Yes"><br>
			<input type="radio" name="Sisters" value="No"><br>
			<input type="radio" name="Sisters" value="Unknown"><br>
			
			<input type="radio" name="Age" value="K"><br>
			<input type="radio" name="Age" value="K+"><br>
			<input type="radio" name="Age" value="T"><br>
			<input type="radio" name="Age" value="M"><br>
			
			<input type="radio" name="SmutLevel" value="None"><br>
			<input type="radio" name="SmutLevel" value="Plot Focused"><br>
			<input type="radio" name="SmutLevel" value="Light"><br>
			<input type="radio" name="SmutLevel" value="Medium"><br>
			<input type="radio" name="SmutLevel" value="Heavy"><br>
			<input type="radio" name="SmutLevel" value="Pure"><br>
			
			<input type="text" name="Url" value="" placeholder="URL"><br>
			
			<input type="date" name="DatePublished" value="" min="2013-11-27" max="<?php echo $currentDate ?>"><br>
			
			<input type="submit" value="Submit">
		</form>
	</body>
</html>