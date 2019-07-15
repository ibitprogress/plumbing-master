<?php include('../configs/config.php'); 
	if ($_POST) {
		if ($_SESSION and $_SESSION['type'] == "superadmin") {
			$name = $_POST['name'];
			$cost = $_POST['cost'];
			$description = $_POST['description'];
			$category = $_POST['category'];
			$brand = $_POST['brand'];
			$currency = $_POST['currency'];
			$id = $_POST['id'];
			$is = 0;
			if (isset($_POST['storage'])) {
				$is = 1;
			}
			$images = $_FILES;
			$gimages = [];
			$noerror = true;
			$old_images_count = $_POST['oldimages'];
			for ($i = 1; $i <= $old_images_count; $i++) {
				if (isset($_POST['oldimage'.$i])) {
					$gimages[] = $_POST['oldimage'.$i];
				}
			}
			foreach ($images as $image) {
				if($image['error'] != 4) {
					$uid = md5(uniqid(rand(),1));
					if(move_uploaded_file($image['tmp_name'], '../src/goods_images/'.$uid.'.png')) {
						$gimages[] = 'src/goods_images/'.$uid.'.png';
					} else {
						$noerror = false;
					}
				}
			}
			$gimages = serialize($gimages);
			if($name and $cost and $description and $category){
				$goods = R::load("goods", $id);
				$goods->name = $name;
				$goods->cost = $cost;
				$goods->description = $description;
				$goods->category = $category;
				$goods->brand = $brand;
				$goods->images = $gimages;
				$goods->currency = $currency;
				$goods->is = $is;
				R::store($goods);
				$features = R::getAll("SELECT * FROM features WHERE category = ?", [$category]);
				$_i = 0;
				foreach($features as $feature) {
					$_i = $_i + 1;
					$newoption = $_POST['feature'.$_i];		
					if ($newoption != 0) {
						$oldoption = R::getCell("SELECT `option` FROM options WHERE feature = ? AND goods = ?", [ $feature['id'], $goods->id ]);
						if ($oldoption == "") {
							$options = R::dispense("options");
							$options->goods = $goods->id;
							$options->feature = $feature['id'];
							$options->option = $_POST['feature'.$_i];
							R::store($options);
						} else {
							if ($newoption != $oldoption) {
								$optionid = R::getCell("SELECT id FROM options WHERE feature = ? AND goods = ?", [ $feature['id'], $goods->id ]);
								$options = R::load("options", $optionid);
								$options->goods = $goods->id;
								$options->feature = $feature['id'];
								$options->option = $_POST['feature'.$_i];
								R::store($options);
							}
						}
					}
				};
				header('Location:../admin/list/goods.php');
			} else {
				header('Location:../admin/change/goods.php?goods='.$id);
			}
		} else {
			header("Location:../index.php");
		}
	} else {
		header("Location:../index.php");
	}