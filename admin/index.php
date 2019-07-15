<?php include('../configs/config.php'); 

if ($_SESSION):
    if ($_SESSION['type'] == "superadmin") {
        header("Location: list/history.php");
    } elseif ($_SESSION['type'] == "client") {
    	header("Location: ../client/");
    }

?>

<?php else: ?>

<!DOCTYPE html>
<html>
	<head>
	    <meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="../src/img/logo.png" type="image/x-icon">
	    <title>Sign in</title>
	    <link rel="stylesheet" href="../src/css/normalize.css">
	    <link rel="stylesheet" href='../src/css/signin.css'>
	    <link href="https://fonts.googleapis.com/css?family=Slabo+27px|Ubuntu" rel="stylesheet">
	</head>
	<body>

	<div class="login-main">
	    <div class="login-form-main">
	        <div class="login-form-inputs">
	            <form method="post" action="../apps/adminsignin.php">
	                <input type="text" placeholder="Ім'я" id="id_username" name="username">
	                <input type="password" placeholder="Пароль" id="id_password" name="password">
	                <button id="id_submit" type="submit">Ввійти</button>
	            </form>
	        </div>
	    </div>
	</div>

	<?php if($_GET['wrong'] == 'username'): ?>
		<div id="error-info">
            Такого користувача не існує
        </div>
	<?php elseif($_GET['wrong'] == 'password'): ?>
		<div id="error-info">
            Неправильний пароль
        </div>
	<?php endif; ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>	

	<script type="text/javascript" src='../src/js/signin.js'></script>
	</body>
</html>
<?php endif; ?>