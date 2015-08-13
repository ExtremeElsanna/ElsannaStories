<?php
	$result = preg_match("/[^\.\?]/",$_GET['string']);
	echo $result;
?>