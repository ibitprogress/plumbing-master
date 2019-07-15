<?php include('../../configs/config.php');  
$categories = R::getAll("SELECT * FROM categories ORDER BY category ASC");
$lastgoods = R::getAll("SELECT * FROM goods ORDER BY id DESC LIMIT 2"); 
$goods = R::getAll("SELECT * FROM goods");
$random = rand(0, count($goods)-1);
$random_goods = $goods[$random];
$brands = R::getAll("SELECT * FROM brands");
$hots = R::getAll("SELECT * FROM goods ORDER BY sales DESC LIMIT 2");?>

<!DOCTYPE html> 
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
		<title>Plumbing</title>

		<!-- Normalize.css-->
		<link rel="stylesheet" href="../css/normalize.css">

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            
		<!-- Double Range -->
  		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

		<!-- Our styles -->
		<link rel="stylesheet" href="../css/style.css">
		<link rel="stylesheet" href="../css/responsive.css">
	</head>
	<body>
		<header>
			<div class="container">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 padinishka">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<a class="navbar-brand" href="#"><img src="../img/big-logo.png" alt=""></a>
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-3 padinishka">
						<button class="btn btn-default back-call">Зворотній зв'язок</button>
					</div>
					<div class="back_call_div">
						<form action="apps/back_call.php" method="post" class="kek">
							<div class="form-group row ">
  								<label for="example-tel-input" class="col-2 col-form-label">Введіть ваш телефон і ми вам передзвоним</label>
  								<div class="col-10">
    								<input class="form-control" name="phone" type="tel" placeholder="+38-(095)-322-4546" id="example-tel-input">
  								</div>
							</div>
							<button type="submit" class="btn btn-default back_call_sb">Відправити</button>
						</form>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-3 padinishka">
						<span class="contact-span">
							<span><img src="../img/tel.png"></span>+(067)966-80-07
						</span>
						<span class="contact-span">
							<span><img src="../img/web.png"></span>nazar.l@ukr.net
						</span>
						<span class="contact-span">
							<span><img src="../img/fb.png"></span>Назар Сантехніка
						</span>
					</div>
				</div>
			</div>
			<nav class="navbar navbar-default">
			    <div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-menu-col" aria-expanded="false">
						    <span class="sr-only">Toggle navigation</span>
						    <span class="icon-bar"></span>
						    <span class="icon-bar"></span>
						    <span class="icon-bar"></span>
						</button>
					</div>
					<div class="collapse navbar-collapse nav-menu-col" id="nav-menu-col">
						<ul class="nav navbar-nav navbar-nav-drop">
							<li>
								<a href="../../index.php">Головна</a>
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-nav-drop">
							<li class="active">
								<a href="#!">Про нас</a>
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-nav-drop">
							<li>
								<a href="payment_and_delivery.php">Оплата і доставка</a>
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-right nav-form">
							<li>
								<form class="navbar-form navbar-left">
									<div class="form-group">
										<input type="text" id="catalog_name" style="display: none" value="None">
										<input type="text" class="form-control search" placeholder="Пошук..." name="search">
									</div>
									<span class="btn btn-default btn-search srch"><img src="../img/searching.png"></span>
								</form>
							</li>
						</ul>
					</div><!-- /.navbar-collapse -->
			    </div><!-- /.container-fluid -->
			</nav>
		</header>

		<section>
			<div class="section-header">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-4 col-md-3">
							<div class="dropdown">
							  <button class="btn btn-default dropdown-toggle btn-catalog" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span><img src="../img/list.png"></span>Каталог товарів</button>
							  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							    <?php foreach($categories as $category): ?>
									<li><a href="../../catalog.php?catalog=<?=$category['category'];?>"><?=$category['category'];?></a></li>
								<?php endforeach; ?>
							  </ul>
							</div>
						</div>
						<div class="col-xs-6 col-sm-2 col-md-3">
							<span class="sh-span"><img src="../img/cart.png"> 0 товарів</span>
						</div>
						<div class="col-xs-6 col-sm-2 col-md-3">
							<span class="sh-span">всього: 0.00 грн</span>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-3">
							<? if($_SESSION) {
							echo '<a href="admin/index.php"><button class="btn btn-default dropdown-toggle btn-my-room" type="button" id="btn-my-room" aria-haspopup="true" aria-expanded="true"><span><img src="src/img/user.png"></span>Мій кабінет</button></a>';
						} else {
							echo '<a href="admin/index.php"><button class="btn btn-default dropdown-toggle btn-my-room" type="button" id="btn-my-room" aria-haspopup="true" aria-expanded="true"><span><img src="src/img/user.png"></span>Вхід</button></a> ';
							echo '<a href="admin/signup.php"><button class="btn btn-default dropdown-toggle btn-my-room" type="button" id="btn-my-room" aria-haspopup="true" aria-expanded="true"><span><img src="src/img/user.png"></span>Реєстрація</button></a>';
						}
						?>	
						</div>
					</div>
				</div>
			</div>
			<div class="section-body">
				<div class="container">
					<div class="row">
						<div class="com-xs-12 col-sm-8 col-md-6 col-md-offset-3">
							<h2>Ванна</h2>
							<div class="sb-ware">
								<span class="sb-span"><!-- <span><img src="../img/star.png"></span> -->Чому саме ми?</span>
								<div class="row search-result">
									<?php foreach($hots as $g): ?>
									<div class="col-xs-6 col-sm-6 col-md-6 border-right">
										<h3 class="h3-center"><?=$g['name'];?></h3>
										<div class="ware-img"><img src="<?=$g['image'];?>"></div>
										<h3 class="h3-center"><?=$g['cost'];?> Грн<img src="src/img/tags.png"></h3 class="h3-right">
										<div class="btn-add-center"><button type="submit" class="btn btn-default btn-add-basket"><img src="src/img/cart.png">Додати в кошик</button></div>
									</div>
									<?php endforeach;?>
								</div>
							</div>
						<div class="col-xs-12 col-sm-4 col-md-3">
							<div class="random-ware">
								<h3>Випадковий товар</h3>
								<h5><?=$random_goods['name'];?></h5>
								<div class="random-ware-img"><img src="../../<?=$random_goods['image'];?>" alt=""></div>
								<h3 class="h3-center"><?=$random_goods['cost'];?> Грн.<img src="../img/tags.png"></h3>
								<h6><a href="goods.php?goods=<?=$random_goods['id'];?>">Детальніше...</a></h6>
							</div>
							<div class="random-ware">
								<h3>Реклама брендів</h3>
								<h5>Унітаз "Агент-007"</h5>
								<div class="random-ware-img"><img src="../img/tron.jpg" alt=""></div>
								<h3 class="h3-center">210.00 Грн<img src="../img/tags.png"></h3>
								<h6><a href="">Детальніше...</a></h6>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<footer> 
		    <div class="container">
		    	<div class="row">
		    		<div class="col-sm-12 col-md-6">
		    			<nav class="navbar navbar-default navbar-footer">
					        <ul class="nav navbar-nav">
					            <li><a href="#!">Головна</a></li>
					            <li><a href="#!">Оплата та доставка</a></li>
					            <li><a href="#!">Про нас</a></li>
					        </ul>
						</nav>
		    		</div>
		    	</div>
		    	<div class="row">
		    		<div class="col-sm-12 col-md-5">
		    				<div class="contact-span-div">
								<span class="contact-span">
									<span><img src="../img/tel-white.png"></span>+(067)966-80-07
								</span>
								<span class="contact-span">
									<span><img src="../img/web-white.png"></span>nazar.l@ukr.net
								</span>
								<span class="contact-span">
									<span><img src="../img/fb-white.png"></span>Назар Сантехніка
								</span>
							</div>
							<div class="catalog-ware">
								<div class="catalog">
									<h4>Каталог товарів</h4><br>
									<span>Біде</span>
									<span>Ванни</span>
									<span>Верхні душі</span>
									<span>Душові двері</span>
									<span>Душові кабіни</span>
									<span>Душові піддони</span>
									<span>Кухонні мийки</span>
									<span>Меблі для ванної</span>
									<span>Сифони</span>
									<span>Змішувачі</span>
									<span>Умивальники</span>
									<span>Шторки для ванної</span>
									<span>Душові стійки та гідромасажні панелі</span>
									<span>Унітази</span>
								</div>
							</div>
		    		</div>
		    		<div class="col-sm-12 col-md-6 col-md-offset-1">
		    			<iframe src="https://www.google.com/maps/d/embed?mid=1yFzSlwXqkVHU7LcWh9ovnuJPeGQ" width="100%" height="230"></iframe>
		    			<h4 class="h4-span">
		    				<span><img src="../img/location.png" alt=""></span>
		    			</h4>
		    			<h4 class="h4-span">
		    				<span>Львів</span>
		    				<span>Вул. Монастирського 2</span>
		    				<span>Ринок промисловий</span>
		    			</h4>
		    		</div>
		    	</div>
		    </div>
 		
		</footer><!--DANGEROUS-->

		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> <!-- Double Range -->
		<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
		<script src='../js/script.js'></script>
		<script src="../js/back_connect.js"></script>
		<script src="../js/settings_toggle.js"></script>
		<script src="../js/search_ajax.js"></script>
		<script src="../js/search_brands.js"></script>
	</body>
</html>