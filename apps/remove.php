<?php 
	include('../configs/config.php');

	if ($_POST){
        if ($_SESSION) {
            $goods = $_POST['goods'];
            R::exec("DELETE FROM basket WHERE goods = ? AND client = ? LIMIT 1", [ $goods, $_SESSION['id'] ]);
            $basket = R::getAll("SELECT * FROM basket");
            $usd_rate = R::getCell("SELECT usd FROM currency");
            $eur_rate = R::getCell("SELECT eur FROM currency");
            $discount = strval($_SESSION['discount']);
			if (strlen($discount) == 1) {
				$discount = "0.0".$discount;
			} elseif (strlen($discount) == 2) {
				$discount = "0.".$discount;
			}
            $countg = 0;
            $summ = 0;
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
            $vars = [$countg, $summ];
            echo json_encode($vars);
        } else {
            header("Location:../index.php");
        }
	} else {
		header("Location:../index.php");
	}
	

?>