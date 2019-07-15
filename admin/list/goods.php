<?php include('../../configs/config.php'); $goods = R::getAll("SELECT * FROM goods ORDER BY name ASC"); ?>
<?php if ($_SESSION): ?>
<?php if ($_SESSION['type'] == 'superadmin'): ?>

	
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="../../src/img/logo.png" type="image/x-icon">
		<title>LIST | Goods</title>
		<link rel="stylesheet" href="../../src/css/normalize.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="https://fonts.googleapis.com/css?family=Slabo+27px|Ubuntu" rel="stylesheet">
		<link rel="stylesheet" href="../../src/css/admin.css">
		
		
	</head>
	<body>
		
		<div class="admin-header">
		    <div class="admin-header-hello">Привіт, <?=$_SESSION['username'];?>! <a href="../../apps/logout.php">Вийти</a></div>
		</div>
		<div class="admin-nav">
		    <ul class="hidden-sm hidden-xs">
		    	<a href="../orders.php"><li>Замовлення</li></a>
		    	<a href="../list/history.php"><li>Історія</li></a>
		        <a href="../list/categories.php"><li>Категорії</li></a>
		        <a href="../list/goods.php" class="admin-nav-active-tab"><li>Товари</li></a>
		        <a href="../list/users.php"><li>Користувачі</li></a>
		        <a href="../list/brands.php"><li>Бренди</li></a>
		        <a href="../currency.php"><li>Курс валют</li></a>
		    </ul>
		    <div class="admin-open-nav hidden-md hidden-lg" data-move='>'><i class="fa fa-cog" aria-hidden="true"></i></div>
		</div>
		<div class="admin-main">
			<div class="admin-main-content">
				<div class="admin-main-add">
					<a href="../add/goods.php"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
				</div>
				<div class="admin-main-list-first">
					Назва
					<div class="admin-main-list-actions-example admin-main-list-actions-example-g">
						<div class="admin-main-list-action-change">Редагувати</div>
						<div class="admin-main-list-action-delete">Видалити</div>
					</div>
				</div>
				<?php foreach($goods as $g): ?>
				<div class="admin-main-list-element">
					<?=$g['name'];?>
					<div class="admin-main-list-actions admin-main-list-actions-g">
						<a href="../change/goods.php?goods=<?=$g['id'];?>"><div class="admin-main-list-action-change"><i class="fa fa-pencil" aria-hidden="true"></i></div></a>
						<a href="../../apps/delete_goods.php?goods=<?=$g['id'];?>"><div class="admin-main-list-action-delete"><i class="fa fa-trash-o" aria-hidden="true"></i></div></a>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="../../src/js/admin.js"></script>
	</body>
</html>	


<?php else: header("Location: ../index.php"); ?>
<?php endif; ?>
<?php else: header("Location: ../index.php"); ?>
<?php endif; ?>
