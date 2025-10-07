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
	$pdo = db_connect();

	//変数初期化
	$code =  "";
	$now_img =  "";
	$img_name = "";
	$item_name = "";
	$comment =  "";
	$price =  "";
	$stock = "";
	$up_file= "";
	$edit_result = "";
	$err_result = "";
	$edit_disp = "";

	//更新処理
	if(isset($_POST["item_edit"])){
		//変数を代入
		$code = s($_POST["code_edit"]);
		$now_img = s($_POST["now_img"]);
		$item_name = s($_POST["name_edit"]);
		$comment = s($_POST["txt_edit"]);
		$price = s($_POST["price_edit"]);
		$stock = s($_POST["stock_edit"]);
		$up_file = $_FILES["img_name"]["name"];
		//画像更新がない時
		if($up_file == ""){
			$img_name = $now_img;
		}
		//画像更新があった時
		else{
			$img_name = $up_file;
			//DBに登録
			try{
				$pdo -> beginTransaction();
				$sql = "UPDATE item SET item_name=:item_name, price=:price, comment=:comment, stock=:stock, img_name=:img_name WHERE code = :code";
				$statement = $pdo -> prepare($sql);
				$statement -> bindParam(":code",$code);
				$statement -> bindParam(":img_name",$img_name);
				$statement -> bindParam(":item_name",$item_name);
				$statement -> bindParam(":comment",$comment);
				$statement -> bindParam(":price",$price);
				$statement -> bindParam(":stock",$stock);
				$statement -> execute();
				$pdo -> commit();
				$edit_disp = "";
				$edit_result = "商品情報を更新しました";
			}
			catch(PDOException $e){
				$edit_disp = "none";
				print("DB接続エラー！:" . $e -> getMessage());
				$err_result = "更新できませんでした";
			}
		}
	}


	//削除処理
	if(isset($_POST["item_delete"])){
		$code = s($_POST["code_edit"]);
		$pdo -> beginTransaction();

		try{
			$sql = "DELETE FROM item WHERE code = :code";
			$statement = $pdo -> prepare($sql);
			$statement -> bindParam(":code",$code);
			$statement -> execute();
			$pdo -> commit();
			$edit_disp = "none";
			$edit_result = "商品を削除しました";
		}
		catch(PDOException $e){
			$edit_disp = "none";
			print("DB接続エラー！:" . $e -> getMessage());
			$err_result = "削除できませんでした";
		}
	}


	//商品登録
	if(isset($_POST["signup_item_submit"])){
		$item_name = s($_POST["signup_item_name"]);
		$comment = s($_POST["signup_item_txt"]);
		$price = s($_POST["signup_item_price"]);
		$stock = s($_POST["signup_item_stock"]);
		$img_name = s($_FILES["signup_img_name"]["name"]);

		if(!isset($img_name)){
			$err_result = "画像ファイルを選択してください";
		}
		else{
			try{
				$sql = "INSERT INTO item (item_name,price,comment,stock,img_name) VALUE (:item_name,:price,:comment,:stock,:img_name)";
				$statement = $pdo -> prepare($sql);
				$statement -> bindParam(":item_name",$item_name);
				$statement -> bindParam(":comment",$comment);
				$statement -> bindParam(":price",$price);
				$statement -> bindParam(":stock",$stock);
				$statement -> bindParam(":img_name",$img_name);
				$statement -> execute();
				$edit_result = "商品を登録しました";
				$edit_disp = "";
			}
			catch(PDOException $e){
				print("DB接続エラー！:" . $e -> getMessage());
				$err_result = "登録できませんでした";
			}
		}
	}
?>


<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>商品編集結果</title>
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="../../css/full/common.css" media="screen and (min-width: 1024px)">
		<link rel="stylesheet" href="../../css/middle/common_middle.css" media="screen and (min-width:481px) and (max-width:1023px)">
		<link rel="stylesheet" href="../../css/mobile/common_mobile.css" media="screen and (max-width:480px)">
		<link rel="stylesheet" href="../../css/full/products.css" media="screen and (min-width: 1024px)">
		<link rel="stylesheet" href="../../css/middle/products_middle.css" media="screen and (min-width:481px) and (max-width:1023px)">
		<link rel="stylesheet" href="../../css/mobile/products_mobile.css" media="screen and (max-width:480px)">
		<link rel="shortcut icon" href="../../images/favicon.ico">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
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
				<a class="bread-list" href="item_manage.php">商品管理</a>
				<span class="bread-arrow">></span>
				<a class="bread-list" href="item_signup.php">商品登録</a>
				<span class="bread-arrow">></span>
				<a class="bread-list" href="#">更新結果</a>
			</div>

			<!--==[コンテンツ]==-->
			<div id="other-container">
				<section class="section-title-outer">
					<div class="section-title">更新結果</div>
				</section>

				<!--=商品更新結果=-->
				<div class="edit-container">
					<div class="edit-form-outer" style="display: <?php print($edit_disp); ?>;">
						<form action="item_edit.php" class="edit-form" method="POST" enctype="multipart/form-data">
							<div class="edit-img-outer">
								<img src="../../item_img/<?php print($img_name); ?>" class="edit-img">
							</div>

							<div class="edit-result-lead-outer">
								<div class="edit-item-lead">
									<div class="edit-item-list">商品名:</div>
									<div class="edit-result-item">
										<?php print s($item_name); ?>
									</div>
								</div>

								<div class="edit-item-lead">
									<div class="edit-item-list">コメント:</div>
									<div class="edit-result-item">
										<?php print s($comment); ?>
									</div>
								</div>

								<div class="edit-item-lead">
									<div class="edit-item-list">価格:</div>
									<div class="edit-result-item">
										<?php print s($price); ?>
									</div>
								</div>

								<div class="edit-item-lead">
									<div class="edit-item-list">在庫数量:</div>
									<div class="edit-result-item">
										<?php print s($stock); ?>
									</div>
								</div>
							</div>
						</form>
					</div>

					<div id="edit-result-outer">
						<div id="safe-result">
							<?php print ($edit_result); ?>
						</div>
						<div id="err-result">
							<?php print ($err_result); ?>
						</div>
					</div>

					<div id="edit-return-btn-outer">
						<button type="button" id="edit-return-btn" class="edit-btn">商品管理へ</button>
					</div>
				</div>

				<!--return_btn-->
				<div id="other-return-outer">
					<button id="edit-return-back-btn" class="block-btn">BACK</button>
				</div>
			</div>
		</main>

		<!--==[フッター]==-->
		<?php
			require("../../footer.php");
		?>
	</body>
</html>
