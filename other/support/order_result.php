<?php
	//==[contents]==//
	$contents = "support";

	require_once("../base_cont.php");
?>


<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>注文履歴</title>
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
				<a class="bread-list" href="#">注文履歴</a>
			</div>

			<!--==[コンテンツ]==-->
			<div id="other-container">
				<section class="section-title-outer">
					<div class="section-title">注文履歴</div>
				</section>

				<div class="order-container">
					<div class="order-form-outer">
						<?php
							//--[購入履歴表示]--//
							//DB接続
							require_once("../shop_DB.php");
							$pdo = db_connect();
							try{
								//sql(個人購入履歴)
								$sql ="SELECT * FROM order_result WHERE user_id LIKE :user_id ORDER BY order_no DESC";
								$statement = $pdo -> prepare($sql);
								$statement -> bindValue(":user_id", $user_id);
								$statement -> execute();
								$order_count = $statement -> rowCount();
							}
							catch(PDOException $Exception){
								print('接続エラー:'.$Exception -> getMessage());
							}

							if($order_count == 0){
								$on_result = "none";
								$off_result = "";
								$no_result = "購入履歴はありません";
							}
							else{
								$on_result = "";
								$off_result = "none";
								$no_result = "";

								while($result = $statement -> fetch(PDO::FETCH_ASSOC)){
								?>

								<form class="order-form" style="display:<?php print ($on_result); ?>">
									<div class="order-form-img-outer">
										<?php print (img_tag($result["img_name"],150)); ?>
									</div>

									<div class="order-form-lead-outer">
										<div class="order-form-lead">
											<div class="order-form-list">注文日:</div>
											<div class="order-form-item">
												<?php
													$date = ($result["order_date"]);
													print date("Y年m月d日", strtotime($date));
												?>
											</div>
										</div>
										<div class="order-form-lead">
											<div class="order-form-list">商品名:</div>
											<div class="order-form-item">
											<?php print s($result["item_name"]); ?>
											</div>
										</div>
										<div class="order-form-lead">
											<div class="order-form-list">価格:</div>
											<div class="order-form-item">
												<div class="order-result-price-outer">￥
													<div class="order-result-price">
														<?php print s($result["price"]); ?>
													</div>
													<div class="order-result-price-tax">(税込)</div>
												</div>
											</div>
										</div>
										<div class="order-form-lead">
											<div class="order-form-list">数量:</div>
											<div class="order-form-item">
												<?php print s($result["amount"]); ?>
											</div>
										</div>
									</div>

									<div class="order-form-cont">
										<div class="order-result-state-outer" style="display:<?php print ($on_state); ?>">
											<?php
												if($result["state_date"] == 0000-00-00){
													$state_date_disp = "none";
												}

												if($result["state"] == "未発送"){
													$on_state = "none";
													$state_color = "red";
												}
												elseif($result["state"] == "入荷待ち"){
													$state_color = "green";
												}
												elseif($result["state"] == "返品済"){
													$state_color = "orange";
												}
												else{
													$on_state = "";
													$state_color = "black";
												}

												$state_date = ($result["state_date"]);
											?>

											<div class="order-result-state-date">
												<div class="order-result-state-year">
													<?php print date("Y年", strtotime($state_date)); ?>
												</div>
												<div class="order-result-state-year">
													<?php print date("m月d日", strtotime($state_date)); ?>
												</div>
											</div>
											<div class="order-result-state" style="color:<?php print ($state_color); ?>">
												<?php print s($result["state"]); ?>
											</div>
										</div>
									</div>
								</form>
								<?php
								}
							}
						?>
					</div>
				</div>

				<div id="no-result" style="display:<?php print ($off_result); ?>">
					<?php print s($no_result); ?>
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
