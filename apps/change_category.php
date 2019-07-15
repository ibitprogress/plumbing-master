<?php include('../configs/config.php'); 
	if ($_POST) {
		if ($_SESSION and $_SESSION['type'] == "superadmin") {
			$categoryId = $_POST['categoryId'];
			$featurescount = $_POST['featurescount'];
			$optionscount = explode(",", $_POST['optionscount']);
			$oldNames = R::getAll("SELECT * FROM features WHERE category = ?", [$categoryId]);
			$namesUsed = [];
			for ($i = 0; $i < count($oldNames); $i++){
				$namesUsed[$i] = $oldNames[$i]['id'];
			}
			for ($i = 1; $i <= $featurescount; $i++ ) {
				$f = $_POST["feature".$i];
				if ($f != ""){
					if ($f != "" && $oldNames[$i-1]['feature'] == NULL) {
						array_shift($namesUsed);
						$feature = R::dispense("features");
						$feature->category = $categoryId;
						$feature->feature = $f;
						R::store($feature);
						$featureId = $feature->id;
					} elseif ( $f != "" && $oldNames[$i-1]['feature'] != NULL) {
						array_shift($namesUsed);
						if ($oldNames[$i-1]['feature'] != $f){
							R::exec( 'UPDATE features SET feature=? WHERE id = ?', [$f, $oldNames[$i-1]['id']] );
						}
						$featureId = $oldNames[$i-1]['id'];
					}
					$oldOptions = R::getAll("SELECT * FROM featureoptions WHERE category = ? AND feature = ?", [$categoryId, $featureId]);
					$oldOptionNames = [];
					for($a = 0; $a < count($oldOptions); $a++){
						$oldOptionNames[$a] = $oldOptions[$a]['id'];
					}
					for ($q = 1; $q <= $optionscount[$i-1]; $q++){
						$option = $_POST['feature'.$i.'option'.$q];
						if ($option != ""){
							if ($option != "" && $oldOptions[$q-1]['option'] == NULL){
								array_shift($oldOptionNames);
								$featureoptions = R::dispense("featureoptions");
								$featureoptions->category = $categoryId;
								$featureoptions->feature = $featureId;
								$featureoptions->option = $option;
								R::store($featureoptions);
							} elseif ($option != "" && $oldOptions[$q-1]['option'] != NULL){
								array_shift($oldOptionNames);
								R::exec( 'UPDATE featureoptions SET `option`=? WHERE id = ?', [$option, $oldOptions[$q-1]['id']] );
							}
						}
					}
					foreach($oldOptionNames as $__id){
						R::exec("DELETE FROM featureoptions WHERE id = ?", [$__id]);
						R::exec("DELETE FROM options WHERE `option` = ?", [$_id]);
					}
				}
			}
			foreach($namesUsed as $_id) {
				R::exec("DELETE FROM features WHERE id = ?", [$_id]);
				R::exec("DELETE FROM featureoptions WHERE feature = ?", [$_id]);
				R::exec("DELETE FROM options WHERE feature = ?", [$_id]);
			}
			header("Location:../admin/list/categories.php");
		} else {
			header("Location:../index.php");
		}
	} else {
		header("Location:../index.php");
	}