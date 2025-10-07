<?php
	//==[contents]==//
	$contents = "support";

	//DB接続
	require_once("../base_cont.php");
	require_once("../shop_DB.php");
	$pdo = db_connect();

		//直接アクセス禁止
		if($_SESSION["admin"] != "ON"){
			header("Location:../../shop.php");
		}
	
	//情報更新時
	if(isset($_POST["state_update"])){
		$order_manage_state = $_POST["order_manage_state"];
		$action_date = $_POST["action_date"];
		$order_no = $_POST["order_no"];

		if($action_date == ""){
			$action_date = '0000-00-00';
		}
		try{
			$sql = "UPDATE order_result SET state=:state,state_date=:state_date WHERE order_no=:order_no";
			$statement = $pdo -> prepare($sql);
			$statement -> bindValue(":state",$order_manage_state);
			$statement -> bindValue(":state_date",$action_date);
			$statement -> bindValue(":order_no",$order_no);
			$statement -> execute();
		}
		catch(PDOException $e){
			print("DB接続エラー！:" . $e -> getMessage());
		}
	}

	//注文削除
	if(isset($_POST["delete_order"])){
		$order_no = $_POST["order_no"];

		$pdo -> beginTransaction();
		try{
			$sql = "DELETE FROM order_result WHERE order_no=:order_no";
			$statement = $pdo -> prepare($sql);
			$statement -> bindValue(":order_no",$order_no);
			$statement -> execute();
			$pdo -> commit();

		}
		catch(PDOException $e){
			print("DB接続エラー！:" . $e -> getMessage());
		}
	}
?>


