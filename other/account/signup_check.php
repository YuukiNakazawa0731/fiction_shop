<?php
	//==[contents]==//
	$contents = "account";

	require_once("../base_cont.php");
	require_once("../shop_DB.php");

	//二重送信防止/直接アクセス防止トークン
	if(!isset($_SESSION["signup_token"])){
		header("Location:login.php");
	}

	$pdo = db_connect();

	if(isset($_POST["check_submit"])){
		$first_name = $_POST["first_name"];
		$last_name = $_POST["last_name"];
		$post_code = $_POST["post_code"];
		$prefectures = $_POST["prefectures"];
		$address1 = $_POST["address_1"];
		$address2 = $_POST["address_2"];
		$address3 = $_POST["address_3"];
		$password = $_POST["password"];
		$mail_ad = $_POST["mail_ad"];
		$admin = $_POST["admin"];

		try{
			$sql = "SELECT * FROM pass WHERE mail_ad = :mail_ad";
			$statement = $pdo -> prepare($sql);
			$statement -> bindParam(":mail_ad",$mail_ad);
			$statement -> execute();
			$match_id = $statement -> rowCount();

			//入力アドレス重複チェック
			if($match_id != 0){
				$signup_result = "このメールアドレスは登録済みです";
				$err_boder = ".3rem dotted red";
				$err_color = "red";
			}
			else{
				//パスワード暗号化
				$hash_pass = password_hash($password,PASSWORD_BCRYPT);
				//SQL接続
				try{
					$sql = "INSERT INTO pass (first_name,last_name,post_code,prefectures,address1,address2,address3,password,mail_ad,admin) VALUES (:first_name,:last_name,:post_code,:prefectures,:address1,:address2,:address3,:password,:mail_ad,:admin)";
					$statement = $pdo -> prepare($sql);
					$statement -> bindValue(":first_name", $first_name);
					$statement -> bindValue(":last_name", $last_name);
					$statement -> bindValue(":post_code", $post_code);
					$statement -> bindValue(":prefectures", $prefectures);
					$statement -> bindValue(":address1", $address1);
					$statement -> bindValue(":address2", $address2);
					$statement -> bindValue(":address3", $address3);
					$statement -> bindValue(":password", $hash_pass);
					$statement -> bindValue(":mail_ad", $mail_ad);
					$statement -> bindValue(":admin", "OFF");
					$statement -> execute();
					$signup_result = "上記の内容で登録しました";

					//セッションを破棄
					unset($_SESSION["signup_token"]);
				}
				catch(PDOException $e){
					print("DB接続エラー！:" . $e -> getMessage());
				}
			}
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
		<title>fiction shop 新規登録内容確認</title>
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
		<header>
			<div id="header-contents-l">
				<a href="../../shop.php" class="main-link">
					<img src="../../images/logo_title.png" id="header-logo" alt="logo">
				</a>
			</div>
			<div id="header-contents-r"></div>
		</header>

		<main>
			<!--==[コンテンツ]==-->
			<div id="signup-result-container">
				<section id="signup-result-title-outer">
					<div id="signup-result-title">新規登録内容確認</div>
				</section>

				<div id="signup-result-outer" style="border: <?php print ($err_boder); ?>">
					<dl class="signup-result-list">
						<dt class="signup-result-label">お名前：</dt>
						<dd class="signup-result-item">
							<?php print s($first_name.$last_name); ?>
						</dd>
					</dl>

					<dl class="signup-result-list">
						<dt class="signup-result-label">郵便番号：</dt>
						<dd class="signup-result-item">
							<?php print s($post_code); ?>
						</dd>
					</dl>

					<dl class="signup-result-list">
						<dt class="signup-result-label">ご住所：</dt>
						<dd class="signup-result-item">
							<?php print s($prefectures.$address1.$address2.$address3); ?>
						</dd>
					</dl>

					<dl class="signup-result-list">
						<dt class="signup-result-label">メールアドレス(ID)：</dt>
						<dd class="signup-result-item">
							<?php print s($mail_ad); ?>
						</dd>
					</dl>

					<dl class="signup-result-list">
						<dt class="signup-result-label">パスワード：</dt>
						<dd class="signup-result-item">
							<?php print s($password); ?>
						</dd>
					</dl>
				</div>

				<div id="signup-result-txt-outer">
					<p id="signup-result-txt" style="color: <?php print ($err_color); ?>">
						<?php print ($signup_result); ?>
					</p>
				</div>

				<div id="signup-return-nav-outer">
					<nav class="fla-nav">画面クリックでログインページへ</nav>
				</div>
			</div>
		</main>
	</body>
</html>
