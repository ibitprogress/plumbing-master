<?php include('../configs/config.php'); 

	if ($_POST) {
		if ($_SESSION and $_SESSION['type'] == "superadmin") {
			$userid = $_POST['user'];
			$user = R::load('users', $userid);
			$user->discount = $_POST['discount'];
			R::store($user);
		} else {
			echo "Fuck out";
		}
	} else {
		header("Location:../index.php");
	}