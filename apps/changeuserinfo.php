<?php include('../configs/config.php'); 
    if ($_POST) {
		if ($_SESSION) {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            if ($firstname and $lastname and $phone and $email) {
                $user = R::load("users", $_SESSION['id']);
                $user->firstname = $firstname;
                $user->lastname = $lastname;
                $user->phone = $phone;
                $user->email = $email;
                if ($password != "") {
                    $user->password = password_hash($password, PASSWORD_DEFAULT);
                }
                R::store($user);
                $u = R::getRow("SELECT * FROM users WHERE id = ?", [ $_SESSION['id'] ]);
                $_SESSION = $u;
                header("Location: ../client/");
            }
        } else {
			header("Location: ../admin/");
		}
	} else {
		header("Location:../index.php");
	}