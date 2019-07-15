<?php include('../../configs/config.php');  

$usd_rate = R::getCell("SELECT usd FROM currency");
$eur_rate = R::getCell("SELECT eur FROM currency");

$goods = R::getAll("SELECT * FROM goods");
$random = rand(0, count($goods)-1);
$random_goods = $goods[$random];
$brands = R::getAll("SELECT * FROM brands");
$randomb = rand(0, count($brands)-1);
$random_brand = $brands[$randomb];
$hots = R::getAll("SELECT * FROM goods ORDER BY sales DESC LIMIT 2");
$countg = 0;
$summ = 0;
$categories = R::getAll("SELECT * FROM categories ORDER BY category ASC");

$random_image = unserialize($random_goods['images']); 
$random_image = $random_image[0]; 

$good_id = $_GET['goods'];
$good = R::getRow("SELECT * FROM goods WHERE id =".$good_id);
$good_images = unserialize($good['images']);
$goods_images = [];
for($i = 0; $i < ceil(count($good_images)/3); $i++) {
	$goods_img = [];
	for($j = 3 * $i; $j < 3 * $i + 3; $j++) {
		$goods_img[] = $good_images[$j];
	}
	$goods_images[] = $goods_img;
}
$comments = R::getAll('SELECT * FROM messages WHERE good_id ='.$good_id);


 

