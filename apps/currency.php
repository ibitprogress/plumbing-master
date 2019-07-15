<?php include('../configs/config.php'); 
    if ($_POST) {
		if ($_SESSION and $_SESSION['type'] == "superadmin") {
            $usd_rate = R::getCell("SELECT usd FROM currency");
            $eur_rate = R::getCell("SELECT eur FROM currency");
            $cost = R::getCell("SELECT cost FROM goods WHERE id = 43");
            if ($eur_rate == "" or $usd_rate == "") {
                if ($_POST['usd'] and $_POST['eur']) {
                    $currency = R::dispense("currency");
                    $currency->usd = round($_POST['usd'], 2);
                    $currency->eur = round($_POST['eur'], 2);
                    R::store($currency);
                    header("Location: ../admin/currency.php");
                } else {
                    header("Location: ../admin/currency.php");
                }
            } else {
                if ($_POST['usd'] and $_POST['eur']) {
                    $currencyid = R::getCell("SELECT id FROM currency");
                    $currency = R::load("currency", $currencyid);
                    $currency->usd = round($_POST['usd'], 2);
                    $currency->eur = round($_POST['eur'], 2);
                    R::store($currency);
                    header("Location: ../admin/currency.php");
                } else {
                    header("Location: ../admin/currency.php");
                }
            }
        } else {
			header("Location: ../admin/");
		}
	} else {
		header("Location:../index.php");
	}