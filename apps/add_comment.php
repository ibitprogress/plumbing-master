<?php 
	include('../configs/config.php');


	if($_POST){
		$user = $_SESSION['id'];
		$g_id = $_POST['g_id'];
		$message = $_POST['message'];
		if ($user and $g_id and $message){
			$messages = R::dispense('messages');
			$messages->user_who_commenting =$user;
			$messages->good_id = $g_id;
			$messages->comment = $message;
			R::store($messages);
			header('Location:../src/template/goods.php?goods='.$g_id);
		} else {
			header('Location:../index.php');
		}

	}



?>