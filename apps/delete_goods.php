<?php include('../configs/config.php'); 

	if ($_GET) {
		if ($_SESSION and $_SESSION['type'] == "superadmin") {
			$goods = $_GET['goods'];
			R::exec("DELETE FROM goods WHERE id = ".$goods);
			header("Location:../admin/list/goods.php");
		} else {
			header("Location:../admin/");
		}
	} else {
		header("Location:../index.php");
	}