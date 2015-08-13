<?php
	$result = preg_match("/(?:.*[^abcdefghijklmnopqrstuvwxyz0123456789].*)+/i",$_GET['string']);
	echo $result;
?>