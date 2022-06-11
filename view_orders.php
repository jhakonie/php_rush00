<?php
	$orders = array_map('str_getcsv', file('orders.csv'));
	$counter = 1;
	foreach ($orders as $k)
	{
		$arr[] = "<input type=\"submit\" name=\"submit\" value=\"order ".$counter."\"/>";
		$counter++;
	}
	if ($_POST['home'] === "back to frontpage")
		header('Location: index.php');
	if ($_POST['submit'])
	{
		$index = explode(' ', $_POST['submit']);
		$order_row = $orders[$index[1] - 1];
	}
?>
<html>
	<head>
	</head>
	<body>
		<form action="" method="post">
			<?php
				foreach ($arr as $k)
					echo $k."<br/>";
			?>
		</form>
		<div class="order">
			<?php
				echo "<h2>order ".$index[1]."</h2>";
				$total = 0;
				for ($i = 0;count($order_row) > $i; $i += 5)
				{
					if ($order_row[$i])
					{
						echo "<p>".$order_row[$i].": ".$order_row[$i + 1]."</p>";
						$total += $order_row[$i + 1];
					}
				}
				echo "<h2>Total: ".$total."€</h2>";
			?>
		</div>
		<div class="home" style="position:absolute;, bottom:5;, left:20;">
		<form action="" method="post">
			<input type="submit" name="home" value="back to frontpage"/>
		</form>
		</div>
	</body>
</html>
