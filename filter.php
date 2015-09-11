<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	$getParams = "";
	foreach ($_POST as $key => $param) {
		echo $key." : ".$param."<br>";
		$encParam = bin2hex(mb_convert_encoding($param, 'UCS-2', 'UTF-8'))
		switch ($key) {
			case "Title":
				$getParams = $getParams."sTitle=".$encParam."&"
				break;
			case "Author":
				$getParams = $getParams."sAuthor=".$encParam."&"
				break;
			case "Length":
				$getParams = $getParams."sLength=".$encParam."&"
				break;
			case "ElsaCharcter":
				$getParams = $getParams."sEChar=".$encParam."&"
				break;
			case "AnnaCharcter":
				$getParams = $getParams."sAChar=".$encParam."&"
				break;
			case "DayPublished":
				if (isset($_POST['MonthPublished']) and isset($_POST['YearPublished'])) {
					$encParam = strtotime ( $_POST['DayPublished']."/".$_POST['MonthPublished']."/".$_POST['YearPublished']);
					$getParams = $getParams."sDate=".$encParam."&"
				}
				break;
		}
	}
	echo $getParams;
	die;
	header("Location: /?search=".$_POST['search']);
?>