<?php
	//==[contents]==//
	$contents = "support";

	require_once("../base_cont.php");

	//二重送信防止トークン
	if(!isset($_SESSION["order_token"]) || ($_SESSION["order_token"] != "token_on")){
		header("Location:../products/all.php");
	}
	else{
		unset($_SESSION["order_token"]);
	}

	//日時情報
	$now_date = date('Y-m-d');
?>


<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>注文完了</title>
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="../../css/full/common.css" media="screen and (min-width: 1024px)">
		<link rel="stylesheet" href="../../css/middle/common_middle.css" media="screen and (min-width:481px) and (max-width:1023px)">
		<link rel="stylesheet" href="../../css/mobile/common_mobile.css" media="screen and (max-width:480px)">
		<link rel="stylesheet" href="../../css/full/support.css" media="screen and (min-width: 1024px)">
		<link rel="stylesheet" href="../../css/middle/support_middle.css" media="screen and (min-width:481px) and (max-width:1023px)">
		<link rel="stylesheet" href="../../css/mobile/support_mobile.css" media="screen and (max-width:480px)">
		<link rel="shortcut icon" href="../../images/fiction_shop.ico">
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
				<a class="bread-list" href="#">注文完了</a>
			</div>

			<!--==[コンテンツ]==-->
			<div id="other-container">
				<section class="section-title-outer">
					<div class="section-title">注文完了</div>
				</section>

				<article class="article-title">
					<div id="thank-txt-area">
						<div id="thank-txt-head">THANK YOU!!</div>
						<div id="thank-txt">ご注文ありがとうございます！！</div>
					</div>
				</article>

				<div class="order-container">
					<div class="order-form-outer">
						<?php
							//セッション格納
							$cart = isset($_SESSION["cart"])? $_SESSION["cart"]:[];

							//DB接続
							require_once("../shop_DB.php");
							$pdo = db_connect();

							//購入結果表示
							foreach($cart as $key => $item){
								$item_code = $key;
								$order_amount = $item["amount"];
								//sql(購入商品)
								$sql ="SELECT * FROM item WHERE code LIKE :item_code";
								$statement = $pdo -> prepare($sql);
								$statement -> bindValue(":item_code", $item_code);
								$statement -> execute();
								$cart_result = $statement -> fetch(PDO::FETCH_ASSOC);

								if($item["state"] == "OK"){
									$on_state = "";
									$off_state = "none";
									$err_order = "";
									$form_border = "none";
									$form_color = "rgb(228, 228, 228)";

								}
								if($item["state"] == "NG"){
									$on_state = "none";
									$off_state = "";
									$err_order = "在庫不足のためご注文を受付できませんでした";
									$form_border = "0.1rem solid red";
									$form_color = "rgb(255, 214, 214)";
								}
						?>

						<form id="thank-form" class="order-form" style="display:<?php print ($on_result); ?>">
							<div class="order-form-img-outer">
								<?php print (img_tag($cart_result["img_name"],150)); ?>
							</div>

							<div class="order-form-lead-outer">
								<div class="order-form-lead">
									<div class="order-form-list">商品名:</div>
									<div class="order-form-item">
										<?php print s($cart_result["item_name"]); ?>
									</div>
								</div>
								<div class="order-form-lead">
									<div class="order-form-list">価格:</div>
									<div class="order-form-item">
										<div class="order-result-price-outer">￥
											<div class="order-result-price">
												<?php print s($cart_result["price"]); ?>
											</div>
											<div class="order-result-price-tax">(税込)</div>
										</div>
									</div>
								</div>
								<div class="order-form-lead">
									<div class="order-form-list">数量:</div>
									<div class="order-form-item">
										<?php print s($order_amount); ?>
									</div>
								</div>
							</div>

							<div class="order-form-cont">
								<div class="order-result-state-outer" style="display:<?php print ($on_state); ?>">
									お届け予定日:
									<div class="order-result-state-date">
										<?php
											$delivery = strtotime("+2 day");
											print s(date("Y年m月d日",$delivery));
										?>
									</div>
									<div class="thank-err" style="display:<?php print ($off_state); ?>">
										<?php print s($err_order); ?>
									</div>
								</div>
							</div>
						</form>
					</div>

					<?php
						}
						unset($_SESSION["cart"]);
					?>

					<p id="order-nav">購入履歴はメニューからご覧いただけます</p>

					<div id="thank-return-btn-outer">
						<a href="../../shop.php" id= "thank-return-btn" class="block-btn">TOPページへ</a>
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
