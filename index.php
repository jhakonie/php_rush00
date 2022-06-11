<?php
	session_start();
	$basket = array_map('str_getcsv', file('basket.csv'));
	$basket_header = "BASKET";
	foreach($basket as $k)
	{
		$basket_name[] = $k[0]. ": ".$k[1];
		$total += (float)$k[1];
	}
	$basket_name = array_count_values($basket_name);
	foreach ($basket_name as $key => $value)
	{
		$arr[] = "<div class=\"name\"><p>".$value. " x ".$key."</p></div>";
	}
	if ($_POST['submit'] === "validate")
	{
		$basket_header = "Order validated, thank you for your order!";
		foreach($basket as $k)
		{
			$order_row .= implode(',', $k) . ",";
		}
		$order_row .= "\n";
		file_put_contents("orders.csv", $order_row, FILE_APPEND);
		unlink("basket.csv");
	}
	if ($_POST['submit'] === "clear")
	{
		unlink("basket.csv");
		header('Location: index.php');
	}
?>
<html>
	<head>
	<link rel="stylesheet" href="index.css">
	</head>
	<body>
	<h1 style="text-align: center;">FRUIT MARKET</h1>
	<div class="panel">
		<div class="left_panel">
		<?php
			if (!$_SESSION['logged_user'] || $_SESSION['logged_user'] === "")
			{
				?>
			<form action="login.php" method="post">
				Username: <input type="text" name="login" value=""/>
				<br />
				Password: <input type="password" name="passwd" value=""/>
				<br />
				<input type="submit" name="submit" value="OK"/>
				<br />
				<a href="create.php">Create account</a>
			</form>
			<?php
			}
			else
			{
				echo "<h2>Logged in as:<h2>".$_SESSION['logged_user']."</h2></h2>";
				?>
				<a href="modif.php">Change password</a>
				<br />
				<a href="logout.php">Logout</a>
				<br />
				<?php
				if ($_SESSION['admin'] === true)
				{
					?>
					<div class="admin_settings">
						<h2 class="id">Admin settings:</h2>
						<a href="view_orders.php">View orders</a><br />
						<a href="modify_products.php">Modify products</a><br />
						<a href="manage_users.php">Manage users</a><br />
						<a href="install.php">Reset webstore</a><br />
					</div>
					<?php
				}
			}
			?>
			<div class="basket">
				<?php
					echo "<h2>$basket_header</h2>";
					if ($basket_header === "BASKET" && $total)
					{
						foreach ($arr as $k)
							echo $k;
						echo "<h2>total cost:</h2>";
						echo $total."€";
						?>
						<form action="" method="post">
						<?php
						if ($_SESSION['logged_user'] != "")
						{
							?>
								<br/><input type="submit" name="submit" value="validate"/>
							<?php
						}
						?>
							<br/><input type="submit" name="submit" value="clear"/>
						</form>
						<?php
					}
				?>
			</div>
		</div>
		<div class="center_panel">
			<h2>Browse by category</h2>
			<form action="product_page.php" method="POST">
				<div class="fruits">
					<img src="https://creazilla-store.fra1.digitaloceanspaces.com/cliparts/13476/fruits-food-clipart-md.png" alt="fruits"/><br/>
					<input type="submit" name="category" value="fruits"/>
				</div>
				<div class="vegetables">
					<img src="https://creazilla-store.fra1.digitaloceanspaces.com/cliparts/13178/vegetables-food-clipart-md.png" alt="fruits"/><br/>
					<input type="submit" name="category" value="vegetables"/>
				</div>
				<div class="all">
					<img src="https://creazilla-store.fra1.digitaloceanspaces.com/cliparts/13241/fruits-vegetables-food-clipart-md.png" alt="fruits"/><br/>
					<input type="submit" name="category" value="all"/>
				</div>
			</form>
		</div>
	</div>
	</body>
</html>
