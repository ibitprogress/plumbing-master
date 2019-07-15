<?php include('../configs/config.php'); 
	if ($_POST) {
		if ($_SESSION and $_SESSION['type'] == "superadmin") {
			$name = $_POST['name'];
			$image = $_FILES['picture'];
			if($name and $image){
				$brand = R::dispense("brands");
				$brand->name = $name;
				$brand->image = "";
				$image = $_FILES['picture'];
				$image_name = $image['name'];
				$image_path = $image['tmp_name'];
				R::store($brand);
				$uid = md5(uniqid(rand(),1));
				if(move_uploaded_file($image_path, '../src/brands_images/'.$uid.".png"))
					$pdo->query('UPDATE brands SET image="src/brands_images/'.$uid.'.png" WHERE id ='.$brand['id']);
				header('Location:../admin/list/brands.php');
			}
		} else {
			echo "Fuck out";
		}
	} else {
		header("Location:../index.php");
	}