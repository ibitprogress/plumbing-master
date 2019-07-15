<?php 
	include('../configs/config.php'); 
	
	if ($_POST) {
		if ($_SESSION and $_SESSION['type'] == "superadmin") {
			$name = $_POST['name'];
			$cost = $_POST['cost'];
			$description = $_POST['description'];
			$category = $_POST['category'];
			$brand = $_POST['brand'];
			$currency = $_POST['currency'];
			$is = 0;
			if (isset($_POST['storage'])) {
				$is = 1;
			}
			$images = $_FILES;
			$gimages = [];
			$noerror = true;
			foreach ($images as $image) {
				$uid = md5(uniqid(rand(),1));
				if(move_uploaded_file($image['tmp_name'], '../src/goods_images/'.$uid.".png")) {
					$gimages[] = 'src/goods_images/'.$uid.".png";
				} else {
					$noerror = false;
				}
			}
			$gimages = serialize($gimages);
		 	if($name and $cost and $description and $noerror == true and $category){
				$goods = R::dispense("goods");
				$goods->name = $name;
				$goods->cost = $cost.'';
				$goods->description = $description;
				$goods->category = $category;
				$goods->brand = $brand;
				$goods->sales = 0;
				$goods->currency = $currency;
				$goods->images = $gimages;
				$goods->is = $is;
				$goods->data_add = date('h-i-s j-m-y');
				R::store($goods);
				$features = R::getAll("SELECT * FROM features WHERE category = ?", [ $category ]);
				$i = 0;
				foreach($features as $feature) {
					$i = $i + 1;
					if ($_POST['feature'.$i] != 0){
						$options = R::dispense("options");
						$options->goods = $goods->id;
						$options->feature = $feature['id'];
						$options->option = $_POST['feature'.$i];
						R::store($options);
					}
				}
				header('Location:../admin/list/goods.php');
			} else {
				header("Location:../admin/add/goods.php");
			}
		} else {
			header("Location:../index.php");
		}
	} else {
		header("Location:../index.php");
	}