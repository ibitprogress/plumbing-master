<?php 
	include($_SERVER["DOCUMENT_ROOT"].'/apps/libs/rb.php');
	
	R::setup( 'mysql:host=localhost;dbname=web_shop', 'root', '' );
	$pdo = new PDO( 'mysql:host=localhost;dbname=web_shop', 'root', '' );
	
	session_start();
?>