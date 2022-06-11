<?php
	session_start();
	if (file_exists("fruits.csv"))
		unlink("fruits.csv");
	if (file_exists("orders.csv"))
		unlink("orders.csv");
	if (file_exists("basket.csv"))
		unlink("basket.csv");
	$arr = "apple,0.7€,https://creazilla-store.fra1.digitaloceanspaces.com/cliparts/26188/photorealistic-green-apple-clipart-md.png,1,0\npineapple,0.9€,https://upload.wikimedia.org/wikipedia/commons/b/ba/Pineapple_clip_art.png,1,0\ncoconut,10€,https://upload.wikimedia.org/wikipedia/commons/8/8d/Coconut_Clipart_Cartoon.png,1,0\nbroccoli,1€,https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQMgS-_SWzAahq7AgnF0cdQS-4SvU8nz00WVg&usqp=CAU,0,1\ncarrot,0.5€,https://creazilla-store.fra1.digitaloceanspaces.com/cliparts/13203/carrot-vegetable-clipart-md.png,0,1\ntomato,0.3€,https://cdn.pixabay.com/photo/2017/01/31/21/56/food-2027563__340.png,1,1\n";
	file_put_contents("fruits.csv", $arr);
	if (file_exists("./private/passwd"))
		unlink("./private/passwd");
	$file = unserialize(file_get_contents("./private/passwd"));
	$root[] = "root";
	$root[] = hash("sha512", "root");
	$root[] = true;
	$file[] = $root;
	file_put_contents("./private/passwd", serialize($file));
	$_SESSION['logged_user'] = "";
	Header('Location: index.php');
?>
