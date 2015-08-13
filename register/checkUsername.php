<?php
	$result = preg_match("/(?:.*[A].*)+/i",$_GET['string']);
	echo $result;
?>