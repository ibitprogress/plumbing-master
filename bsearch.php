<?php if ($_GET): ?>
<?php 
include('configs/config.php');

$usd_rate = R::getCell("SELECT usd FROM currency");
$eur_rate = R::getCell("SELECT eur FROM currency");
$categories = R::getAll("SELECT category FROM categories ORDER BY category ASC");

$search = $_GET['search'];
$lastgoods = R::getAll("SELECT * FROM goods ORDER BY id DESC LIMIT 2");
$goodsf = R::getAll("SELECT * FROM goods");
$random = rand(0, count($goodsf)-1);
$random_goods = $goodsf[$random];
$brands = R::getAll("SELECT * FROM brands");
$randomb = rand(0, count($brands)-1);
$random_brand = $brands[$randomb];
$countg = 0;
$summ = 0;
$basket = R::getAll("SELECT * FROM basket");
$brandname = R::getCell("SELECT name FROM brands WHERE id = ".$search);
$goods = R::getAll('SELECT * FROM goods WHERE brand ='.$search);
$random_image = unserialize($random_goods['images']); 
$random_image = $random_image[0]; 

$discount = strval($_SESSION['discount']);
if (strlen($discount) == 1) {
	$discount = "0.0".$discount;
} elseif (strlen($discount) == 2) {
	$discount = "0.".$discount;
}
$discount = floatval($discount);
foreach ($basket as $b) {
	if ($_SESSION['id'] == $b['client']) {
		$countg = $countg + 1;
		if (R::getCell("SELECT currency FROM goods WHERE id = ?", [ $b['goods'] ]) == 0) {
			$gcost = R::getCell("SELECT cost FROM goods WHERE id = ?", [ $b['goods'] ]) * $usd_rate;
			$gcost = $gcost - ( $gcost * $discount );
			$summ = $summ + round($gcost, 2);
		} elseif (R::getCell("SELECT currency FROM goods WHERE id = ?", [ $b['goods'] ]) == 1) {
			$gcost = R::getCell("SELECT cost FROM goods WHERE id = ?", [ $b['goods'] ]) * $eur_rate;
			$gcost = $gcost - ( $gcost * $discount );
			$summ = $summ + round($gcost, 2);
		}
	}
}?>

