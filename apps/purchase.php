<?php include('../configs/config.php');


    $usd_rate = R::getCell("SELECT usd FROM currency");
    $eur_rate = R::getCell("SELECT eur FROM currency");

    $countg = 0;
    $summ = 0;
    $basket = R::getAll("SELECT * FROM basket");

    $clients_goods = [];
    $basket_goods_id = R::getAll("SELECT goods FROM basket WHERE client=".$_SESSION['id']);
    for ($i = 0; $i < count($basket_goods_id); $i++) {
        $clients_goods[] = R::getRow("SELECT * FROM goods WHERE id = ?", [ $basket_goods_id[$i]['goods'] ]);
    }
    $basket_good = R::getAll("SELECT * FROM goods WHERE id=".$basket_goods_id);


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
    }


    $basket2 = R::getAll("SELECT goods FROM basket where client = ?", [ $_SESSION['id'] ]);
    $ubasket = [];
    foreach($basket2 as $b) {
        $__basket['name'] = R::getCell("SELECT name FROM goods where id = ?", [ $b['goods'] ]);
        $cost = R::getCell("SELECT cost FROM goods where id = ?", [ $b['goods'] ]);
        $curr = R::getCell("SELECT currency FROM goods where id = ?", [ $b['goods'] ]);
        if ($curr == 0) {
            $gcost = $cost * $usd_rate;
            $gcost = $gcost - ( $gcost * $discount );
        } elseif ($curr == 1) {
            $gcost = $cost * $eur_rate;
            $gcost = $gcost - ( $gcost * $discount );
        }
        $__basket['cost'] = round($gcost, 2);
        $ubasket[] = $__basket;
    }
    $orderid = 0;
    $date = date("H:i d.m.Y");
        if ($_POST) {
            if ($basket[0]['id'] != NULL) {
                $method = $_POST['purchasemethod'];
                $dmethod = $_POST['getting'];
                $order = R::dispense("orders");
                $order->fullName = $_SESSION['firstname']." ".$_SESSION['lastname'];
                $order->phone = $_POST['phone'];
                if ($dmethod == "newp") {
                    $order->dmethod = "Нова Пошта";
                } elseif ($dmethod == "delivery") {
                    $order->dmethod = "Кур'єрська доставка";
                } elseif ($dmethod == "pickup") {
                    $order->dmethod = "Самовивіз";
                }
                if ($method == "cash") {
                    $order->method = "Готівка";
                } elseif ($method == "ncash") {
                    $order->method = "Картка або приват24";
                }
                if ($_POST['purchaseoption'] == NULL) {
                    $order->option = "";
                } else {
                    $order->option = "[".$_POST['purchaseoption']."]";
                }
                $order->sum = $summ;
                $order->email = $_SESSION['email'];
                $order->date = $date;
                $order->basket = serialize($ubasket);
                R::store($order);
                $orderid = $order->id;
                R::exec("DELETE FROM basket where client = ?", [ $_SESSION['id'] ]);
                $countg = 0;
                $summ = 0;
            }
        }

require_once("libs/mailer/PHPMailerAutoload.php");
$mail = new PHPMailer;

$mail->IsSMTP();
$mail->Host = "mx1.hostinger.com.ua";
$mail->SMTPAuth = true;
$mail->Username = "info@potik-shop.com";
$mail->Password = "CzkihsllGbIOTlWINuM";
$mail->SMTPSecure = "tls";
$mail->Port = 587;
$mail->CharSet = "UTF-8";

$mail->setFrom('info@potik-shop.com', 'Info');
$mail->addAddress('vladyslav.kurash@gmail.com');
$mail->IsHTML(true);

$mail->Subject = "Замовлення №".$orderid."";

