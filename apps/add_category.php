<?php include('../configs/config.php'); 
	if ($_POST) {
		if ($_SESSION and $_SESSION['type'] == "superadmin") {
			$name = $_POST['name'];
			if ( $name ){
				$category = R::dispense("categories");
				$category->category = $name;
				R::store($category);
				$categoryid = R::getCell("SELECT id FROM categories WHERE category = ?", [ $name ]);
				$featurescount = $_POST['featurescount'];
				$optionscount = explode(",", $_POST['optionscount']);
				for ($i = 1; $i <= $featurescount; $i++ ) {
					$f = $_POST["feature".$i];
					if ($f != "") {
						$feature = R::dispense("features");
						$feature->category = $categoryid;
						$feature->feature = $f;
						R::store($feature);
						$featureid = R::getCell("SELECT id FROM features WHERE feature = ? AND category = ?", [ $f, $categoryid ]);
						for ($q = 1; $q <= $optionscount[$i-1]; $q++) {
							$featureoptions = R::dispense("featureoptions");
							$featureoptions->category = $categoryid;
							$featureoptions->feature = $featureid;
							$featureoptions->option = $_POST['feature'.$i.'option'.$q];
							R::store($featureoptions);
						}
					}
				}
			}
			header("Location: ../admin/list/categories.php");
		} else {
			header("Location:../index.php");
		}
	} else {
		header("Location:../index.php");
	}