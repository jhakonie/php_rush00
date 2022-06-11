<?php
	$csv = array_map('str_getcsv', file('fruits.csv'));
	foreach($csv as $k)
	{
		$arr[] = "<div class=\"product\">\n\t<div class=\"name\"><p>".$k[0]."</p></div>\n\t<div class=\"image\"><img src=\"".$k[2]."\"></div>\n\t<div class=\"price\">price: ".$k[1]."</div>\n\t\n<form action=\"modify_products.php\" method=\"POST\">\n<input style=\"max-width: 45px;\"type=\"text\" name=\"name\" value=\"\"/>\n<input type=\"submit\" name=\"submit\" value=\"change ".$k[0]."\"/>\n</form>\n</div>";
	}
	if ($_POST['add'])
	{
		if (!$_POST['name'] || !$_POST['price'] || !$_POST['image']
		|| !$_POST['category'] || !is_numeric($_POST['price']) ||
		($_POST['category'] != "fruits" && $_POST['category'] != "vegetables" && $_POST['category'] != "both"))
			$error = "Invalid in put while adding new product, please re-read the instructions.";
		else
		{
			if ($_POST['category'] != "both")
			{
				$vege = $_POST['category'] === "vegetables" ? 1 : 0;
				$fruit = $_POST['category'] === "fruits" ? 1 : 0;
			}
			else
			{
				$vege = 1;
				$fruit = 1;
			}
			$arr = array($_POST['name'], $_POST['price'], $_POST['image'], $fruit, $vege);
			$csv[] = $arr;
			$fp = fopen("fruits.csv", "w");
				foreach ($csv as $fields)
				{
					fputcsv($fp, $fields);
				}
			fclose($fp);
			header('Location: modify_products.php');
		}
	}
	else if ($_POST['submit'])
	{
		$arr = explode(' ', $_POST['submit']);
		if (is_numeric($_POST['name']))
		{
			foreach($csv as &$k)
			{
				if ($arr[1] === $k[0])
				{
					$k[1] = $_POST['name'] . "€";
				}
			}
			$fp = fopen("fruits.csv", "w");
			foreach ($csv as $fields)
			{
				fputcsv($fp, $fields);
			}
			fclose($fp);
		}
		else if ($_POST['name'] === "vegetables" || $_POST['name'] === "fruits" || $_POST['name'] === "both")
		{
			$arr = explode(' ', $_POST['submit']);
			foreach($csv as &$k)
			{
				if ($arr[1] === $k[0])
				{
					if ($_POST['name'] != "both")
					{
						$k[3] = $_POST['name'] === "vegetables" ? 0 : 1;
						$k[4] = $_POST['name'] === "fruits" ? 0 : 1;
					}
					else
					{
						$k[3] = 1;
						$k[4] = 1;
					}
				}
			}
			$fp = fopen("fruits.csv", "w");
			foreach ($csv as $fields)
			{
				fputcsv($fp, $fields);
			}
				fclose($fp);
		}
		else if ($_POST['name'] === "remove")
		{
			foreach($csv as &$k)
			{
				if ($arr[1] === $k[0])
				{
					$k = "";
					break ;
				}
			}
			$fp = fopen("fruits.csv", "w");
			foreach ($csv as $fields)
			{
				fputcsv($fp, $fields);
			}
			fclose($fp);
		}
		header('Location: modify_products.php');
	}
	if ($_POST['home'] === "back to frontpage")
		header('Location: index.php');
	/*<div class="product">
			<div class="name"><p>Test</p></div>
			<div class="image"><img src="https://creazilla-store.fra1.digitaloceanspaces.com/cliparts/26188/photorealistic-green-apple-clipart-md.png"></div>
			<div class="price"></div>
			<form action="" method="POST">
				<input type="text" name="new price"/>
				<input type="submit" name="submit" value="change €"/>
			</form>
		</div>*/
		//<link rel="stylesheet" href="product_page.css">
?>
<html>
	<head>
		<link rel="stylesheet" href="product_page.css">
	</head>
	<div class="sreen">
		<?php
			foreach ($arr as $k)
				echo $k;
				?>
			<div class="bottom_panel">
				<p>Enter new price in form to update product price</p>
				<p>To change category of product enter: 'vegetables', 'fruits' or 'both'</p>
				<p>To remove product enter 'remove' in product change box</p>
				<p>To add new product enter details of the new product: name / price / image / category</p>
				<form action="" method="POST">
					<input type="text" name="name"/>
					<input type="text" name="price"/>
					<input type="text" name="image"/>
					<input type="text" name="category"/>
					<input type="submit" name="add" value="add"/>
				</form>
				<p style="color: red;"><?php echo $error;?></p>
				<div class="home">
				<form action="" method="post">
					<input type="submit" name="home" value="back to frontpage"/>
				</form>
				</div>
			</div>
		</div>
	<body>
	</body>
</html>