$basket = R::getAll("SELECT * FROM basket");
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
		<link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
		<title><?=$good['name']; ?></title>

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
		<link rel="stylesheet" href="../css/signin.css">
		<link rel="stylesheet" href="../css/signup.css">
	</head>
	<body>
	<!-- форма для написанння коментарів -->
		<div class="modal fade comment" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Залишити відгук</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <form action="../../apps/add_comment.php" method="post">
		          <div class="form-group">
		          	<input type="hidden" value="<?=$good_id ?>" name="g_id">
		            <label for="message-text" class="form-control-label">Відгук:</label>
		            <textarea class="form-control" id="message-text" name="message"></textarea>
		          </div>
		        
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
		        <button type="submit" class="btn btn-primary">Відправити</button>
		      </div>
		      </form>
		    </div>
		  </div>
		</div>


		<!-- <div id="p_prldr"><div class="contpre"><span class="svg_anm"></span><br>Зачекайте<i class="fa fa-cog fa-spin fa-3x fa-fw"></i><br><small>сторінка завантажується</small></div></div> -->

		<div id="p_prldr"><div class="contpre"><span class="svg_anm"></span></div></div>

		<!-- вхід -->
		<div id="ModalSignin" class="modal fade modal-signin">
			<div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			        <h4 class="modal-title signin-modal-title">Вхід</h4>
			      </div>
			      <!-- Основное содержимое модального окна -->
			      <form action="../../apps/signin.php" method="post">
			      <div class="modal-body">
			      	 <label for="username">E-mail:</label>
					 <input type="text" id="id_username" name="email" class="form-control">
			         <label for="password">Пароль:</label>
			         <input type="password" id="id_password" name="password" class="form-control">
			      </div>
			      <!-- Футер модального окна -->
			      <div class="modal-footer">
			        <span class="btn btn-default btn-signin-user btn-sb-save">Увійти</span>
			      </div>
			      </form>
			    </div>
			</div>
		</div>
   		<!--  реєстрація	 -->
	    <div class="modal fade modal-signup" id="ModalSignup">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				    <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				    </div>
				    <form action="../../apps/signup.php" method="post">
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
							<a class="navbar-brand" href="/"><img src="../img/big-logo.png" alt=""></a>
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-3 padinishka">
						<button class="btn btn-default back-call">Зворотній зв'язок</button>
					</div>
					<div class="back_call_div">
						<form action="../../apps/back_call.php" method="post" class="kek">
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
							<li>
								<a href="about_us.php">Про нас</a>
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-nav-drop">
							<li>
								<a href="payment_and_delivery.php">Оплата і доставка</a>
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-right nav-form">
							<li>
								<form class="navbar-form navbar-left" method="get" action="../../search.php">
									<div class="form-group">
										<input type="text" class="form-control search" placeholder="Пошук..." name="search">
									</div>
									<button class="btn btn-default btn-search srch"><img src="../img/searching.png"></button>
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
							<span class="sh-span" id="countg"><img src="../img/cart.png"> <?=$countg;?> товарів</span>
						</div>
						<div class="col-xs-6 col-sm-2 col-md-3">
							<span class="sh-span" id="summ">всього: <?=$summ;?> грн</span>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-3">
								<? if($_SESSION) {
							echo '<a href="../../admin/index.php"><button class="btn btn-default dropdown-toggle btn-my-room" type="button" id="btn-my-room" aria-haspopup="true" aria-expanded="true"><span><img src="../../src/img/user.png"></span>Мій кабінет</button></a>';
						} else {
							echo '<button class="btn btn-default dropdown-toggle btn-my-room btn-signin" type="button" id="btn-my-room" aria-haspopup="true" aria-expanded="true"><span><img src="../img/signin.png"></span>Вхід</button> ';
							echo '<button class="btn btn-default dropdown-toggle btn-my-room btn-signup" type="button" id="btn-my-room" aria-haspopup="true" aria-expanded="true"><span><img src="../img/signup.png"></span>Реєстрація</button>';
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
							<div class="goods-section">
								<h3><?=$good['name']; ?></h3>
								<h3 class="h3-center" style="position: absolute; right: 0; top: 0;"><? if ($random_goods['currency'] == 0){ echo round($usd_rate*$good['cost'], 2);}elseif($random_goods['currency'] == 1){echo round($eur_rate*$good['cost'], 2); } else{ echo round($good['cost'], 2);} ?> Грн.</h3>
								<div class="goods-img">
									<img src="<?php echo '../../'.$good_images[0]; ?>">
								</div>
								<div class="goods-slider">
									<div id="goddsCarousel" class="carousel slide" data-ride="carousel">
										<div class="carousel-inner">
											<div class="item active">
										        <div class="row">
										        	<div class="col-xs-1 col-sm-1 col-md-1"></div>
											        <?php for ($q = 0; $q < 3; $q++):  ?>
													<?php if ($goods_images[0][$q] != NULL): ?>
											        <div class="col-xs-5 col-sm-2 col-md-2 col-md-offset-1 vert-align-center">
											        	<img src="<? echo '../../'.$goods_images[0][$q]; ?>" data-src="<? echo '../../'.$goods_images[0][$q]; ?>" alt="" class="show-full-image">
											        </div>
											    	<?php endif; ?>
											        <?php endfor; ?>
										        	<div class="col-xs-1 col-sm-1 col-md-1"></div>
										        </div>
										    </div>
										    <?php for($a = 1; $a < ceil(count($good_images)/3); $a++): ?>
										    <div class="item">
										        <div class="row">
										        	<div class="col-xs-1 col-sm-1 col-md-1"></div>
										        	<?php for ($q = 0; $q < 3; $q++):  ?>
										        	<?php if ($goods_images[$a][$q] != NULL): ?>	
										        	<div class="col-xs-5 col-sm-2 col-md-2 col-md-offset-1 vert-align-center">
										        		<img src="<? echo '../../'.$goods_images[$a][$q]; ?>" data-src="<? echo '../../'.$goods_images[$a][$q]; ?>" alt="" class="show-full-image">
										        	</div>
										        <?php endif; ?>
										        	<?php endfor; ?>
										        	<div class="col-xs-1 col-sm-1 col-md-1"></div>
										        </div>
										    </div>
											<?php endfor;?>
										</div>

									

								    

									  <!-- Controls -->
									  <?php if ($good_images[3]): ?><a class="left carousel-control" href="#goddsCarousel" role="button" data-slide="prev">
									    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
									    <span class="sr-only">Previous</span>
									  </a>
									  <a class="right carousel-control" href="#goddsCarousel" role="button" data-slide="next">
									    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
									    <span class="sr-only">Next</span>
									  </a><? endif; ?>
									</div>
								</div>
								<div class="goods-text">
									<?= $good['description']; ?>
								</div>
								<?php
								$options = R::getAll('SELECT * FROM options WHERE goods = ?', [ $good['id'] ]);
								if ($options[0]['feature'] != NULL):
								?>
								<div class="goods-page-features">
									<h3>Характеристика</h3>
									<span>
									<?php foreach($options as $option): ?>
										<?php $_feature = R::getRow("SELECT * FROM features WHERE id = ?", [ $option['feature'] ]);?>
										<?php if ($_feature["category"] == $good["category"]): ?>
											<?php $_option = R::getCell("SELECT `option` FROM featureoptions WHERE id = ?", [$option['option']]);?>
											<?php if ($_option != NULL and $_option != ''): ?>	
												<?=$_feature['feature'];?>: <?=$_option;?><br>
											<?php endif; ?> 
										<?php endif; ?>
									<?php endforeach; ?>
									</span>
								</div>
								<?php endif; ?>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<div class="goods-rewievs" style="text-align: center">
											<button class="btn btn-default btn-reviews com-fade_in"><img src="../img/message.png">Відгуки</button>
											<!-- style="overflow: hidden;background-color: #fff;border-color: #fff;" -->
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<div class="goods-add-basket" style="text-align: center">
											<?php if($good['is'] == 1): ?>
											<button class="btn btn-default btn-add-basket-goods btn-add-basket-goods-js" data-id="<?=$good['id'];?>"><img src="../img/cart.png">Додати в кошик</button>											
											<?php elseif($good['is'] == 0): ?>
											<button class="btn btn-default btn-add-basket-goods">Товар тимчасово відсутній</button>	
											<?php endif; ?>
										</div>
									</div>
									<div class="col-md-12 comments" style="display:none;">
									<div class="row">
										<button class="btn btn-default btn-comment col-md-12 col-sm-12 col-xs-12" data-session="<?php if (!$_SESSION): ?>false<?php else:?>true<?php endif;?>" style="background-color:#464646;color:#fff;">Залишити відгук</button>
										<?php if ($comments[0] != NULL): ?>
										<?php foreach($comments as $com): ?>
										<div class="col-md-12 comments-container" style="margin-top:5%;" >
											<div class="col-md-6 col-md-offset-3 comment-text">	
												<div class="row">
													<div class="col-md-3">
														<i class="fa fa-users" aria-hidden="true" style="font-size:50px;"></i>
													</div>
													<div class="col-md-9">
														<p><?=R::getCell("SELECT username FROM users WHERE id = ?", [ $com['user_who_commenting'] ]);?></p>
														<p><?=$com['comment'];?></p>
													</div>
												</div>	
											</div>	
										</div>
										<?php endforeach; ?>
										<?php endif; ?>
									</div>	
									</div>

								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-3">
							<div class="random-ware">
								<h3>Випадковий товар</h3>
								<h5><?=$random_goods['name'];?></h5>
								<div class="random-ware-img"><img src="<? echo '../../'.$random_image;?>" alt=""></div>
								<h3 class="h3-center"><? if ($random_goods['currency'] == 0){ echo round($usd_rate*$random_goods['cost'], 2);}elseif($random_goods['currency'] == 1){echo round($eur_rate*$random_goods['cost'], 2); } else{ echo round($random_goods['cost'], 2);} ?> Грн.<img src="../img/tags.png"></h3>
								<h6><a href="goods.php?goods=<?=$random_goods['id'];?>">Детальніше...</a></h6>
							</div>
							<div class="random-ware">
								<h3>Реклама брендів</h3>
								<h5><?=$random_brand['name'];?></h5>
								<div class="random-ware-img"><img src="../../<?=$random_brand['image'];?>" alt=""></div>
								<h6><a href="../../bsearch.php?search=<?=$random_brand['id'];?>">Детальніше...</a></h6>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="contacts-list">
			<div class="container">
				<div class="row">
					<div class="col-xs-2 xol-md-2 contacts-li li-fb">
						<a href="facebook.com">facebook</a>
					</div>
					<div class="col-xs-2 xol-md-2 contacts-li li-google">
						<a href="facebook.com">Google+</a>
					</div>
					<div class="col-xs-2 xol-md-2 contacts-li li-twitter">
						<a href="facebook.com">twitter</a>
					</div>
					<div class="col-xs-2 xol-md-2 contacts-li li-vk">
						<a href="facebook.com">vkontakte</a>
					</div>
					<div class="col-xs-2 xol-md-2 contacts-li li-instagram">
						<a href="facebook.com">instagram</a>
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
					            <li><a href="payment_and_delivery.php">Оплата та доставка</a></li>
					            <li><a href="about_us.php">Про нас</a></li>
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
									<?php foreach($categories as $category): ?>
										<a href="../../catalog.php?catalog=<?=$category['category']; ?>"> <span><?=$category['category'];?></span></a>
									<?php endforeach; ?>
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
		<script src="../js/purchaseg.js"></script>
		<script src="../js/show_image.js"></script>
		<script src="../js/signin.js"></script>
		<script type="text/javascript">$(window).on('load', function () {
    		var $preloader = $('#p_prldr'),
        	$svg_anm   = $preloader.find('.svg_anm');
    		$svg_anm.fadeOut('slow',function(){$(this).remove();});
    		$preloader.delay(500).fadeOut('slow');
			});
		</script>
		<script> 
			$('.btn-comment').on('click', function(){
				if ($(this).attr("data-session") == "true") {
        			$(".comment").modal('show');
				} else if ($(this).attr("data-session") == "false") {
					$("#ModalSignin").modal('show');
				}
			});
		</script>
		<script>
			    //modal
    		$('.btn-signin').on('click', function(){
        		$("#ModalSignin").modal('show');
    		});
    		$('.btn-signup').on('click', function(){
        		$("#ModalSignup").modal('show');
    		});
		</script>
	<script src="../js/comments.js"></script>
	</body>
</html>