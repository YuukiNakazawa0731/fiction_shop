<?php
	//SESSION制御
	session_start();

	//二重送信防止トークン
	$token = "token_on";
	$_SESSION["order_token"] = $token;

	//削除処理
	$cart_no = $_POST["cart_no"];
	if(isset($_POST["delete_cart"])){
		unset($_SESSION["cart"]["$cart_no"]);
	header("Location:mycart.php");
}
else{
		header("Location:../products/all.php");
	}
