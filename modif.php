<?php
	function find_And_Modify($arr, $name, $newpw)
	{
		foreach($arr as &$k)
		{
			if ($k[0] === $name)
			{
				$k[1] = $newpw;
				return $arr;
			}
		}
		return $arr;
	}
	function check_If_Exists($arr, $name, $index)
	{
		foreach($arr as $k)
		{
			if ($k[$index] === $name)
				return false;
		}
		return true;
	}
	if ($_POST['submit'] === "OK")
	{
		$file = unserialize(file_get_contents("./private/passwd"));
		if (!$_POST['oldpw']
		|| !$_POST['newpw'] || !$_POST['login'] || check_If_Exists($file, $_POST['login'], 0)
		|| check_If_Exists($file, hash("sha512", $_POST['oldpw']), 1))
		{
			echo "Wrong username or password\n";
		}
		else
		{
			$file = find_And_Modify($file, $_POST['login'], hash("sha512", $_POST['newpw']));
			file_put_contents("./private/passwd", serialize($file));
			header('Location: index.php');
		}
	}
	else
		echo "Enter username, old password and new password."
?>
<html>
	<body>
		<form action="modif.php" method="POST">
			Username: <input type="text" name="login"/><br />
			Old password: <input type="password" name="oldpw" value=""/><br />
			New password: <input type="password" name="newpw" value=""/><br />
			<input type="submit" name="submit" value="OK"/>
		</form>
	</body>
</html>