$list = '
			<center><h2>Надійшло нове замовлення</h2></center>
			№'.$order->id.'<br><br>
			Замовник: '.$_SESSION['firstname']." ".$_SESSION['lastname'].'<br>
			Номер телефона: '.$_POST['phone'].'<br>
			E-mail: '.$_SESSION['email'].'<br>
			Спосіб оплати: '.$order->dmethod.'<br>
			Спосіб отримання: '.$order->method.'<br>
			Список замовлення: <br>';

			$q = 1;
			foreach(unserialize($order->basket) as $b):
				$text = ''.$q.') '.$b['name'] .' | '. $b['cost'].' Грн.<br>';
				$q += 1; 
				$list.=$text;
			endforeach;
			
			$list.='Загальна сума замовлення: '.$order['sum'] .' Грн.<br><br>
			
            <a href="http://plumbing/admin/orders.php?order='.$orderid.'">Перевірити замовлення на сайті</a>
            ';
$mail->Body = $list;
$mail->send();

$categories = R::getAll("SELECT * FROM categories ORDER BY category ASC");
$lastgoods = R::getAll("SELECT * FROM goods ORDER BY id DESC LIMIT 2"); 
$goods = R::getAll("SELECT * FROM goods");
$random = rand(0, count($goods)-1);
$random_goods = $goods[$random];
$brands = R::getAll("SELECT * FROM brands");
$randomb = rand(0, count($brands)-1);
$random_brand = $brands[$randomb];
$hots = R::getAll("SELECT * FROM goods ORDER BY sales DESC LIMIT 2");


$random_image = unserialize($random_goods['images']); 
$random_image = $random_image[0];  







?>

