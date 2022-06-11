<?php
	function change_key( $array, $old_key, $new_key ) {
		if( ! array_key_exists( $old_key, $array ) )
			return $array;
		$keys = array_keys( $array );
		$keys[ array_search( $old_key, $keys ) ] = $new_key;
		return array_combine( $keys, $array );
	}
	session_start();
	$file = unserialize(file_get_contents("./private/passwd"));
	foreach($file as $k)
	{
		if ($k[0] != $_SESSION['logged_user'] && $k[0] != "root")
			$arr[] = "<input type=\"submit\" name=\"submit\" value=\"Remove ".$k[0]." \"/><br />";
	}
	foreach($file as $k)
	{
		if ($k[0] != $_SESSION['logged_user'] && $k[2] === false)
			$admin[] = "<input type=\"submit\" name=\"add\" value=\"Add admin rights ".$k[0]." \"/><br />";
	}
	if ($_POST['home'] === "back to frontpage")
		header('Location: index.php');
	if ($_POST['submit'])
	{
		$submit = explode(' ', trim(preg_replace('/ /', ' ', $_POST['submit'])), 2);
		print_r($submit);
		for ($i = 0;$i < count($file);$i++)
		{
			if ($file[$i][0] == $submit[1])
			{
				unset($file[$i]);
				break ;
			}
		}
		foreach ($arr as &$k)
		{
			if (explode(' ', $k)[4] === $submit[1])
			{
				unset($k);
			}
		}
		foreach ($admin as &$k)
		{
			if (explode(' ', $k)[6] === $submit[1])
			{
				unset($k);
			}
		}
		$keys = array_keys($file);
		for ($i = 0;$i < count($keys);$i++)
		{
			$newfile[] = $file[$keys[$i]];
		}
		file_put_contents("./private/passwd", serialize($newfile));
		header('Location: manage_users.php');
	}
	if ($_POST['add'])
	{
		$submit = explode(' ', trim(preg_replace('/ /', ' ', $_POST['add'])), 4);
		for ($i = 0;$i < count($file);$i++)
		{
			if ($file[$i][0] == $submit[3])
			{
				$file[$i][2] = true;
				break ;
			}
		}
		for ($i = 0;$i < count($admin);$i++)
		{
			if (explode(' ', $admin[$i])[6] == $submit[3])
			{
				unset($admin[$i]);
				break ;
			}
		}
		$keys = array_keys($file);
		for ($i = 0;$i < count($keys);$i++)
		{
			$newfile[] = $file[$keys[$i]];
		}
		file_put_contents("./private/passwd", serialize($newfile));
		header('Location: manage_users.php');
	}
?>
<html>
	<head>
		<link rel="stylesheet" href="manage_users.css">
	</head>
	<div class="page">
		<div class="add_user">
			<body>
				<h2>Add User</h2>
				<form action ="create.php" method="POST">
					Username: <input type="text" name="login"/>
					<br />
					Password: <input type="password" name="passwd"/>
					<br />
					<input type="submit" name="submit" value="add"/>
				</form>
			</body>
		</div>
		<div class="remove_user">
			<body>
				<h2>Remove user</h2>
				<form action ="" method="POST">
					<?php
						foreach($arr as $k)
							echo $k;
					?>
				</form>
			</body>
		</div>
		<div class="add_admin">
			<body>
				<h2>Add admin rights</h2>
				<form action ="" method="POST">
					<?php
						foreach($admin as $k)
							echo $k;
					?>
				</form>
			</body>
		</div>
	</div>
	<div class="home">
		<form action="" method="post">
			<input type="submit" name="home" value="back to frontpage"/>
		</form>
		</div>
</html>
