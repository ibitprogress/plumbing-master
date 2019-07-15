<?php 
	include('../configs/config.php');

	if ($_POST){
		$name = $_POST['name'];
		$lastname = $_POST['lastname'];
		$pass = $_POST['password'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		if ($name and $lastname and $pass and $email and $phone ){
			$user = R::dispense('users');
			$user->firstname = $name;
			$user->lastname = $lastname;
			$user->password = password_hash($pass, PASSWORD_DEFAULT);
			$user->type = 'client';
			$user->email = $email;
			$user->phone = $phone; 
			$user->discount = 0; 
			R::store($user);
			$userdb = R::getRow("SELECT * FROM users WHERE email = ?", [$email]);
			$_SESSION = $userdb;
			header('Location:../index.php');
		} else {
			header('Location:signup.php');
		}

	} else {
		header('Location:../index.php');
	}
?>