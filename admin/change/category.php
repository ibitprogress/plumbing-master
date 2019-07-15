<?php include('../../configs/config.php'); ?>
<?php if ($_SESSION): ?>
<?php if ($_SESSION['type'] == 'superadmin'): 
$categoryid = $_GET['category'];
$category = R::load("categories", $categoryid);
$features = R::getAll("SELECT * FROM `features` WHERE category = ?", [$categoryid]);
?>

	
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="../../src/img/logo.png" type="image/x-icon">
		<title>CHANGE | Category</title>
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
		        <a href="../list/categories.php" class="admin-nav-active-tab"><li>Категорії</li></a>
		        <a href="../list/goods.php"><li>Товари</li></a>
		        <a href="../list/users.php"><li>Користувачі</li></a>
		        <a href="../list/brands.php"><li>Бренди</li></a>
		        <a href="../currency.php"><li>Курс валют</li></a>
		    </ul>
		    <div class="admin-open-nav hidden-md hidden-lg" data-move='>'><i class="fa fa-cog" aria-hidden="true"></i></div>
		</div>
		<div class="admin-main">
			<div class="admin-main-content">
				<form action="../../apps/change_category.php" method="POST" enctype="multipart/form-data">
					<div class="admin-main-new-goods-top">
						<div class="admin-main-new-goods-top-name">
							<div class="category_featurer">Характеристика</div>
							<div class="featuremain">
								<? $count = 0;
								$optionsCount = "";
								foreach($features as $feature):
								$count = $count + 1?>
								<span class="featuremain<?=$count?> featuremainspan">
        							<input type="text" name="feature<?=$count?>" class="featureinput" value=<?=$feature['feature']?>><span class="featureactions featureactions<?=$count?>"><i class="fa fa-plus-circle newfeatureoption newfeatureoption<?=$count?>" data-feature="<?=$count?>" aria-hidden="true"></i><i class="fa fa-trash-o featureremoveoption featureremoveoption<?=$count;?>" data-feature="<?=$count;?>" aria-hidden="true"></i></span>
									<div class="featureoptionmain featureoptionmain<?=$count?>">
										<?php $options = R::getAll("SELECT * FROM `featureoptions` WHERE category = ? AND feature = ?", [$categoryid, $feature['id']]);
										$_count = 0;
										foreach($options as $option):
										$_count = $_count + 1?>
										<span class="optionmain optionmain<?=$_count;?>">
										<input class="featureinput featureinputoption" name="feature<?=$count;?>option<?=$_count;?>" value=<?=$option['option'];?>>
										</span>
										<?php endforeach;
										$optionsCount.=$_count.=",";
										?>
										<input id="_feature<?=$count;?>OptionsCount" value=<?=$_count;?> hidden>
									</div>
								</span>
								<?endforeach;?>
								<input type="number" hidden name="featurescount" value="<?=$count;?>">
								<input type="text" hidden name="optionscount" value="<?=substr($optionsCount, 0, -1);?>">
								<input type="text" hidden name="categoryId" value="<?=$categoryid;?>">
								<input id="_featureCount" value="<?=$count;?>" hidden>
							</div>
							<span class="featureplus"><i class="fa fa-plus-circle" aria-hidden="true" id="newfeature"></i>
							
							</span>
							</div>
						<div class="admin-main-new-goods-top-name admin-main-new-top-right">
							<input type="text" placeholder="Назва категорії" name="name" value="<?=$category['category'];?>">
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
	<script src="../../src/js/idontknowwhatimdoinghere.js"></script>
	</body>
</html>	


<?php else: header("Location: ../index.php"); ?>
<?php endif; ?>
<?php else: header("Location: ../index.php"); ?>
<?php endif; ?>
