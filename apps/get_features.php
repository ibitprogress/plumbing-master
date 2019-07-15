<?php include('../configs/config.php'); 

	if ($_POST) {
		if ($_SESSION and $_SESSION['type'] == "superadmin") {
			$categoryid = $_POST['category'];
            $features = R::getAll("SELECT * FROM features WHERE category = ?", [ $categoryid ]);
            $options = [];
            foreach($features as $feature) {
                $featurearr = [];
                $optionsdb = R::getAll("SELECT * FROM featureoptions WHERE feature = ? AND category = ?", [$feature['id'], $categoryid]);
                foreach($optionsdb as $o) {
                    $featurearr[] = $o;
                }
                $options[] = $featurearr;
            }
            $vars = [$features, $options];
            echo json_encode($vars);
		} else {
		    header("Location:../index.php");
		}
	} else {
		header("Location:../index.php");
	}