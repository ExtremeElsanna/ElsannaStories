<?php
include("/hdd/elsanna-ssl/headers/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");

$errors = array(1 => "Unexpected Error :(",
				2 => "Title Not Given.",
				3 => "Author Not Given.",
				4 => "Story Already Submitted.",
				5 => "Length Not Given.",
				6 => "Story Type Not Given.",
				7 => "Complete Not Given.",
				8 => "Setting Not Given.",
				9 => "'Elsa Powers' Not Given.",
				10 => "'Anna Powers' Not Given.",
				11 => "Sisters Not Given.",
				12 => "Age Not Given.",
				13 => "Smut Prominence Not Given.",
				14 => "URL Not Given.",
				15 => "Date Published Not Valid.",
				16 => "Story Deleted from site");
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
			$headerRefer = '/submitstory/';
			include("/hdd/elsanna-ssl/classes/header.php");
			// Get current day, month and year
			date_default_timezone_set('UTC');
			$currentDay = date("d");
			$currentMonth = date("m");
			$currentYear = date("Y");
?>
<?php
			if (isset($_GET['code']) and is_numeric($_GET['code'])) {
				echo $errors[intval($_GET['code'])]."<br />\n";
			}
?>
		<form action="submit.php" method="post">
			Title<br />
			<input type="text" name="Title" value="" placeholder="Title"><br />
			<br />
			Author<br />
			<input type="text" name="Author" value="" placeholder="Author"><br />
			<br />
			Length (words)<br />
			<input type="number" name="Length" value="" min="1"><br />
			<br />
			Story Type<br />
			<input type="radio" name="StoryType" value="MC"> Multi-Chapter<br />
			<input type="radio" name="StoryType" value="OS"> One-Shot<br />
			<input type="radio" name="StoryType" value="OSS"> One-Shot Series<br />
			<br />
			Complete<br />
			<input type="radio" name="Complete" value="Y"> Yes<br />
			<input type="radio" name="Complete" value="N"> No<br />
			<input type="radio" name="Complete" value="U"> Unknown<br />
			<br />
			Setting<br />
			<input type="radio" name="Setting" value="C"> Canon<br />
			<input type="radio" name="Setting" value="AU"> Alternate Universe (AU)<br />
			<input type="radio" name="Setting" value="mAU"> Modern Alternate Universe (mAU)<br />
			<input type="radio" name="Setting" value="STP"> Same Time and Place (STP)<br />
			<input type="radio" name="Setting" value="U"> Unknown<br />
			<br />
			Elsa's Character<br />
			<input type="text" name="ElsaCharacter" value="" placeholder="Queen"><br />
			<br />
			Anna's Character<br />
			<input type="text" name="AnnaCharacter" value="" placeholder="Princess"><br />
			<br />
			Elsa's Powers<br />
			<input type="radio" name="ElsaPowers" value="C"> Canon<br />
			<input type="radio" name="ElsaPowers" value="D"> Different<br />
			<input type="radio" name="ElsaPowers" value="N"> None<br />
			<input type="radio" name="ElsaPowers" value="U"> Unknown<br />
			<br />
			Anna's Powers<br />
			<input type="radio" name="AnnaPowers" value="N"> No<br />
			<input type="radio" name="AnnaPowers" value="Y"> Yes<br />
			<br />
			Sisters<br />
			<input type="radio" name="Sisters" value="Y"> Yes<br />
			<input type="radio" name="Sisters" value="N"> No<br />
			<input type="radio" name="Sisters" value="U"> Unknown<br />
			<br />
			Age [<a href="https://www.fictionratings.com/">X</a>]<br />
			<input type="radio" name="Age" value="K"> K<br />
			<input type="radio" name="Age" value="KP"> K+<br />
			<input type="radio" name="Age" value="T"> T<br />
			<input type="radio" name="Age" value="M"> M<br />
			<br />
			Smut Prominence<br />
			<input type="radio" name="SmutLevel" value="N"> None<br />
			<input type="radio" name="SmutLevel" value="PL"> Plot Focused<br />
			<input type="radio" name="SmutLevel" value="L"> Light<br />
			<input type="radio" name="SmutLevel" value="M"> Medium<br />
			<input type="radio" name="SmutLevel" value="H"> Heavy<br />
			<input type="radio" name="SmutLevel" value="PU"> Pure<br />
			<br />
			URL of Story<br />
			<input type="text" name="Url" value="" placeholder="URL"><br />
			<br />
			Date Published<br />
			<select name="DayPublished">
<?php
					// Print all days and select current
					if ($currentDay == "01") {
						echo "<option value='01' selected>01</option>\n";
					} else {
						echo "<option value='01'>01</option>\n";
					}
					for ($i = 2; $i <= 31; $i ++) {
						if ($currentDay == str_pad($i, 2, '0', STR_PAD_LEFT)) {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						} else {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						}
					}
?>
			</select>
			<select name="MonthPublished">
<?php
					// Print all months and select current
					if ($currentMonth == "01") {
						echo "<option value='01' selected>01</option>\n";
					} else {
						echo "<option value='01'>01</option>\n";
					}
					for ($i = 2; $i <= 12; $i ++) {
						if ($currentMonth == str_pad($i, 2, '0', STR_PAD_LEFT)) {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						} else {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						}
					}
?>
			</select>
			<select name="YearPublished">
<?php
					// Print all years and select current
					if ($currentYear == "2013") {
						echo "<option value='2013' selected>2013</option>\n";
					} else {
						echo "<option value='2013'>2013</option>\n";
					}
					for ($i = 2013; $i <= intval($currentYear); $i ++) {
						if ($currentYear == str_pad($i, 2, '0', STR_PAD_LEFT)) {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						} else {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						}
					}
?>
			</select><br />
			<br />
			<input type="submit" value="Submit">
		</form>
	</body>
</html>