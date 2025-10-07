<?php
	//==[contents]==//
	$contents = "account";

	require_once("../base_cont.php");
	require_once("../shop_DB.php");
	$pdo = db_connect();

	//二重送信防止トークン
	$token = "token_on";
	$_SESSION["order_token"] = $token;

	//セッション格納
	$cart = isset($_SESSION["cart"])? $_SESSION["cart"]:[];

	//日付情報取得
	$order_date = date('Y-m-d');

	if(!isset($account_name)){
		$no_cart = "";
		$no_cart_txt = "ログイン後にご利用下さい";
		$logon = "none";
		$logoff = "";
		$price_box = "none";
	}

	if($cart_count == 0 && $account_name != ""){
		$no_cart = "";
		$no_cart_txt = "カートの中身はありません";
		$logon = "";
		$logoff = "none";
		$price_box = "none";
	}
	else{
		$no_cart = "none";
		$no_cart_txt = "";
		$logon = "";
		$logoff = "none";
		$price_box = "";
	}
?>


<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>fiction shop カート</title>
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="../../css/full/common.css" media="screen and (min-width: 1024px)">
		<link rel="stylesheet" href="../../css/middle/common_middle.css" media="screen and (min-width:481px) and (max-width:1023px)">
		<link rel="stylesheet" href="../../css/mobile/common_mobile.css" media="screen and (max-width:480px)">
		<link rel="stylesheet" href="../../css/full/account.css" media="screen and (min-width: 1024px)">
		<link rel="stylesheet" href="../../css/middle/account_middle.css" media="screen and (min-width:481px) and (max-width:1023px)">
		<link rel="stylesheet" href="../../css/mobile/account_mobile.css" media="screen and (max-width:480px)">
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
				<a class="bread-list" href="#">カート</a>
			</div>

			<!--==[コンテンツ]==-->
			<div id="other-container">
				<section class="section-title-outer">
					<div class="section-title">ショッピングカート</div>
				</section>

				<div id="cart-container">
					<?php
						if(isset($_SESSION["cart"]) && $_SESSION["cart"] != ""){
							$cart = $_SESSION["cart"];
							$cart_count = (count($_SESSION["cart"]));

							//合計金額
							$total_price = 0;

							if($cart_count > 0 && isset($_SESSION["cart"])){
								$cart_disp_no = "none";
								//カートの中を表示
								foreach($cart as $key => $item){
									$item_code = $key;
									$order_amount = $item["amount"];

									//sql実行
									try{
										$sql ="SELECT * FROM item WHERE code LIKE :item_code";
										$statement = $pdo -> prepare($sql);
										$statement -> bindValue(":item_code", $item_code);
										$statement -> execute();
									}
									catch(PDOException $e){
										print("DB接続エラー！:" . $e -> getMessage());
									}

									while($cart_result = $statement -> fetch(PDO::FETCH_ASSOC)){
										if($order_amount > $cart_result["stock"]){
											$err_cart = "※注文数が在庫を上回っています";
											$form_border = "0.15rem solid red";
											$amount_color = "red";
										}
										else{
											$err_cart = "";
											$form_border = "none";
											$amount_color = "black";
										}
										?>

										<form class="cart-form" action="delete_cart_cont.php" method="post" style="display:<?php print ($price_box); ?>;border: <?php print ($form_border); ?>">
											<input type="hidden" name="cart_no" value="<?php print($key); ?>">
											<!--商品画像-->
											<div class="cart-img-box">
												<?php print (img_tag($cart_result["img_name"],150)); ?>
											</div>
											<div class="cart-item-lead">
												<div class="cart-item-name-outer">
													商品名:
													<div class="cart-item-name">
														<?php print s($cart_result["item_name"]); ?>
													</div>
												</div>
												<div class="cart-item-price-outer">
													価格:
													<div class="cart-item-price">
														<?php print s($cart_result["price"]); ?>
													</div>
													<div class="cart-item-tax">
														円(税込)
													</div>
												</div>
												<div class="cart-item-amount-outer">
													注文数:
													<div class="cart-item-amount" style=color:<?php print ($amount_color); ?>>
														<?php print s($order_amount); ?>
													</div>
												</div>
												<div class="cart-err">
													<?php print s($err_cart); ?>
												</div>
											</div>
											<div class="cart-btn-area">

												<button type="submit" class="delete-cart-btn" name="delete_cart">
													<p class="delete-cart-txt">削除</p>
													<img src="../../images/dust_box_black.png" class="delete-cart-icon" alt="delet_cart_icon">
												</button>
											</div>
										</form>

										<?php
										//合計金額を計算
										$total = $cart_result["price"] * $order_amount;
										$total_price += $total;
									}
								}
							}
						}
					?>
				</div>

				<div id="total-price-container" style="display:<?php print ($price_box); ?>">
					<!--==会計明細表示==-->
					<div id="total-price-outer">商品合計金額：
						<div id="total-price">
							<?php
								print s($total_price);
							?>
						</div>
						円
					</div>

					<div id="delivery-price-outer">配送料：
						<div id="delivery-price">
							<?php
								$delivery_price = 550;
								print s($delivery_price);
							?>
						</div>
						円
					</div>

					<div id="all-total-price-outer">お支払い合計金額：
						<div id="all-total-price">
							<?php
								$all_total_price = $total_price + $delivery_price;
								print s($all_total_price);
							?>
						</div>
						円
					</div>
				</div>

				<div id="destination-outer" style="display:<?php print ($price_box); ?>">
					<?php
						//お届け先
						$account_name = s($_SESSION["account_name"]);
						$account_mail = s($_SESSION["account_mail"]);
						$account_post_code = s($_SESSION["account_post_code"]);
						$account_address = s($_SESSION["account_address"]);
					?>

					<dl id="destination-list">
						<dt class="destination-item">お客様名:</dt>
						<dd class="destination-item-child">
							<?php print s($account_name); ?>
						</dd>

						<dt class="destination-item">お届け先:</dt>
						<dd class="destination-item-child">
							<?php print s("〒".$account_post_code); ?>
								<br>
							<?php print s($account_address); ?>
						</dd>

						<dt class="destination-item">メール:</dt>
						<dd class="destination-item-child">
							<?php print s($account_mail); ?>
						</dd>
					</dl>

					<div id="delivery-list">
						<div id="delivery-item">お届け予定日
							<div id="delivery-item-child">
								<?php
									$delivery = strtotime("+2 day");
									print (date("Y年m月d日",$delivery));
								?>
							</div>
						</div>
					</div>
				</div>

				<p id="order-lead" style="display:<?php print ($price_box); ?>">上記の内容でよろしければ『注文する』ボタンをクリックして下さい</p>

				<form id="order-btn-area" action="../support/order_cont.php" method="post" style="display:<?php print ($price_box); ?>">
					<input type="button" id="return-all" class="block-btn" name="to_all" value="戻る">
					<input type="submit" id="order-submit" class="local-btn" name="to_order" value="注文する">
				</form>

				<div id="no-cart" style="display:<?php print ($no_cart); ?>">
					<?php print s($no_cart_txt); ?>
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