<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>注文管理</title>
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
				<a class="bread-list" href="#">注文管理</a>
			</div>

			<!--==[コンテンツ]==-->
			<div id="other-container">
				<section class="section-title-outer">
					<div class="section-title">注文管理</div>
				</section>

				<!--注文履歴検索フォーム-->
				<form id="order-search-form" action="" method="POST">
					<div id="search-list-outer">
						<div class="search-list">
							<div class="search-list-head">注文No</div>
							<input type="text" class="search-item" name="search_no" value="">
						</div>
						<div class="search-list">
							<div class="search-list-head">注文日</div>
							<input type="date" class="search-item" name="search_date" alue="">
						</div>
						<div class="search-list">
							<div class="search-list-head">商品名</div>
							<input type="text" class="search-item" name="search_name" value="">
						</div>
						<div class="search-list">
							<div class="search-list-head">ID</div>
							<input type="text" class="search-item" name="search_id" value="">
						</div>
						<div class="search-list">
							<div class="search-list-head">対応日</div>
							<input type="date" class="search-item" name="search-state-date" value="">
						</div>
						<div class="search-list">
							<div class="search-list-head">対応</div>
							<select class="search-item" name="search-state">
								<option value=""></option>
								<option value="未発送">未発送</option>
								<option value="発送済">発送済</option>
								<option value="入荷待ち">入荷待ち</option>
								<option value="返品済">返品済</option>
							</select>
						</div>
					</div>
					<div class="search-btn-outer">
						<button type="submit" class="edit-btn" name="order_search">
							<p class="search-btn-txt">検索</p>
							<img src="../../images/search_icon.png" class="order-search-icon" alt="search_icon">
						</button>
					</div>
				</form>

				<div class="order-form-outer" class="scroll-bar">
					<?php
						//注文履歴検索
						if(isset($_POST["order_search"])){
							$search_no = s($_POST["search_no"]);
							$search_date = s($_POST["search_date"]);
							$search_name = s($_POST["search_name"]);
							$search_id = s($_POST["search_id"]);
							$search_state_date = s($_POST["search_state_date"]);
							$search_state = s($_POST["search_state"]);

							$sql = "SELECT * FROM order_result WHERE 1=1";
							if($search_no != ""){
								$sql .= " AND order_no = $search_no";
							}
							if($search_date != ""){
								$sql .= " AND order_date LIKE '%$search_date%'";
							}
							if($search_name != ""){
								$sql .= " AND item_name = '$search_name'";
							}
							if($search_id != ""){
								$sql .= " AND user_id = '$search_id'";
							}
							if($search_state_date != ""){
								$sql .= " AND state_date = '$search_state_date'";
							}
							if($search_state != ""){
								$sql .= " AND state = '$search_state'";
							}
							$sql .= " ORDER BY order_no DESC";
						}
						//検索なしで一覧表示
						else{
							$sql = "SELECT * FROM order_result ORDER BY order_no DESC";
						}
						$statement = $pdo -> prepare($sql);
						$statement -> execute();
						$result_count = $statement -> rowCount();

						while($result = $statement -> fetch(PDO::FETCH_ASSOC)){
					?>

				<!--注文履歴一覧-->
					<form class="order-form" action="" method="POST">
						<!--商品画像-->
						<div class="order-form-img-outer">
							<?php print (img_tag($result["img_name"],150)); ?>
						</div>
						<!--商品詳細-->
						<div class="order-form-lead-outer">
							<div class="order-form-lead">
								<div class="order-form-list">注文No:</div>
								<div class="order-form-item">
									<?php print s($result["order_no"]); ?>
								</div>
							</div>

							<div class="order-form-lead">
								<div class="order-form-list">注文日:</div>
								<div class="order-form-item">
									<?php
										$date = s($result["order_date"]);
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
									<?php print s("￥".$result["price"]); ?>
								</div>
							</div>
							<div class="order-form-lead">
								<div class="order-form-list">注文数:</div>
								<div class="order-form-item">
									<?php print s($result["amount"]); ?>
								</div>
							</div>
							<div class="order-form-lead">
								<div class="order-form-list">ID:</div>
								<div class="order-form-item">
									<?php print s($result["user_id"]); ?>
								</div>
							</div>
						</div>
						<!--商品発送コントロール-->
						<div class="order-form-cont">
							<!--発送状態-->
							<div class="order-state-outer">
								<?php
									if($result["state_date"] == 0000-00-00){
										$state_date_disp = "none";
									}
									//対応表示
									if($result["state"] == "未発送"){
										$off_state = "none";
										$state_color = "red";
									}
									elseif($result["state"] == "入荷待ち"){
										$state_color = "green";
									}
									elseif($result["state"] == "返品済"){
										$state_color = "orange";
									}
									else{
										$off_state = "";
										$state_color = "blue";
									}
								?>
								<div class="state-disp" style="color:<?php print ($state_color); ?>">
									<?php print s($result["state"]); ?>
								</div>
								<div class="state-date-disp" style="display:<?php print ($off_state); ?>">
									<?php
										$state_date = s($result["state_date"]);
										print date("Y年m月d日", strtotime($state_date));
									?>
								</div>
								<!--発送状態編集-->
								<div class="order-state-cont">
									<div class="state-manage-item">
										<input type="date" class="action-date" name="action_date" value="">
									</div>
									<div class="state-manage-item">
										<select class="order-manage-state" name="order_manage_state">
											<option value="未発送">未発送</option>
											<option value="発送済">発送済</option>
											<option value="入荷待ち">入荷待ち</option>
											<option value="返品済">返品済</option>
										</select>
									</div>
									<div class="order-edit-btn-area">
										<input type="hidden" name="order_no" value="<?php print($result["order_no"]); ?>">
										<input type="submit" id="state-btn" class="edit-btn" name="state_update" value="登録">
										<input type="submit" id="delete-order-btn" class="edit-btn" name="delete_order" value="削除">
									</div>
								</div>
							</div>
						</div>
					</form>
					<?php
						}
						//表示件数なし
						if($result_count > 0){
							$off_order = "none";
						}
					?>
					<div id="no-result" style="display:<?php print ($off_order); ?>">注文履歴がありません</div>
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
