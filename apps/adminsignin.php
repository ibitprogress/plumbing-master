<?php 
	include('../configs/config.php');

	if ($_POST) {
        $user_exist = false;
		$users = R::getAll( 'SELECT * FROM users');
		$username = $_POST['username'];
        $password = $_POST['password'];
        foreach ( $users as $u ) {
            if ( strtolower($u['username']) == strtolower($username) ) {
                $user = $u;
                $user_exist = true;
            }
        }
        if ($user_exist == true) {
            if (password_verify($password, $user['password'])) {
                $_SESSION = $user;
                header("Location: ../admin/index.php");
            } else {
                header("Location: ../admin/index.php?wrong=password");
            }
        } else {
            header("Location: ../admin/index.php?wrong=username");
        }
	}

?>