<?php 
	if ($_POST){
		$phone = $_POST['phone'];

		if ($phone){
			mail('turupuru8@gmail.com','Зворотній дзвінок',$phone);
			header('Location:../index.php');
		}
	}
	
	
	
?>