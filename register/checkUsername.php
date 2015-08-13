<?php
	$result = preg_match("/(?:.*[^abcdefghijklmnopqrstuvwxyz01234567890\@\#\!\£\$\%\^\&\*\(\)].*)+/i",$_GET['string']);
	echo $result;
?>