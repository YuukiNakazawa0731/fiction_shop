<?php
	//==[contents]==//
	$contents = "products";

	//DB接続
	require_once("../base_cont.php");
	require_once("../shop_DB.php");
	$pdo = db_connect();

	//直接アクセス禁止
	if($_SESSION["admin"] != "ON"){
		header("Location:../../shop.php");
	}
?>


<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>商品新規登録</title>
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="../../css/full/common.css" media="screen and (min-width: 1024px)">
		<link rel="stylesheet" href="../../css/middle/common_middle.css" media="screen and (min-width:481px) and (max-width:1023px)">
		<link rel="stylesheet" href="../../css/mobile/common_mobile.css" media="screen and (max-width:480px)">
		<link rel="stylesheet" href="../../css/full/products.css" media="screen and (min-width: 1024px)">
		<link rel="stylesheet" href="../../css/middle/products_middle.css" media="screen and (min-width:481px) and (max-width:1023px)">
		<link rel="stylesheet" href="../../css/mobile/products_mobile.css" media="screen and (max-width:480px)">
		<link rel="shortcut icon" href="../../images/fiction_shop.ico">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<script src="../../../jQuery.js"></script>
		<script src="../../shop.js"></script>
	</head>

	<body>
		<!--==[ヘッダー]==-->
		<?php
			require("../../header.php");
		?>

		<main>
			<!--=[パンくず]=-->
			<div id="bread-crumb">
				<a id="bread-home" href="../../shop.php">HOME</a>
				<span class="bread-arrow">></span>
				<a class="bread-list" href="item_manage.php">商品管理</a>
				<span class="bread-arrow">></span>
				<a class="bread-list" href="#">商品登録</a>
			</div>

			<!--==[コンテンツ]==-->
			<div id="other-container">
				<section class="section-title-outer">
					<div class="section-title">商品登録</div>
				</section>

				<!--=商品新規登録=-->
				<div id="edit-container">
					<div class="edit-form-outer">
						<form action="item_edit.php" class="edit-form" method="POST" enctype="multipart/form-data">
							<div class="edit-img-outer">
								<div id="signup-img-box">
									<input type="hidden" name="MAX_FILE_SIZE" value="50000">
									<input type="file" class="img-name" name="signup_img_name" value="">
									<img src="" class="edit-img">
								</div>
							</div>

							<div class="edit-item-lead-outer">
								<div class="edit-item-lead">
									<div class="edit-item-list">商品名:</div>
									<div class="edit-item-item">
										<input type="text" class="input-edit" name="signup_item_name" value="">
									</div>
								</div>

								<div class="edit-item-lead">
									<div class="edit-item-list">コメント:</div>
									<div class="edit-item-item">
										<textarea class="input-edit-txt" name="signup_item_txt" rows="5" required>
										</textarea>
									</div>
								</div>

								<div class="edit-item-lead">
									<div class="edit-item-list">価格:</div>
									<div class="edit-item-item">
										<input type="number" class="input-edit" name="signup_item_price" required value="">
									</div>
								</div>

								<div class="edit-item-lead">
									<div class="edit-item-list">在庫数量:</div>
									<div class="edit-item-item">
										<input type="number" class="input-edit" name="signup_item_stock" required value="">
									</div>
								</div>
							</div>

							<div class="edit-signup-btn-outer">
								<div class="item-edit-btn">
									<input type="submit" class="edit-btn" name="signup_item_submit" value="登録">
									<button id="signup-btn-return" class="edit-btn">戻る</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<!--return_btn-->
				<div id="other-return-outer">
					<button id="other-return-btn" class="edit-btn">BACK</button>
				</div>
			</div>
		</main>

		<!--==[フッター]==-->
		<?php
			require("../../footer.php");
		?>
	</body>
</html>
