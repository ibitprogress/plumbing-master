<?php 
	include('../configs/config.php');
	if ($_POST) {
		if ($_SESSION) {
			$basket = R::dispense('basket');
			$basket->client = $_SESSION['id'];
			$basket->goods = $_POST["goods"];
			R::store($basket);
			$story = R::dispense('history');
			$story->story = $_SESSION['firstname']." ".$_SESSION['lastname']."[".$_SESSION['phone']."] додав до кошика ".R::getCell("SELECT name FROM goods WHERE id = ?", [ $_POST['goods'] ]);
			$story->date = date("d.m.Y, H:i");
			R::store($story);	
			$countg = 0;
			$summ = 0;
			$basket = R::getAll("SELECT * FROM basket");
			$goods = R::getAll("SELECT * FROM goods");
			$usd_rate = R::getCell("SELECT usd FROM currency");
			$eur_rate = R::getCell("SELECT eur FROM currency");
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
			if ($discount == 0.00) {
				$vars = [$countg, $summ];
			} else {
				$cgcost = $_POST["goods"];
				$ccurrency = R::getCell("SELECT currency FROM goods WHERE id = ?", [ $cgcost ]);
				$cgcost = R::getCell("SELECT cost FROM goods WHERE id = ?", [ $cgcost ]);
				if ( $ccurrency == 0 ) {
					$cgcost = $cgcost * $usd_rate;
				} elseif ( $ccurrency == 1 ) {
					$cgcost = $cgcost * $eur_rate;
				}
				$cgcost = $cgcost * $discount;
				$vars = [$countg, $summ, round($cgcost, 2)];
			}
			echo json_encode($vars);
		} else {
			echo json_encode("nologon");
		}
	} else {
		header("Location:../index.php");
	}

?>