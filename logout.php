<?php
	session_start();
	$_SESSION['logged_user'] = "";
	header("Location: index.php");
?>
