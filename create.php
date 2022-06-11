<?php
	function check_Duplicate($arr, $name)
	{
		foreach($arr as $k)
		{
			if ($k[0] === $name)
				return false;
		}
		return true;
	}
	if ($_POST['submit'] === "OK" || $_POST['submit'] === "add")
	{
		if (!$_POST['passwd'] ||
		$_POST['passwd'] == "" || !$_POST['login'] || $_POST['login'] == "")
		{
			echo "Username or password missing.\n";
		}
		else
		{
			if (!file_exists("./private/"))
				mkdir("./private/");
			$file = array();
			$file = unserialize(file_get_contents("./private/passwd"));
			if (!check_Duplicate($file, $_POST['login']))
			{
				echo "This username is already taken.\n";
			}
			else
			{
				$arr[] = $_POST['login'];
				$arr[] = hash("sha512", $_POST['passwd']);
				$arr[] = false;
				$file[] = $arr;
				$file = serialize($file);
				file_put_contents("./private/passwd", $file);
				if ($_POST['submit'] === "OK")
					header('Location: index.php');
				else
					header('Location: manage_users.php');
			}
		}
	}
	else
		echo "Enter username and password.\n";
?>
<html>
	<body>
		<form action ="create.php" method="POST">
			Username: <input type="text" name="login"/>
			<br />
			Password: <input type="password" name="passwd"/>
			<br />
			<input type="submit" name="submit" value="OK"/>
		</form>
	</body>
</html>
