<?php
	require_once("other/base_cont.php");
	require_once("other/shop_DB.php");

	$pdo = db_connect();

	//==[contents]==//
	$contents = "shop";
?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>fiction shop</title>
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="css/full/common.css" media="screen and (min-width: 1024px)">
		<link rel="stylesheet" href="css/middle/common_middle.css" media="screen and (min-width:481px) and (max-width:1023px)">
		<link rel="stylesheet" href="css/mobile/common_mobile.css" media="screen and (max-width:480px)">
		<link rel="stylesheet" href="css/full/main.css" media="screen and (min-width: 1024px)">
		<link rel="stylesheet" href="css/middle/main_middle.css" media="screen and (min-width:481px) and (max-width:1023px)">
		<link rel="stylesheet" href="css/mobile/main_mobile.css" media="screen and (max-width:480px)">
		<link rel="shortcut icon" href="images/fiction_shop.ico">
		<script src="../jQuery.js"></script>
		<script src="shop.js"></script>
	</head>

	<body>
		<!--==[ヘッダー]==-->
		<?php
			require("header.php");
		?>

		<!--==[メインコンテンツ]==-->
		<main>
			<!--[新着商品]-->
			<div class="contents">
				<article id="new-title-outer">
					<div id="new-title">
						<div class="head-word">N</div>
						<div class="foot-word">EW PRODUCTS</div>
				</div>
				<span class="white-line-n"></span>
				<span class="back-line-n"></span>
				</article>

				<div id="new-products-area">
					<?php
						//新着表示商品コード1
						$new_1 = 8;
						try{
							$sql ="SELECT * FROM item WHERE code = :code";
							$statement = $pdo -> prepare($sql);
							$statement -> bindValue(":code",$new_1);
							$statement -> execute();
							$items = $statement -> fetchAll(PDO::FETCH_ASSOC);
						}
						catch(PDOException $e){
							print("DB接続エラー！:" . $e -> getMessage());
						}

						foreach($items as $item){
					?>
					<div class="products-box">
						<div class="new-img-box-1">
							<img src="item_img/<?php print($item["img_name"]); ?>" class="new-img">
						</div>
						<div class="new-txt-box-1">
							<div class="new-name-area">
								<div class="new-name">
									<?php print s($item["item_name"]); ?>
								</div>
							</div>
							<div class="new-txt">
								<?php print s(nl2br($item["comment"])); ?>
							</div>
							<div class="new-price">
								<?php print s("￥".$item["price"]); ?>
								<div class="new-tax">(税込)</div>
							</div>
						</div>
					</div>
					<?php
						}
					?>

					<?php
						//新着表示商品コード2
						$new_2 = 6;
						try{
							$sql ="SELECT * FROM item WHERE code = :code";
							$statement = $pdo -> prepare($sql);
							$statement -> bindValue(":code",$new_2);
							$statement -> execute();
							$items = $statement -> fetchAll(PDO::FETCH_ASSOC);
						}
						catch(PDOException $e){
							print("DB接続エラー！:" . $e -> getMessage());
						}

						foreach($items as $item){
					?>
					<div class="products-box">
						<div class="new-img-box-2">
							<img src="item_img/<?php print($item["img_name"]); ?>" class="new-img">
						</div>
						<div class="new-txt-box-2">
							<div class="new-name-area">
								<div class="new-name">
									<?php print s($item["item_name"]); ?>
								</div>
							</div>
							<div class="new-txt">
								<?php print s(nl2br($item["comment"])); ?>
							</div>
							<div class="new-price">
								<?php print s("￥".$item["price"]); ?>
								<div class="new-tax">(税込)</div>
							</div>
						</div>
					</div>
					<?php
						}
					?>

					<?php
						//新着表示商品コード3
						$new_3 = 1;
						try{
							$sql ="SELECT * FROM item WHERE code = :code";
							$statement = $pdo -> prepare($sql);
							$statement -> bindValue(":code",$new_3);
							$statement -> execute();
							$items = $statement -> fetchAll(PDO::FETCH_ASSOC);
						}
						catch(PDOException $e){
							print("DB接続エラー！:" . $e -> getMessage());
						}

						foreach($items as $item){
					?>
					<div class="products-box">
						<div class="new-img-box-3">
							<img src="item_img/<?php print($item["img_name"]); ?>" class="new-img">
						</div>
						<div class="new-txt-box-3">
							<div class="new-name-area">
								<div class="new-name">
									<?php print s($item["item_name"]); ?>
								</div>
							</div>
							<div class="new-txt">
								<?php print s(nl2br($item["comment"])); ?>
							</div>
							<div class="new-price">
								<?php print s("￥".$item["price"]); ?>
								<div class="new-tax">(税込)</div>
							</div>
						</div>
					</div>
					<?php
						}
					?>
				</div>

				<!--=[もっと見るボタン]=-->
				<div id="new-more-btn-area">
					<a href="other/products/all.php" id="to-all-btn" class="more-btn">
						<span>もっと見る
							<canvas class="btn-icon"></canvas>
						</span>
						<span>get item!</span>
					</a>
				</div>
			</div>


			<!--[SALE]-->
			<div class="contents">
				<article id="sale-title-outer">
					<div id="sale-title">
						<div class="head-word">S</div>
						<div class="foot-word">ALE ITEM</div>
					</div>
					<span class="white-line-s"></span>
					<span class="back-line-s"></span>
				</article>

				<div id="sale-products-area">
					<?php
						//sale表示商品コード1
						$sale_1 = 3;
						//sale1 定価
						$before_price = '19000';
						try{
							$sql ="SELECT * FROM item WHERE code = :code";
							$statement = $pdo -> prepare($sql);
							$statement -> bindValue(":code",$sale_1);
							$statement -> execute();
							$items = $statement -> fetchAll(PDO::FETCH_ASSOC);
						}
						catch(PDOException $e){
							print("DB接続エラー！:" . $e -> getMessage());
						}

						foreach($items as $item){
					?>
					<div class="sale-box">
						<div class="sale-img-box-1">
							<img src="item_img/<?php print($item["img_name"]); ?>" class="sale-img">
						</div>
						<div class="sale-txt-box-1">
							<div class="sale-name-area">
								<div class="sale-name">
									<?php print s($item["item_name"]); ?>
								</div>
							</div>
							<div class="sale-txt">
								<?php print s(nl2br($item["comment"])); ?>
							</div>
							<div class="sale-price-outer">
								<div class="sale-price-before">
									<?php print s("￥".$before_price); ?>
									<div class="sale-tax">(税込)</div>
								</div>

								<span class="sale-arrow">↓</span>

								<div class="sale-price-after">
									<?php print s("￥".$item["price"]); ?>
									<div class="sale-after-tax">(税込)</div>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>

					<?php
						//sale表示商品コード2
						$sale_2 = 4;
						//sale2 定価
						$before_price = '20000';
						try{
							$sql ="SELECT * FROM item WHERE code = :code";
							$statement = $pdo -> prepare($sql);
							$statement -> bindValue(":code",$sale_2);
							$statement -> execute();
							$items = $statement -> fetchAll(PDO::FETCH_ASSOC);
						}
						catch(PDOException $e){
							print("DB接続エラー！:" . $e -> getMessage());
						}

						foreach($items as $item){
					?>
					<div class="sale-box">
						<div class="sale-img-box-2">
							<img src="item_img/<?php print($item["img_name"]); ?>" class="sale-img">
						</div>
						<div class="sale-txt-box-2">
							<div class="sale-name-area">
								<div class="sale-name">
									<?php print s($item["item_name"]); ?>
								</div>
							</div>
							<div class="sale-txt">
								<?php print s(nl2br($item["comment"])); ?>
							</div>
							<div class="sale-price-outer">
								<div class="sale-price-before">
									<?php print s("￥".$before_price); ?>
									<div class="sale-tax">(税込)</div>
								</div>

								<span class="sale-arrow">↓</span>

								<div class="sale-price-after">
									<?php print s("￥".$item["price"]); ?>
									<div class="sale-after-tax">(税込)</div>
								</div>
							</div>
						</div>
					</div>
					<?php
						}
					?>

					<?php
						//sale表示商品コード3
						$sale_3 = 5;
						//sale3 定価
						$before_price = '20000';
						try{
							$sql ="SELECT * FROM item WHERE code = :code";
							$statement = $pdo -> prepare($sql);
							$statement -> bindValue(":code",$sale_3);
							$statement -> execute();
							$items = $statement -> fetchAll(PDO::FETCH_ASSOC);
						}
						catch(PDOException $e){
							print("DB接続エラー！:" . $e -> getMessage());
						}

						foreach($items as $item){
					?>
					<div class="sale-box">
						<div class="sale-img-box-3">
							<img src="item_img/<?php print($item["img_name"]); ?>" class="sale-img">
						</div>
						<div class="sale-txt-box-3">
							<div class="sale-name-area">
								<div class="sale-name">
									<?php print s($item["item_name"]); ?>
								</div>
							</div>
							<div class="sale-txt">
								<?php print s(nl2br($item["comment"])); ?>
							</div>
							<div class="sale-price-outer">
								<div class="sale-price-before">
									<?php print s("￥".$before_price); ?>
									<div class="sale-tax">(税込)</div>
								</div>

								<span class="sale-arrow">↓</span>

								<div class="sale-price-after">
									<?php print s("￥".$item["price"]); ?>
									<div class="sale-after-tax">(税込)</div>
								</div>
							</div>
						</div>
					</div>
					<?php
						}
					?>
				</div>

				<!--=[もっと見るボタン]=-->
				<div id="sale-more-btn-area">
					<a href="other/products/all.php" id="to-all-btn" class="more-btn">
						<span>もっと見る
							<canvas class="btn-icon"></canvas>
						</span>
						<span>get item!</span>
					</a>
				</div>
			</div>

			<!--=[配送について]=-->
			<div id="delivery-container">
				<div id="delivery-outer">
					<dl class="delivery-inner">
						<dt class="delivery-heading">送料について</dt>
						<dd class="delivery-content">
							<ul class="delivery-list">
								<li>全国一律550円（税込）</li>
								<li>代引き手数料は弊社にて負担させていただきます。</li>
							</ul>
						</dd>
					</dl>

					<dl class="delivery-inner">
						<dt class="delivery-heading">配送業者について</dt>
						<dd class="delivery-content">
							<ul class="delivery-list">
								<li>ご注文製品のお届けは通常、運送会社が代行配達いたします。</li>
								<li>ご注文製品は、当日15時までのご注文の場合、当日中に発送致します。
									<br>
									商品により倉庫が異なる等の理由で1週間以内のお届けとなる可能性がございます。</li>
								<div class="delivery-caution">
									※在庫切れの場合、夏季・年末年始・土日・祝日のご注文は上記よりお時間をいただく場合がございます。
								</div>
								<li>弊社の提携する配送業者が商品をお届けします。配送業者のご指定は承っておりません。</li>
								<li>代引きにてご注文のお客様で、住所・電話番号・メールアドレスの表記の誤りにより、
									弊社側の連絡を行ってもご返信いただけない場合、注文をキャンセルする場合がございます。</li>
							</ul>
						</dd>
					</dl>

					<dl class="delivery-inner">
						<dt class="delivery-heading">発送日について</dt>
						<dd class="delivery-content">
							<ul class="delivery-list">
								<li>お支払い確認後、ご指定のメールアドレス宛に「荷物の追跡や問い合わせに必要な番号」を
									記載したメールを送信させていただきます。
									<br>
									また、マイアカウントページにてお客様の注文状況を確認していただくことができます。</li>
								<li>弊社繁忙期などの事由により、発送までにお時間をいただくことがあります。
									また、配送業者の混雑状況や天候、交通事情などにより、予定日に商品をお届けできないことがあります。
									あらかじめご了承ください。</li>
								<li>時間指定は承っておりません。お手数をお掛けして申し訳ございませんが、
									配送業者の不在届から再配達をご依頼ください。</li>
							</ul>
						</dd>
					</dl>

					<dl class="delivery-inner">
						<dt class="delivery-heading">海外への発送について</dt>
						<dd class="delivery-content">
							<ul class="delivery-list">
								<li>対応しておりません。</li>
							</ul>
						</dd>
					</dl>
				</div>
			</div>
		</main>

		<!--==[フッター]==-->
		<?php
			require("footer.php");
		?>
	</body>
</html>
