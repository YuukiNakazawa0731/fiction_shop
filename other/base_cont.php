<?php
	//サニタイズ処理
	function s($statement) {
		return htmlspecialchars($statement, ENT_QUOTES, "utf-8");
	}

	//SESSION制御
	session_start();
	//ログイン認証
	if(isset($_SESSION["account_name"])){
		$logon = "";
		$logoff = "none";
		$on_view = "flex";
		$align_view = "center";
		$account_name = $_SESSION["account_name"];
		$user_id = $_SESSION["account_mail"];
	}
	else{
		$logon = "none";
		$logoff = "";
		$no_cart = "ログイン後にご利用下さい";
		$account_name = "";
		$user_id = "";
	}

	//admin認証
	if(isset($_SESSION["admin"]) && ($_SESSION["admin"] = "ON")){
		$admin_on = "";
		$admin_off = "none";
	}
	else{
		$admin_on = "none";
		$admin_off = "";
	}


	//画像表示
	function img_tag($name,$base_size){
		if(file_exists("../../item_img/$name"))
			$image = "../../item_img/$name";
		//ファイル内になければ「ノーイメージ」を表示
		else{
			$image = "../../item_img/noimage.png";
		}
		//サイズ自動調整
		//メインHTMLから$base_sizeを取得
		$imageinfo = getimagesize($image);
		$width = $imageinfo[0];
		$height = $imageinfo[1];
		// 縦と横の大きいほうを取得
		$max = ($width > $height ? $width : $height);
		// 比率を保持して縮小
		$ratio = $max / $base_size;
		$new_width = round($width / $ratio);
		$new_height = round($height / $ratio);

		// HTMLタグを出力
		return '<img src="
			'.$image.'"
			width="'.$new_width.'"
			height="'.$new_height.'"
			class="item-img"
			alt="item_img">';
	}


	//カート内商品カウント
	if(isset($_SESSION["cart"])){
		$cart = $_SESSION["cart"];
		$total_arr = array();
		$cart_count = count($cart);
	}
	else{
		$cart_count = 0;
	}
