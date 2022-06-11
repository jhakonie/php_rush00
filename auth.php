<?php
	function auth($login, $passwd)
	{
		$file = unserialize(file_get_contents("./private/passwd"));
		foreach($file as $k)
		{
			if ($login === $k[0] && hash("sha512", $passwd) === $k[1])
				return true;
		}
		return false;
	}
	function check_admin($login, $passwd)
	{
		$file = unserialize(file_get_contents("./private/passwd"));
		foreach($file as $k)
		{
			if ($login == $k[0] && hash("sha512", $passwd) == $k[1])
			{
				if ($k[2] === true)
					return true;
			}
		}
		return false;
	}
?>
