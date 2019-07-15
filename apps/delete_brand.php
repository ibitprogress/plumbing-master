<?php include('../configs/config.php'); 

	if ($_GET) {
		if ($_SESSION and $_SESSION['type'] == "superadmin") {
			$brand = $_GET['brand'];
			R::exec("DELETE FROM brands WHERE id = ".$brand);
			header("Location:../admin/list/brands.php");
		} else {
			header("Location:../admin/");
		}
	} else {
		header("Location:../index.php");
	}