<?php 
	include('../configs/config.php');

	if ($_POST) {
        $user_exist = false;
		$users = R::getAll( 'SELECT * FROM users');
		$email = $_POST['email'];
        $password = $_POST['password'];
        foreach ( $users as $u ) {
            if ( strtolower($u['email']) == strtolower($email) ) {
                $user = $u;
                $user_exist = true;
            }
        }
        if ($user_exist == true) {
            if (password_verify($password, $user['password'])) {
                $_SESSION = $user;
                echo json_encode("success");
            } else {
                echo json_encode("wrongpassword");
            }
        } else {
            echo json_encode("wronguser");
        }
	}

?>