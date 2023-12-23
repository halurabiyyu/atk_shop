<?php 

if (isset($_GET['search'])) {
	$path = "pages/search/".$_GET['search'].".php";
	if (file_exists($path)) {
		require_once($path);
	}
	else {
		require_once("pages/404.php");
	}
}
else {
	require_once("pages/home.php");
}

 ?>