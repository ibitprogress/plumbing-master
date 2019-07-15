<?php include('../../configs/config.php'); 
$categories = R::getAll("SELECT * FROM categories");
$brands = R::getAll("SELECT * FROM brands") ?>
<?php if ($_SESSION): ?>
<?php if ($_SESSION['type'] == 'superadmin'): ?>

	
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="../../src/img/logo.png" type="image/x-icon">
		<title>ADD | Goods</title>
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
				<form action="../../apps/add_goods.php" method="POST" enctype="multipart/form-data">
					<input id="countimages" type="number" hidden value="1">
					<div class="admin-main-new-goods-top">
						<div class="admin-main-new-goods-top-name">
							<input type="text" placeholder="Назва товару" name="name">
						</div>
						<div class="admin-main-new-goods-top-cost">
							<input type="number" step="0.01" placeholder="Ціна" name="cost">
						</div>
						<br><br>
						<div class="admin-main-new-goods-top-cost">
							<label class="foris" for="is">Присутній на складі</label>
							<input type="checkbox" id="is" name="storage">
						</div>
					</div>
					<textarea name="description" style="resize: none"></textarea>
					<div class="admin-main-new-goods-bot">
						<div class="admin-main-new-goods-bot-picture">
							<label for="picture1">Зображення №1</label>
							<input type="file" name="picture1" id="picture1" hidden>
							<div class="admin-pictures-list">

							</div>
							<span class="admin-new-picture"><i class="fa fa-plus-circle" aria-hidden="true"></i></span>
							<span class="admin-delete-picture"></span>
						</div>
						<div class="admin-main-new-goods-bot-category">
							<select name="currency">
								<option value="0">Долар США</option>
								<option value="1">Євро</option>
							</select>
							<br>
							<select name="brand">
								<option value="0">Бренд</option>
								<?php foreach ($brands as $brand): ?>
								<option value="<?=$brand['id'];?>"><?=$brand['name'];?></option>
								<?php endforeach; ?>
							</select>
							<br>
							<select name="category" id="categoryselect">
								<option value="0">Категорія</option>
								<?php foreach ($categories as $category): ?>
								<option value="<?=$category['id'];?>"><?=$category['category'];?></option>
								<?php endforeach; ?>
							</select>
							<br>
							<div class="featurescontainer">

							</div>
						</div>
					</div>
					<div class="admin-main-new-goods-submit-g">
						<button>Додати</button>
					</div>
				</form>
			</div>
		</div>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="../../src/js/admin.js"></script>
	<script src="../../src/js/checker.js"></script>
	<script src="../../src/js/goods_images.js"></script>
	<script src="../../src/js/features_goods.js"></script>
	</body>
</html>	


<?php else: header("Location: ../index.php"); ?>
<?php endif; ?>
<?php else: header("Location: ../index.php"); ?>
<?php endif; ?>
