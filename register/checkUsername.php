<?php
	$result = preg_match("/(?:.*[^ABC].*)*/i",$_GET['string']);
	echo $result;
?>