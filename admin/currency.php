<?php include('../configs/config.php'); 

$usd_rate = R::getCell("SELECT usd FROM currency");
$eur_rate = R::getCell("SELECT eur FROM currency");

?>
<?php if ($_SESSION): ?>
<?php if ($_SESSION['type'] == 'superadmin'): ?>

	
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="../../src/img/logo.png" type="image/x-icon">
		<title>Currency</title>
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
		    	<a href="orders.php"><li>Замовлення</li></a>
		    	<a href="list/history.php"><li>Історія</li></a>
		        <a href="list/categories.php"><li>Категорії</li></a>
		        <a href="list/goods.php"><li>Товари</li></a>
		        <a href="list/users.php"><li>Користувачі</li></a>
		        <a href="list/brands.php"><li>Бренди</li></a>
		        <a href="currency.php" class="admin-nav-active-tab"><li>Курс валют</li></a>
		    </ul>
		    <div class="admin-open-nav hidden-md hidden-lg" data-move='>'><i class="fa fa-cog" aria-hidden="true"></i></div>
		</div>
		<div class="admin-main">
			<div class="admin-main-content">
				<form action="../../apps/currency.php" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="admin-main-new-goods-top">
						<div class="admin-main-new-goods-top-name col-lg-6 col-md-6 col-sm-12 col-xs-12" style="text-align: center;">
                            <div class="currency-label">Долар США</div>
							<input type="number" step="0.01" name="usd" value="<?=$usd_rate;?>" class="currency-input" style="text-align: center">
						</div>
						<div class="admin-main-new-goods-top-name col-lg-6 col-md-6 col-sm-12 col-xs-12" style="text-align: center;">
                            <div class="currency-label">Євро</div>
							<input type="number" step="0.01" name="eur" value="<?=$eur_rate;?>" class="currency-input" style="text-align: center">
						</div>
					</div>
				</div>
					<div class="admin-main-new-goods-submit">
						<button>Зберегти</button>
					</div>
				</form>
			</div>
		</div>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="../../src/js/admin.js"></script>
	<script src="../../src/js/checker.js"></script>
	</body>
</html>	


<?php else: header("Location: ../index.php"); ?>
<?php endif; ?>
<?php else: header("Location: ../index.php"); ?>
<?php endif; ?>