<!DOCTYPE html> 
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="../src/img/logo.png" type="image/x-icon">
		<title>Дякуємо за замовлення</title>

		<link href="https://fonts.googleapis.com/css?family=Slabo+27px|Ubuntu" rel="stylesheet">

		<!-- Normalize.css-->
		<link rel="stylesheet" href="../src/css/normalize.css">

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            
		<!-- Double Range -->
  		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

		<!-- Our styles -->
		<link rel="stylesheet" href="../src/css/style.css">
		<link rel="stylesheet" href="../src/css/responsive.css">
	</head>
	<body>
		<div id="p_prldr"><div class="contpre"><span class="svg_anm"></span><br>Зачекайте<i class="fa fa-cog fa-spin fa-3x fa-fw"></i><br><small>сторінка завантажується</small></div></div>
		<header>
			<div class="container">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 padinishka">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<a class="navbar-brand" href="/"><img src="../src/img/big-logo.png" alt=""></a>
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-3 padinishka">
						<button class="btn btn-default back-call">Зворотній зв'язок</button>
					</div>
					<div class="back_call_div">
						<form action="../apps/back_call.php" method="post" class="kek">
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
							<span><img src="../src/img/tel.png"></span>+(067)966-80-07
						</span>
						<span class="contact-span">
							<span><img src="../src/img/web.png"></span>nazar.l@ukr.net
						</span>
						<span class="contact-span">
							<span><img src="../../src/img/fb.png"></span>Назар Сантехніка
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
								<a href="../src/template/about_us.php">Про нас</a>
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-nav-drop">
							<li>
								<a href="../src/template/payment_and_delivery.php">Оплата і доставка</a>
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-right nav-form">
							<li>
								<form class="navbar-form navbar-left" method="get" action="../search.php">
									<div class="form-group">
										<input type="text" class="form-control search" placeholder="Пошук..." name="search">
									</div>
									<button class="btn btn-default btn-search srch"><img src="../src/img/searching.png"></button>
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
							  <button class="btn btn-default dropdown-toggle btn-catalog" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span><img src="../src/img/list.png"></span>Каталог товарів</button>
							  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							    <?php foreach($categories as $category): ?>
									<li><a href="../catalog.php?catalog=<?=$category['category'];?>"><?=$category['category'];?></a></li>
								<?php endforeach; ?>
							  </ul>
							</div>
						</div>
						<div class="col-xs-6 col-sm-2 col-md-3">
							<span class="sh-span" id="countg"><img src="../src/img/cart.png"> <?=$countg;?> товарів</span>
						</div>
						<div class="col-xs-6 col-sm-2 col-md-3">
							<span class="sh-span" id="summ">всього: <?=$summ;?> грн</span>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-3">
						<? if($_SESSION) {
							echo '<a href="../../apps/logout.php"><button class="btn btn-default dropdown-toggle btn-my-room" type="button" id="btn-my-room" aria-haspopup="true" aria-expanded="true"><span><img src="../src/img/user.png"></span>Вийти</button></a>';
						} else {
							header('Location:../index.php');
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
                            <center><h3>Замовлення надійшло до опрацювання</h3></center>
							<?=$list;?>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-3">
							<div class="random-ware">
								<h3>Випадковий товар</h3>
								<h5><?=$random_goods['name'];?></h5>
								<div class="random-ware-img"><img src="<? echo '../'.$random_image; ?>" alt=""></div>
								<h3 class="h3-center"><? if ($random_goods['currency'] == 0){ echo round($usd_rate*$random_goods['cost'], 2);}elseif($random_goods['currency'] == 1){echo round($eur_rate*$random_goods['cost'], 2); } else{ echo round($random_goods['cost'], 2);} ?> Грн.<img src="../src/img/tags.png"></h3>
								<h6><a href="../src/template/goods.php?goods=<?=$random_goods['id'];?>">Детальніше...</a></h6>
							</div>
							<div class="random-ware">
								<h3>Реклама брендів</h3>
								<h5><?=$random_brand['name'];?></h5>
								<div class="random-ware-img"><img src="../<?=$random_brand['image'];?>" alt=""></div>
								<h6><a href="../bsearch.php?search=<?=$random_brand['id'];?>">Детальніше...</a></h6>
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
					            <li><a href="/">Головна</a></li>
					            <li><a href="../src/template/payment_and_delivery.php">Оплата та доставка</a></li>
					            <li><a href="../src/template/about_us.php">Про нас</a></li>
					        </ul>
						</nav>
		    		</div>
		    	</div>
		    	<div class="row">
		    		<div class="col-sm-12 col-md-5">
		    				<div class="contact-span-div">
								<span class="contact-span">
									<span><img src="../src/img/tel-white.png"></span>+(067)966-80-07
								</span>
								<span class="contact-span">
									<span><img src="../src/img/web-white.png"></span>nazar.l@ukr.net
								</span>
								<span class="contact-span">
									<span><img src="../src/img/fb-white.png"></span>Назар Сантехніка
								</span>
							</div>
							<div class="catalog-ware">
								<div class="catalog">
									<h4>Каталог товарів</h4><br>
									<?php foreach($categories as $category): ?>
									<a href="../catalog.php?catalog=<?=$category['category']; ?>"> <span><?=$category['category'];?></span></a>
									<?php endforeach; ?>	
								</div>
							</div>
		    		</div>
		    		<div class="col-sm-12 col-md-6 col-md-offset-1">
		    			<iframe src="https://www.google.com/maps/d/embed?mid=1yFzSlwXqkVHU7LcWh9ovnuJPeGQ" width="100%" height="230"></iframe>
		    			<h4 class="h4-span">
		    				<span><img src="../src/img/location.png" alt=""></span>
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
		<script src='../src/js/script.js'></script>
		<script src="../src/js/back_connect.js"></script>
		<script src="../src/js/settings_toggle.js"></script>
		<script src="../src/js/purchase.js"></script>
		<script src="../src/js/doesntexist.js"></script>
		<script src="../src/js/remove.js"></script>
		<!-- HelloPreload http://hello-site.ru/preloader/ -->

		<script type="text/javascript">
			$(window).on('load', function () {
	    		var $preloader = $('#p_prldr'),
	        	$svg_anm = $preloader.find('.svg_anm');
	    		$svg_anm.fadeOut();
	    		$preloader.delay(500).fadeOut('slow');
			});
		</script>
		<script>
			$(".newuserinfo div span").on("click", function(){
				$(this).remove();
				$('[name="password"]').css("display", "block");
			});
		</script>
		<script>
			$(".gotobasket").on("click", function(){
				var scroll = $('.search-result').offset().top;
				$("html, body").animate({
					scrollTop: scroll-15
				}, 1000);
			});
		</script>
	</body>
</html>