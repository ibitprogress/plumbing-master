<?php include('../../configs/config.php'); $history = R::getAll("SELECT * FROM history ORDER BY id DESC LIMIT 50"); ?>
<?php if ($_SESSION): ?>
<?php if ($_SESSION['type'] == 'superadmin'): ?>

	
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="../../src/img/logo.png" type="image/x-icon">
		<title>LIST | History</title>
		<link rel="stylesheet" href="../../src/css/normalize.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="https://fonts.googleapis.com/css?family=Slabo+27px|Ubuntu" rel="stylesheet">
		<link rel="stylesheet" href="../../src/css/admin.css">
		
		
	</head>
	<body>
		<div class="admin-hidden-wrapper">
			<div class="admin-hidden-user-main col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
				<div class="admin-hidden-user-main-title"></div>
				<input type="number">
				<button class="admin-hidden-user-main-button">
					Зберегти
				</div>
			</div>
		</div>
		<div class="admin-header">
		    <div class="admin-header-hello">Привіт, <?=$_SESSION['username'];?>! <a href="../../apps/logout.php">Вийти</a></div>
		</div>
		<div class="admin-nav">
		    <ul class="hidden-sm hidden-xs">
		    	<a href="../orders.php"><li>Замовлення</li></a>
		    	<a href="../list/history.php" class="admin-nav-active-tab"><li>Історія</li></a>
		        <a href="../list/categories.php"><li>Категорії</li></a>
		        <a href="../list/goods.php"><li>Товари</li></a>
		        <a href="../list/users.php"><li>Користувачі</li></a>
		        <a href="../list/brands.php"><li>Бренди</li></a>
		        <a href="../currency.php"><li>Курс валют</li></a>
		    </ul>
		    <div class="admin-open-nav hidden-md hidden-lg" data-move='>'><i class="fa fa-cog" aria-hidden="true"></i></div>
		</div>
		<div class="admin-main">
			<div class="admin-main-content">
				<div class="admin-main-list-first">
					<div class="admin-main-list-actions-example">
						<div class="admin-main-list-action-change">Дата</div>
					</div>
					Ім'я Фамілія[Телефон]
				</div>
				<?php foreach ($history as $story): ?>
				<div class="admin-main-list-element">
					<div class="admin-main-list-actions">
						<?=$story['date'];?>
					</div>
					<br>
					<?=$story['story'];?>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="../../src/js/admin.js"></script>
	<script src="../../src/js/set_discount.js"></script>
	</body>
</html>	


<?php else: header("Location: ../index.php"); ?>
<?php endif; ?>
<?php else: header("Location: ../index.php"); ?>
<?php endif; ?>