<!DOCTYPE html> 
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="src/img/logo.png" type="image/x-icon">
		<title><?=$brandname;?> </title>

		<!-- Normalize.css-->
		<link rel="stylesheet" href="src/css/normalize.css">

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            
		<!-- Double Range -->
  		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

		<!-- Our styles -->
		<link rel="stylesheet" href="src/css/style.css">
		<link rel="stylesheet" href="src/css/responsive.css">
		<link rel="stylesheet" href="src/css/signin.css">
		<link rel="stylesheet" href="src/css/signup.css">
	</head>
	<body>
		<!-- <div id="p_prldr"><div class="contpre"><span class="svg_anm"></span><br>Зачекайте<i class="fa fa-cog fa-spin fa-3x fa-fw"></i><br><small>сторінка завантажується</small></div></div> -->

		<div id="p_prldr"><div class="contpre"><span class="svg_anm"></div></div>
	<!-- вхід -->
	<div id="ModalSignin" class="modal fade modal-signin">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	        <!--<h4 class="modal-title signin-modal-title">Вхід</h4>--> <!-- style="color:black;"-->
	      </div>
	      <!-- Основное содержимое модального окна -->
	      <form action="apps/signin.php" method="post">
	      <div class="modal-body">
	      	 <label for="username">E-mail:</label>
			 <input type="text" id="id_username" name="email" class="form-control">
	         <label for="password">Пароль:</label>
	         <input type="password" id="id_password" name="password" class="form-control">
	      </div>
	      <!-- Футер модального окна -->
	      <div class="modal-footer">
	        <span class="btn btn-default btn-signin-user btn-sb-save">Увійти</span> <!--style="background-color: #464646;color:#fff;"-->
	      </div>
	      </form>
	    </div>
	  </div>
	</div>
   <!--  реєстрація	 -->
    <div id="ModalSignup" class="modal fade modal-signup">
	  	<div class="modal-dialog" role="document">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          			<span aria-hidden="true">&times;</span>
	        		</button>
	      		</div>
	      		<form action="apps/signup.php" method="post">
		      		<div class="modal-body">
						<label for="text-input-fname" class="col-form-label">Ім'я</label>
						<input class="form-control" type="text id="text-input-fname" name="name">

						<label for="text-input-lname" class="col-form-label">Прізвище</label>
						<input class="form-control" type="text" id="text-input-lname" name="lastname">

						<label for="email-input" class="col-form-label">E-mail</label>
						<input class="form-control" type="email" placeholder="email@example.ua" id="email-input" name="email">

						<label for="tel-input" class="col-form-label">Номер телефону</label>
						<input class="form-control" type="tel" placeholder="+380971750340" id="tel-input" name="phone">

						<label for="password-input" class="col-form-label">Пароль</label>
						<input class="form-control pass" type="password" id="password-input" name="password">

						<label for="confirm" class="col-form-label">Підтвердіть пароль</label>
						<input class="form-control conf_pass" type="password" id="confirm" name="confirm">
					</div>
		      		<div class="modal-footer">
		        		<button type="submit" class="btn btn-default btn-signup-user btn-primary">Реєстрація</button>
		      		</div>
	      		</form>
	    	</div>
	 	</div>
	</div>
		<header>
			<div class="container">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 padinishka">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<a class="navbar-brand" href="/"><img src="src/img/big-logo.png" alt=""></a>
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
							<span><img src="src/img/tel.png"></span>+(067)966-80-07
						</span>
						<span class="contact-span">
							<span><img src="src/img/web.png"></span>nazar.l@ukr.net
						</span>
						<span class="contact-span">
							<span><img src="src/img/fb.png"></span>Назар Сантехніка
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
							<li class="active">
								<a href="/">Головна</a>
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-nav-drop">
							<li>
								<a href="src/template/about_us.php">Про нас</a>
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-nav-drop">
							<li>
								<a href="src/template/payment_and_delivery.php">Оплата і доставка</a>
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-right nav-form">
							<li>
								<form class="navbar-form navbar-left" method="get" action="search.php">
									<div class="form-group">
										<input type="text" class="form-control search" placeholder="Пошук..." name="search">
									</div>
									<button class="btn btn-default btn-search srch"><img src="src/img/searching.png"></button>
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
							  <button class="btn btn-default dropdown-toggle btn-catalog" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span><img src="src/img/list.png"></span>Каталог товарів</button>
							  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							    <?php foreach($categories as $category): ?>
									<li><a href="catalog.php?catalog=<?=$category['category'];?>"><?=$category['category'];?></a></li>
								<?php endforeach; ?>
							  </ul>
							</div>
						</div>
						<div class="col-xs-6 col-sm-2 col-md-3">
							<span class="sh-span" id="countg"><img src="src/img/cart.png"> <?=$countg;?> товарів</span>
						</div>
						<div class="col-xs-6 col-sm-2 col-md-3">
							<span class="sh-span" id="summ">всього: <?=$summ;?> грн</span>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-3">
							 	<? if($_SESSION) {
							echo '<a href="admin/index.php"><button class="btn btn-default dropdown-toggle btn-my-room" type="button" id="btn-my-room" aria-haspopup="true" aria-expanded="true"><span><img src="src/img/user.png"></span>Мій кабінет</button></a>';
						} else {
							echo '<button class="btn btn-default dropdown-toggle btn-my-room btn-signin" type="button" id="btn-my-room" aria-haspopup="true" aria-expanded="true"><span><img src="src/img/signin.png"></span>Вхід</button> ';
							echo '<button class="btn btn-default dropdown-toggle btn-my-room btn-signup" type="button" id="btn-my-room" aria-haspopup="true" aria-expanded="true"><span><img src="src/img/signup.png"></span>Реєстрація</button>';
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
							<h2><?=$brandname;?></h2>
							<div class="search-result">
							<?php if($goods[0]['name'] != NULL): ?>
							<?php foreach ($goods as $g): ?>
							<?php $img = unserialize($g['images']); $img = $img[0] ?>	
							<div class="sb-ware">
								<div class="row">
						         	<div class="col-sm-6">
						          		<a href="src/template/goods.php?goods=<?=$g['id']; ?>"><h3><?=$g['name'];?></h3></a>
						         	</div>
						        	<div class="col-sm-4 col-sm-offset-2">
						          		<h3 class="h3-right"><?  if ($g['currency'] == 0){ echo round($usd_rate*$g['cost'], 2);}elseif($g['currency'] == 1){echo round($eur_rate*$g['cost'], 2); } else{ echo round($g['cost'], 2);} ?> Грн<img src="src/img/tags.png"></h3 class="h3-right">						          		
						         	</div>
						        </div>
						        <div class="row">
						         	<div class="col-sm-3">
						          		<div class="ware-img">
						           			<img src="<?=$img;?>">
						          		</div>
						        	</div>
						        	<div class="col-sm-9">
						          		<div class="row">
						           			<div class="col-sm-12">
						            			<div class="ware-text">
										             <p>
										              <?=$g['description'];?> 
										             </p>
						            			</div>
						           			</div>
						           			<div class="col-sm-7 col-sm-offset-5">
						            			<?php if($g['is'] == 1): ?>
												<div class="btn-add-center" data-id="<?=$g['id'];?>"><span class="btn btn-default btn-add-basket"><img src="src/img/cart.png">Додати в кошик</span></div>
												<?php elseif($g['is'] == 0): ?>
												<div class="btn-add-center-isnt"><span class="btn btn-default">Товар тимчасово відсутній</span></div>
												<?php endif; ?>
						           			</div>
						          		</div>
						         	</div>
						        </div>
							</div>
							<?php endforeach; ?>
							<?php else: ?>
								<center><h2>Не знайдено</h2>
								<h3><a href="/">Повернутись на головну</a></h3></center>
							<?php endif; ?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-3">
							<div class="random-ware">
								<h3>Випадковий товар</h3>
								<h5><?=$random_goods['name'];?></h5>
								<div class="random-ware-img"><img src="<?=$random_image;?>" alt=""></div>
								<h3 class="h3-center"><? if ($random_goods['currency'] == 0){ echo round($usd_rate*$random_goods['cost'], 2);}elseif($random_goods['currency'] == 1){echo round($eur_rate*$random_goods['cost'], 2); } else{ echo round($random_goods['cost'], 2);} ?> Грн.<img src="src/img/tags.png"></h3>
								<h6><a href="src/template/goods.php?goods=<?=$random_goods['id'];?>">Детальніше...</a></h6>
							</div>
							<div class="random-ware">
								<h3>Реклама брендів</h3>
								<h5><?=$random_brand['name'];?></h5>
								<div class="random-ware-img"><img src="<?=$random_brand['image'];?>" alt=""></div>
								<h6><a href="bsearch.php?search=<?=$random_brand['id'];?>">Детальніше...</a></h6>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="section-slider">
			<div class="slider">
				<div class="container-fluid">
				  <div id="myCarousel" class="carousel slide" data-ride="carousel">
				    <!-- Wrapper for slides -->
				    <div class="carousel-inner">
				      <div class="item active">
				        <div class="row">
				        	<div class="col-xs-1 col-sm-1 col-md-1"></div>
				        	<?php if ($brands[0]['name'] != NULL): ?><div class="col-xs-5 col-sm-2 col-md-2 vert-align-center">
				        		<a href="bsearch.php?search=<?=$brands[0]['id'];?>"><img class="c-image" src="<?=$brands[0]['image'];?>" alt="<?=$brands[0]['name'];?>" data-id="<?=$brands[0]['id'];?>" class="do-search-brand"></a>
				        	</div><?php endif; ?>
				        	<?php if ($brands[1]['name'] != NULL): ?><div class="col-xs-5 col-sm-2 col-md-2 vert-align-center">
				        		<a href="bsearch.php?search=<?=$brands[1]['id'];?>"><img class="c-image" src="<?=$brands[1]['image'];?>" alt="<?=$brands[1]['name'];?>" data-id="<?=$brands[1]['id'];?>" class="do-search-brand"></a>
				        	</div><?php endif; ?>
				        	<?php if ($brands[2]['name'] != NULL): ?><div class="col-xs-5 col-sm-2 col-md-2 vert-align-center">
				        		<a href="bsearch.php?search=<?=$brands[2]['id'];?>"><img class="c-image" src="<?=$brands[2]['image'];?>" alt="<?=$brands[2]['name'];?>" data-id="<?=$brands[2]['id'];?>" class="do-search-brand"></a>
				        	</div><?php endif; ?>
				        	<?php if ($brands[3]['name'] != NULL): ?><div class="col-xs-5 col-sm-2 col-md-2 vert-align-center">
				        		<a href="bsearch.php?search=<?=$brands[3]['id'];?>"><img class="c-image" src="<?=$brands[3]['image'];?>" alt="<?=$brands[3]['name'];?>" data-id="<?=$brands[3]['id'];?>" class="do-search-brand"></a>
				        	</div><?php endif; ?>
				        	<?php if ($brands[4]['name'] != NULL): ?><div class="col-xs-5 col-sm-2 vert-align-center">
				        		<a href="bsearch.php?search=<?=$brands[4]['id'];?>"><img class="c-image" src="<?=$brands[4]['image'];?>" alt="<?=$brands[4]['name'];?>" data-id="<?=$brands[4]['id'];?>" class="do-search-brand"></a>
				        	</div><?php endif; ?>
				        	<!-- <div class="col-xs-12 col-sm-2 col-md-2 vert-align-center">
				        		<img src="src/img/cersanit.png" alt="cersanit">
				        	</div> -->
				        	<div class="col-xs-1 col-sm-1 col-md-1"></div>
				        </div>
				      </div>
				      <?php if ($brands[5]['name'] != NULL): ?>
				      <div class="item">
				        <div class="row">
				        	<div class="col-xs-1 col-sm-1 col-md-1"></div>
				        	<!-- <div class="col-xs-12 col-sm-2 vert-align-center">
				        		<img src="src/img/wavin.png" alt="wavin">
				        	</div> -->
				        	<?php if ($brands[5]['name'] != NULL): ?><div class="col-xs-5 col-sm-2 vert-align-center">
				        		<a href="bsearch.php?search=<?=$brands[5]['id'];?>"><img class="c-image" src="<?=$brands[5]['image'];?>" alt="<?=$brands[5]['name'];?>" data-id="<?=$brands[5]['id'];?>" class="do-search-brand"></a>
				        	</div><?php endif; ?>
				        	<?php if ($brands[6]['name'] != NULL): ?><div class="col-xs-5 col-sm-2 vert-align-center">
				        		<a href="bsearch.php?search=<?=$brands[6]['id'];?>"><img class="c-image" src="<?=$brands[6]['image'];?>" alt="<?=$brands[6]['name'];?>" data-id="<?=$brands[6]['id'];?>" class="do-search-brand"></a>
				        	</div><?php endif; ?>
				        	<?php if ($brands[7]['name'] != NULL): ?><div class="col-xs-5 col-sm-2 vert-align-center">
				        		<a href="bsearch.php?search=<?=$brands[7]['id'];?>"><img class="c-image" src="<?=$brands[7]['image'];?>" alt="<?=$brands[7]['name'];?>" data-id="<?=$brands[7]['id'];?>" class="do-search-brand"></a>
				        	</div><?php endif; ?>
				        	<?php if ($brands[8]['name'] != NULL): ?><div class="col-xs-5 col-sm-2 vert-align-center">
				        		<a href="bsearch.php?search=<?=$brands[8]['id'];?>"><img class="c-image" src="<?=$brands[8]['image'];?>" alt="<?=$brands[8]['name'];?>" data-id="<?=$brands[8]['id'];?>" class="do-search-brand"></a>
				        	</div><?php endif; ?>
				        	<?php if ($brands[9]['name'] != NULL): ?><div class="col-xs-5 col-sm-2 vert-align-center">
				        		<a href="bsearch.php?search=<?=$brands[9]['id'];?>"><img class="c-image" src="<?=$brands[9]['image'];?>" alt="<?=$brands[9]['name'];?>" data-id="<?=$brands[9]['id'];?>" class="do-search-brand"></a>
				        	</div><?php endif; ?>
				        	<div class="col-xs-1 col-sm-1 col-md-1"></div>
				        </div>
				      </div>
				    </div>

				    <!-- Left and right controls -->
				    
				    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
				      <span class="glyphicon glyphicon-chevron-left"></span>
				      <span class="sr-only">Previous</span>
				    </a>
				    <a class="right carousel-control" href="#myCarousel" data-slide="next">
				      <span class="glyphicon glyphicon-chevron-right"></span>
				      <span class="sr-only">Next</span>
				    </a>
				    </a>
					<?php endif; ?>
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
					            <li><a href="/">Головна</a></li>
					            <li><a href="src/template/payment_and_delivery.php">Оплата та доставка</a></li>
					            <li><a href="src/template/about_us.php">Про нас</a></li>
					        </ul>
						</nav>
		    		</div>
		    	</div>
		    	<div class="row">
		    		<div class="col-sm-12 col-md-5">
		    				<div class="contact-span-div">
								<span class="contact-span">
									<span><img src="src/img/tel-white.png"></span>+(067)966-80-07
								</span>
								<span class="contact-span">
									<span><img src="src/img/web-white.png"></span>nazar.l@ukr.net
								</span>
								<span class="contact-span">
									<span><img src="src/img/fb-white.png"></span>Назар Сантехніка
								</span>
							</div>
							<div class="catalog-ware">
								<div class="catalog">
									<h4>Каталог товарів</h4><br>
									<?php foreach($categories as $category): ?>
									<a href="catalog.php?catalog=<?=$category['category']; ?>"> <span><?=$category['category'];?></span></a>
									<?php endforeach; ?>
								</div>
							</div>
		    		</div>
		    		<div class="col-sm-12 col-md-6 col-md-offset-1">
		    			<iframe src="https://www.google.com/maps/d/embed?mid=1yFzSlwXqkVHU7LcWh9ovnuJPeGQ" width="100%" height="230"></iframe>
		    			<h4 class="h4-span">
		    				<span><img src="src/img/location.png" alt=""></span>
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
		<script src='src/js/script.js'></script>
		<script src="src/js/back_connect.js"></script>
		<script src="src/js/settings_toggle.js"></script>
		<script src="src/js/purchase.js"></script>
		<script src="src/js/signin.js"></script>
		<script>
			    //modal
    		$('.btn-signin').on('click', function(){
        		$("#myModalBox").modal('show');
    		});
    		$('.btn-signup').on('click', function(){
        		$("#ModalSignup").modal('show');
    		});
		</script>
		<script type="text/javascript">
			$(window).on('load', function () {
   				var $preloader = $('#p_prldr'),
        		$svg_anm   = $preloader.find('.svg_anm');
    			$svg_anm.fadeOut('slow',function(){$(this).remove();});
    			$preloader.delay(500).fadeOut('slow');
			});
		</script>
	</body>
</html>
<?php else: ?>
<?php header("Location: /"); ?>
<?php endif; ?>