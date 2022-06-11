<?php
	include "auth.php";
	session_start();
	if (auth($_POST['login'], $_POST['passwd']))
	{
		if (check_admin($_POST['login'], $_POST['passwd']))
			$_SESSION['admin'] = true;
		else
			$_SESSION['admin'] = false;
		$_SESSION['logged_user'] = $_POST['login'];
		header("Location: index.php");
	}
	else
	{
		$_SESSION['logged_user'] = "";
		header("Location: index.php");
	}
?>
