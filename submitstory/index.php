<?php
include("../headers/utf8Headers.php");
include("../scripts/sessionHandler.php");
include("../headers/HTMLvariables.php");

$errors = array(1 => "Unexpected Error :(",
				2 => "Title Not Valid.",
				3 => "Author Not Valid.",
				4 => "Story Already Submitted.",
				5 => "Word Count Not Valid.",
				6 => "Story Type Not Valid.",
				7 => "Complete Not Valid.",
				8 => "Setting Not Valid.",
				9 => "'Elsa Powers' Not Valid.",
				10 => "'Anna Powers' Not Valid.",
				11 => "Sisters Not Valid.",
				12 => "Age Not Valid.",
				13 => "Smut Prominence Not Valid.",
				14 => "URL Not Valid.",
				15 => "Date Published Not Valid.",
				16 => "Story Deleted from Site",
				17 => "Chapters Not Valid.",
				18 => "Date Updated Not Valid.");
?>
<?php echo $doctype; ?>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
<?php
			// Include header in page
			$headerRefer = '/submitstory/';
			include("../classes/header.php");
			// Get current day, month and year
			date_default_timezone_set('UTC');
			$currentDay = date("d");
			$currentMonth = date("m");
			$currentYear = date("Y");
?>
<?php
			if (isset($_GET['code']) and is_numeric($_GET['code']) and isset($errors[intval($_GET['code'])])) {
				echo "\t\t".$errors[intval($_GET['code'])]."<br />\n";
			}
?>
		<form action="submit.php" method="post">
			Title<br />
			<input type="text" name="Title" value="" placeholder="Title"><br />
			<br />
			Author<br />
			<input type="text" name="Author" value="" placeholder="Author"><br />
			<br />
			Chapters<br />
			<input type="number" name="Chapters" value="" min="1"><br />
			<br />
			Words<br />
			<input type="radio" name="WordsRadio" value="Y">
			<input type="number" name="Words" value="" min="1"><br />
			<input type="radio" name="WordsRadio" value="U" checked> Unknown<br />
			<br />
			Story Type<br />
			<input type="radio" name="StoryType" value="MC"> Multi-Chapter<br />
			<input type="radio" name="StoryType" value="OS"> One-Shot<br />
			<input type="radio" name="StoryType" value="OSS"> One-Shot Series<br />
			<br />
			Complete<br />
			<input type="radio" name="Complete" value="Y"> Yes<br />
			<input type="radio" name="Complete" value="N"> No<br />
			<br />
			Setting<br />
			<input type="radio" name="Setting" value="C"> Canon<br />
			<input type="radio" name="Setting" value="AU"> Alternate Universe (AU)<br />
			<input type="radio" name="Setting" value="mAU"> Modern Alternate Universe (mAU)<br />
			<input type="radio" name="Setting" value="STP"> Same Time and Place (STP)<br />
			<input type="radio" name="Setting" value="U" checked> Unknown<br />
			<br />
			Elsa's Character<br />
			<input type="radio" name="ElsaCharacterRadio" value="Y">
			<input type="text" name="ElsaCharacter" value="" placeholder="Queen"><br />
			<input type="radio" name="ElsaCharacterRadio" value="U" checked> Unknown<br />
			<br />
			Anna's Character<br />
			<input type="radio" name="AnnaCharacterRadio" value="Y">
			<input type="text" name="AnnaCharacter" value="" placeholder="Princess"><br />
			<input type="radio" name="AnnaCharacterRadio" value="U" checked> Unknown<br />
			<br />
			Elsa's Powers<br />
			<input type="radio" name="ElsaPowers" value="C"> Canon<br />
			<input type="radio" name="ElsaPowers" value="D"> Different<br />
			<input type="radio" name="ElsaPowers" value="N"> None<br />
			<input type="radio" name="ElsaPowers" value="U" checked> Unknown<br />
			<br />
			Anna's Powers<br />
			<input type="radio" name="AnnaPowers" value="N"> No<br />
			<input type="radio" name="AnnaPowers" value="Y"> Yes<br />
			<input type="radio" name="AnnaPowers" value="U" checked> Unknown<br />
			<br />
			Sisters<br />
			<input type="radio" name="Sisters" value="Y"> Yes<br />
			<input type="radio" name="Sisters" value="C"> It's complicated<br />
			<input type="radio" name="Sisters" value="N"> No<br />
			<input type="radio" name="Sisters" value="U" checked> Unknown<br />
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
			<input type="radio" name="SmutLevel" value="U" checked> Unknown<br />
			<br />
			URL of Story<br />
			<input type="text" name="Url" value="" placeholder="URL"><br />
			<br />
			Date Published<br />
			<select name="DayPublished">
<?php
					// Print all days and select current
					for ($i = 1; $i <= 31; $i ++) {
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
					for ($i = 1; $i <= 12; $i ++) {
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
					for ($i = 2013; $i <= intval($currentYear); $i ++) {
						if ($currentYear == $i) {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						} else {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						}
					}
?>
			</select><br />
			<br />
			Date Updated<br />
			<input type="radio" name="DateUpdatedRadio" value="Y">
			<select name="DayUpdated">
<?php
					// Print all days and select current
					for ($i = 1; $i <= 31; $i ++) {
						if ($currentDay == str_pad($i, 2, '0', STR_PAD_LEFT)) {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						} else {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						}
					}
?>
			</select>
			<select name="MonthUpdated">
<?php
					// Print all months and select current
					for ($i = 1; $i <= 12; $i ++) {
						if ($currentMonth == str_pad($i, 2, '0', STR_PAD_LEFT)) {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						} else {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						}
					}
?>
			</select>
			<select name="YearUpdated">
<?php
					// Print all years and select current
					for ($i = 2013; $i <= intval($currentYear); $i ++) {
						if ($currentYear == $i) {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						} else {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						}
					}
?>
			</select><br />
			<input type="radio" name="DateUpdatedRadio" value="U" checked> Unknown<br />
			<input type="submit" value="Submit">
			<br />
			<br />
		</form>
	</body>
</html>
