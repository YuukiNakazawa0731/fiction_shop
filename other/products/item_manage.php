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
		<title>商品管理</title>
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
				<a class="bread-list" href="#">商品管理</a>
			</div>

			<!--==[コンテンツ]==-->
			<div id="other-container">
				<section class="section-title-outer">
					<div class="section-title">商品管理</div>
				</section>

				<!--=商品一覧=-->
				<div class="edit-container">
					<div class="edit-form-outer-scroll">
						<?php
							require_once("../shop_DB.php");
							$pdo = db_connect();

							try{
								$statment = $pdo -> query("SELECT * FROM item");
								$items = $statment -> fetchAll();
							}
							catch(PDOException $e){
								print("DB接続エラー！:" . $e -> getMessage());
							}

							foreach ($items as $item){
						?>

						<form action="item_edit.php" class="edit-form" method="POST" enctype="multipart/form-data">
							<div class="edit-img-outer">
								<input type="hidden" name="MAX_FILE_SIZE" value="50000">
								<input type="hidden" name="now_img" value="<?php print($item["img_name"]); ?>">
								<input type="file" class="img-name" name="img_name" value=''>
								<img src="../../item_img/<?php print($item["img_name"]); ?>" class="edit-img">
							</div>

							<div class="edit-item-lead-outer">
								<div class="edit-item-lead">
									<div class="edit-item-list">商品コード:</div>
									<div class="edit-item-item">
										<input type="hidden" name="code_edit" value="<?php print s($item["code"]); ?>">
										<?php print s($item["code"]); ?>
									</div>
								</div>

								<div class="edit-item-lead">
									<div class="edit-item-list">商品名:</div>
									<div class="edit-item-item">
										<input type="text" class="input-edit" name="name_edit" required value="<?php print s($item["item_name"]); ?>">
									</div>
								</div>

								<div class="edit-item-lead">
									<div class="edit-item-list">コメント:</div>
									<div class="edit-item-item">
										<textarea class="input-edit-txt" name="txt_edit" rows="5" required>
											<?php print s($item["comment"]); ?>
										</textarea>
									</div>
								</div>

								<div class="edit-item-lead">
									<div class="edit-item-list">価格:</div>
									<div class="edit-item-item">
										<input type="number" class="input-edit" name="price_edit" required value="<?php print s($item["price"]); ?>">
									</div>
								</div>

								<div class="edit-item-lead">
									<div class="edit-item-list">在庫数量:</div>
									<div class="edit-item-item">
										<input type="number" class="input-edit" name="stock_edit" required value="<?php print s($item["stock"]); ?>">
									</div>
								</div>
							</div>

							<div class="item-edit-btn-outer">
								<div class="item-edit-btn">
									<input type="submit" id="item-edit-btn" class="edit-btn" name="item_edit" value="更新">
								</div>

								<div class="item-edit-btn">
									<input type="hidden" name="code" value="<?php print s($item["code"]); ?>">
									<input type="submit" id="item-edit-delete-btn" class="edit-btn" name="item_delete" value="削除">
								</div>
							</div>
						</form>
						<?php
							}
						?>
					</div>
				</div>

				<div id="item-signup-btn-outer">
					<button class="edit-btn" name="to_item_signup">新規登録</button>
				</div>
			</div>
		</main>

		<!--==[フッター]==-->
		<?php
			require("../../footer.php");
		?>
	</body>
</html>
