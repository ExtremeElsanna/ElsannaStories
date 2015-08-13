<?php
	$result = preg_match("/(?:.*[^\.].*)+/i",$_GET['string']);
	echo $result;
?>