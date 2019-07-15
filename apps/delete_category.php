<?php include('../configs/config.php'); 

	if ($_GET) {
		if ($_SESSION and $_SESSION['type'] == "superadmin") {
			$category = $_GET['category'];
			R::exec("DELETE FROM categories WHERE id = ".$category);
			$features = R::getAll("SELECT id FROM features WHERE category = ?", [$category]);
			foreach($features as $feature){
				R::exec("DELETE FROM options WHERE feature = ?", [$feature['id']]);
			}
			R::exec("DELETE FROM features WHERE category = ?", [$category]);
			R::exec("DELETE FROM featureoptions WHERE category = ?", [$category]);
			header("Location:../admin/list/categories.php");
		} else {
			header("Location:../admin/");
		}
	} else {
		header("Location:../index.php");
	}