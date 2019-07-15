<?php 
	include('config.php');
	$password = $_GET['pass'];
	$admin = R::getRow("SELECT * FROM users WHERE username = 'admin'");
	if ($admin['username'] == NULL) {
		$user = R::dispense('users');
		$user->username = 'admin';
		$user->firstname = 'admin';
		$user->lastname = 'admin';
		$user->password = password_hash($password, PASSWORD_DEFAULT);
		$user->type = 'superadmin';
		$user->email = 'admin';
		$user->phone = 'admin';
		$user->discount = 0;
		R::store($user);
	} else {
		$user = R::load("users", $admin['id']);
		$user->password = password_hash($password, PASSWORD_DEFAULT);
		R::store($user);
	}
	header("Location: ../index.php");
?>