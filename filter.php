<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	$getParams = "";
	$storyType = "";
	foreach ($_POST as $key => $param) {
		echo $key." : ".$param."<br>";
		$encParam = bin2hex(mb_convert_encoding($param, 'UCS-2', 'UTF-8'));
		switch ($key) {
			case "Title":
				$getParams = $getParams."sTitle=".$encParam."&";
				break;
			case "Author":
				$getParams = $getParams."sAuthor=".$encParam."&";
				break;
			case "Length":
				$getParams = $getParams."sLength=".$encParam."&";
				break;
			case "StoryType1":
				$storyType = $storyType."MC,";
				break;
			case "StoryType2":
				$storyType = $storyType."OS,";
				break;
			case "StoryType3":
				$storyType = $storyType."OSS,";
				break;
			case "ElsaCharcter":
				$getParams = $getParams."sEChar=".$encParam."&";
				break;
			case "AnnaCharcter":
				$getParams = $getParams."sAChar=".$encParam."&";
				break;
			case "DayPublished":
				if (isset($_POST['MonthPublished']) and isset($_POST['YearPublished'])) {
					$encParam = bin2hex(mb_convert_encoding(strtotime ( $_POST['DayPublished']."/".$_POST['MonthPublished']."/".$_POST['YearPublished']), 'UCS-2', 'UTF-8'));
					$getParams = $getParams."sDate=".$encParam."&";
				}
				break;
		}
	}
	$getParams .= mb_substr($storyType, 0, -1, null, "UTF-8")."&";
	echo $getParams;
	die;
	header("Location: /?search=".$_POST['search']);
?>