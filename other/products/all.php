<?php
	//==[contents]==//
	$contents = "products";

	require("../base_cont.php");

	//セッション格納
	$cart = isset($_SESSION["cart"])? $_SESSION["cart"]:[];

	//カートボタンが押された時
	if(isset($_POST["in_cart"])){
		$item_code = s($_POST["item_code"]);
		$amount = s($_POST["amount"]);

		if(isset($_SESSION["cart"])){
			$cart = $_SESSION["cart"];
			foreach($cart as $key => $product){
				//カート内重複チェック
				if($key == $item_code){
					$amount = (int)$amount + (int)$product["amount"];
				}
				else{
					$_SESSION["cart"]["$item_code"] = ["amount" => "$amount","action" => "未発送","state" => "NG"];
				}
			}
		}
		if($item_code != "" && $amount != ""){
			$_SESSION["cart"][$item_code] = ["amount" => "$amount","action" => "未発送","state" => "NG"];
		}

		//ログインなし時
		if(!isset($_SESSION["account_name"])){
			header("Location:../account/login.php");
		}
	}
?>


<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>fiction shop 商品一覧</title>
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
		<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
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
				<a class="bread-list" href="#">商品一覧</a>
			</div>

			<!--==[コンテンツ]==-->
			<div id="other-container">
				<section class="section-title-outer">
					<div class="section-title">商品一覧</div>
				</section>

				<!--=商品一覧=-->
				<div id="all-list">
					<div id="all-list-inner">
						<?php
							require_once("../shop_DB.php");
							$pdo = db_connect();
							//商品をすべて表示
							try{
								$sql ="SELECT * FROM item ORDER BY code DESC";
								$statement = $pdo -> prepare($sql);
								$statement -> execute();
								$items = $statement -> fetchAll(PDO::FETCH_ASSOC);
							}
							catch(PDOException $e){
								print("DB接続エラー！:" . $e -> getMessage());
							}

							foreach($items as $key => $item){
						?>

						<iframe class="item-form-iframe" name="item_form_iframe" style="display:none;"></iframe>
						<form for="item_form_iframe" action="" class="item-form" method="POST">
							<div class="item-img-box">
								<!--商品イメージ-->
								<?php print(img_tag($item["img_name"],270)); ?>
							</div>
							<div class="item-lead">
								<div class="item-name">
									<!--商品名-->
									<?php print s($item["item_name"]); ?>
								</div>
								<div class="item-txt">
									<!--商品説明-->
									<?php print s(nl2br($item["comment"])); ?>
								</div>
							</div>
							<div class="item-foot">
								<div class="item-price">
									<div class="stock-nav">
										<input type="hidden" name="stock" class="stock" value="<?php print s($item["stock"]); ?>">
										<?php
											$stock =s($item["stock"]);
											//在庫数切替

											if($stock < 5 && $stock > 0){
												$stock_info = ("残り".$stock."つ");
												$on_stock = "";
												$off_stock = "none";
												$soldout = "none";
											}
											elseif($stock == 0){
												$stock_info = "";
												$on_stock = "none";
												$off_stock = "";
												$soldout = "";
											}
											else{
												$stock_info = "";
												$on_stock = "";
												$off_stock = "none";
												$soldout = "none";
											}
											//在庫案内表示
											print($stock_info);
										?>
									</div>
									<div class="item-price-child">
										<!--価格-->
										<p class="item-price-before">￥</p>
										<?php print s($item["price"]);?>
										<div class="price-tax">(税込)</div>
									</div>
								</div>

								<div class="amount-outer" style="display:<?php print($on_stock); ?>;">
									<!--数量入力-->
									<span class="spinner-minus">－</span>
									<input type="numeric" class="amount" name="amount" value="0" max="10" min="0">
									<span class="spinner-plus">+</span>
								</div>
								<div class="amount-nav-outer">
									<p class="erramount"><!-- error message --></p>
								</div>
								<input type="hidden" name="item_code" value="<?php print($item["code"]);?>">

								<div class="cart-btn-outer">
									<input type="submit" class="in-cart" name="in_cart" value="カートに入れる" style="display:<?php print($on_stock); ?>;">
									<div class="sold-out" style="display:<?php print($off_stock);?>;">SOLD OUT</div>
								</div>
							</div>
							<!--soldoutイメージ-->
							<img src="../../images/soldout.png" class="soldout-wrapper" style="display:<?php print($soldout); ?>;">
						</form>
						<?php
							}
						?>
					</div>
				</div>

				<!--return_btn-->
				<div id="other-return-outer">
					<button id="other-return-btn" class="block-btn">BACK</button>
				</div>
			</div>
		</main>

		<!--==[フッター]==-->
		<?php
			require("../../footer.php");
		?>
	</body>
</html>
