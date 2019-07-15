<?php include('../configs/config.php'); 

	if ($_POST) {
		if ($_SESSION and $_SESSION['type'] == "superadmin") {
			$order = R::getRow("SELECT * FROM orders where id = ?", [$_POST['id']]);
			if ($order['id'] == NULL) {
				$data = "error";
				echo json_encode($data);
			} else {
				$order['basket'] = unserialize($order['basket']);
            	echo json_encode($order);
			}
		} else {
		    header("Location:../index.php");
		}
	} else {
		header("Location:../index.php");
	}