<?php
	include('../configs/config.php');
	if ($_SESSION) {
		session_unset();
		header("Location: ../index.php");
	}
?>