<?php
	$csv = array_map('str_getcsv', file('fruits.csv'));
	if ($_POST['home'] === "back to frontpage")
		header('Location: index.php');
	if (!$_POST['category'])
		$_POST['category'] = $_COOKIE['category'];
	if ($_POST['category'] === "all")
	{
		foreach($csv as $k)
		{
			$arr[] = "<div class=\"product\">\n\t<div class=\"name\"><p>".$k[0]."</p></div>\n\t<div class=\"image\"><img src=\"".$k[2]."\"></div>\n\t<div class=\"price\">price: ".$k[1]."</div>\n<form action=\"\" method=\"post\">\n\t<input type=\"submit\" name=\"submit\" value=\"Add ".$k[0]." to basket\"/>\n</form>\n</div>";
		}
		setcookie("category", "all", time() + 86400);
	}
	else if ($_POST['category'] === "fruits")
	{
		setcookie("category", "fruits", time() + 86400);
		foreach($csv as $k)
		{
			if ($k[3] == 1)
				$arr[] = "<div class=\"product\">\n\t<div class=\"name\"><p>".$k[0]."</p></div>\n\t<div class=\"image\"><img src=\"".$k[2]."\"></div>\n\t<div class=\"price\">price: ".$k[1]."</div>\n<form action=\"\" method=\"post\">\n\t<input type=\"submit\" name=\"submit\" value=\"Add ".$k[0]." to basket\"/>\n</form>\n</div>";
		}
	}
	else if ($_POST['category'] === "vegetables")
	{
		setcookie("category", "vegetables", time() + 86400);
		foreach($csv as $k)
		{
			if ($k[4] == 1)
				$arr[] = "<div class=\"product\">\n\t<div class=\"name\"><p>".$k[0]."</p></div>\n\t<div class=\"image\"><img src=\"".$k[2]."\"></div>\n\t<div class=\"price\">price: ".$k[1]."</div>\n<form action=\"\" method=\"post\">\n\t<input type=\"submit\" name=\"submit\" value=\"Add ".$k[0]." to basket\"/>\n</form>\n</div>";
		}
	}
	if ($_POST['submit'])
	{
		$arr = explode(' ', $_POST['submit']);
		$basket = array_map('str_getcsv', file('basket.csv'));
		foreach($csv as $k)
		{
			if ($k[0] === $arr[1])
			{
				$basket[] = $k;
				break ;
			}
		}
		$fp = fopen("basket.csv", "w");
			foreach ($basket as $fields)
			{
				fputcsv($fp, $fields);
			}
		fclose($fp);
		$category = $_POST['category'];
		header("Location: product_page.php");
	}
	/*<div class="product">
			<div class="name"><p>Test</p></div>
			<div class="image"><img src="https://creazilla-store.fra1.digitaloceanspaces.com/cliparts/26188/photorealistic-green-apple-clipart-md.png"></div>
			<div class="price"></div>
			<form action="" method="post">
				<button type="button" name="button">Add to basket</button>
			</form>
		</div>*/
?>
<html>
	<head>
		<link rel="stylesheet" href="product_page.css">
	</head>
	<body>
	<?php
		foreach ($arr as $k)
			echo $k;
		?>
		<div class="home">
		<form action="" method="post">
			<input type="submit" name="home" value="back to frontpage"/>
		</form>
		</div>
	</body>
</html>
