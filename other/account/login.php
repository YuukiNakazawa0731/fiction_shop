<?php
	//==[contents]==//
	$contents = "account";

	require_once("../base_cont.php");

	require_once("../shop_DB.php");
	$pdo = db_connect();

	//二重送信防止トークン
	$token = "token_on";
	$_SESSION["signup_token"] = $token;
	
	//変数初期化
	$login_err = "";
	$err_form = "";
	$signup_err = "";

	//ログインボタンが押された時
	if(!empty($_POST["login_submit"])){
		$login_id = ($_POST['login_id']);
		$login_pass = ($_POST['login_pass']);

		//SQL接続
		try{
			$sql = "SELECT * FROM pass WHERE mail_ad = ?";
			$statement = $pdo -> prepare($sql);
			$statement -> bindValue(1, $login_id, PDO::PARAM_STR);
			$statement -> execute();

			$account = $statement -> fetch(PDO::FETCH_ASSOC);

			//認証処理
			if($account && password_verify($login_pass, $account['password'])){
				$_SESSION["account_name"] = $account["first_name"].$account["last_name"];
				$_SESSION["account_mail"] = $account["mail_ad"];
				$_SESSION["account_post_code"] = $account["post_code"];
				$_SESSION["account_address"] = $account["prefectures"].$account["address1"].$account["address2"].$account["address3"];
				$_SESSION["login"] = "login";
				$_SESSION["admin"] = $account["admin"];
				header("Location:../../shop.php");
			}
			else{
				$login_err = "IDまたはパスワードが違います";
				$err_form = "err";
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
		<title>fiction shop ログイン</title>
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
				<a class="bread-list" href="#">ログイン</a>
			</div>

			<!--==[コンテンツ]==-->
			<div id="other-container">
				<section class="section-title-outer">
					<div class="section-title">ログインフォーム</div>
				</section>

				<!--==[ログインフォーム]==-->
				<form id="login-form" action="" method="POST">
					<input type="hidden" id="err-form" name="err_form" value="<?php print s($err_form); ?>">
					<div class="login-list">
						<div class="login-id-label">ユーザーID(メールアドレス)
							<p class="err-login_id"><!-- error message --></p>
						</div>
						<input id="login-id" type="text" name="login_id" value="guest@fiction.com">
					</div>
					<div class="login-list">
						<div class="login-pass-label">パスワード
							<p class="err-login_pass"><!-- error message --></p>
						</div>
						<input id="login-pass" type="password" name="login_pass" value="password">
					</div>

					<div id="login-check-area">
						<input type="checkbox" id="login-checkbox" name="pass_check">
						<label for="login-checkbox" id="login-checklabel">パスワードの表示</label>
					</div>

					<div id="login-submit-area">
						<input type="submit" id="login-submit" class="local-btn" name="login_submit" value="ログイン">
						<div id="login-err">
							<!--エラーコメント-->
							<?php print s($login_err); ?>
						</div>
					</div>

					<div id="to-signup-area">
						<nav id="to-signup-nav" class="fla-nav">新規登録はこちら</nav>
					</div>
				</form>
			</div>

			<!--return_btn-->
			<div id="other-return-outer">
				<button id="other-return-btn" class="block-btn">BACK</button>
			</div>


			<!--==[新規登録フォーム]==-->
			<div id="signup-ol" style="display: <?php print($signup_disp); ?>;">
				<section id="signup-title">新規登録フォーム</section>

				<div id="signup-form-outer">
					<form id="signup-form" action="signup_check.php" method="post">
						<div class="item-outer">
							<dl class="input-area">
								<dt class="input-list">お名前
									<span class="required-icon">※</span>
								</dt>
								<dd class="input-item">
									<div class="item-outer">
										<div class="item-label">性
											<p class="err-first_name"><!-- error message --></p>
										</div>
										<input type="text" id="first-name" class="input-case-s" name="first_name" value="">
									</div>
									<div class="item-outer">
										<div class="item-label">名
											<p class="err-last_name"><!-- error message --></p>
										</div>
										<input type="text" id="last-name" class="input-case-s" name="last_name" value="">
									</div>
								</dd>
							</dl>

							<dl class="input-area">
								<dt class="input-list">郵便番号
									<span class="required-icon">※</span>
								</dt>
								<dd class="input-item">
									<div class="item-outer">
										<div class="item-label">
											<p class="err-post_code"><!-- error message --></p>
										</div>
										<input type="text" id="post-code" class="input-case-m" name="post_code" value=""
										onKeyUp="AjaxZip3.zip2addr('post_code','','prefectures','address1');">
										<div class="item-label">半角(ハイフンあり)</div>
									</div>
								</dd>
							</dl>

							<dl class="input-area">
								<dt class="input-list">都道府県
									<span class="required-icon">※</span>
								</dt>
								<dd class="input-item">
									<div class="item-outer">
										<div class="item-label">
											<p class="err-prefectures"><!-- error message --></p>
										</div>
										<select id="prefectures" class="input-case-m" name="prefectures" value="">
											<option value="" selected>--選択して下さい--</option>
											<option value="北海道">北海道</option>
											<option value="青森県">青森県</option>
											<option value="岩手県">岩手県</option>
											<option value="宮城県">宮城県</option>
											<option value="秋田県">秋田県</option>
											<option value="山形県">山形県</option>
											<option value="福島県">福島県</option>
											<option value="茨城県">茨城県</option>
											<option value="栃木県">栃木県</option>
											<option value="群馬県">群馬県</option>
											<option value="埼玉県">埼玉県</option>
											<option value="千葉県">千葉県</option>
											<option value="東京都">東京都</option>
											<option value="神奈川県">神奈川県</option>
											<option value="新潟県">新潟県</option>
											<option value="富山県">富山県</option>
											<option value="石川県">石川県</option>
											<option value="福井県">福井県</option>
											<option value="山梨県">山梨県</option>
											<option value="長野県">長野県</option>
											<option value="岐阜県">岐阜県</option>
											<option value="静岡県">静岡県</option>
											<option value="愛知県">愛知県</option>
											<option value="三重県">三重県</option>
											<option value="滋賀県">滋賀県</option>
											<option value="京都府">京都府</option>
											<option value="大阪府">大阪府</option>
											<option value="兵庫県">兵庫県</option>
											<option value="奈良県">奈良県</option>
											<option value="和歌山県">和歌山県</option>
											<option value="鳥取県">鳥取県</option>
											<option value="島根県">島根県</option>
											<option value="岡山県">岡山県</option>
											<option value="広島県">広島県</option>
											<option value="山口県">山口県</option>
											<option value="徳島県">徳島県</option>
											<option value="香川県">香川県</option>
											<option value="愛媛県">愛媛県</option>
											<option value="高知県">高知県</option>
											<option value="福岡県">福岡県</option>
											<option value="佐賀県">佐賀県</option>
											<option value="長崎県">長崎県</option>
											<option value="熊本県">熊本県</option>
											<option value="大分県">大分県</option>
											<option value="宮崎県">宮崎県</option>
											<option value="鹿児島県">鹿児島県</option>
											<option value="沖縄県">沖縄県</option>
										</select>
									</div>
								</dd>
							</dl>

							<dl class="input-area">
								<dt class="input-list">住所(市区町村)
									<span class="required-icon">※</span>
								</dt>
								<dd class="input-item">
									<div class="item-outer">
										<div class="item-label">
											<p class="err-address_1"><!-- error message --></p>
										</div>
										<input type="text" id="address-1" class="input-case-l" name="address_1" value="">
									</div>
								</dd>
							</dl>

							<dl class="input-area">
								<dt class="input-list">番地
									<span class="required-icon">※</span>
								</dt>
								<dd class="input-item">
									<div class="item-outer">
										<div class="item-label">
											<p class="err-address_2"><!-- error message --></p>
										</div>
										<input type="text" id="address-2" class="input-case-l" name="address_2" value="">
									</div>
								</dd>
							</dl>

							<dl class="input-area">
								<dt class="input-list">マンション名など</dt>
								<dd class="input-item">
									<div class="item-outer">
										<div class="item-label"></div>
										<input type="text" id="address-3" class="input-case-l" name="address_3" value="">
									</div>
								</dd>
							</dl>

							<dl class="input-area">
								<dt class="input-list">メールアドレス(ID)
									<span class="required-icon">※</span>
								</dt>
								<dd class="input-item">
									<div class="item-outer">
										<div class="item-label">
											<p class="err-mail_ad"><!-- error message --></p>
										</div>
										<input type="text" id="mail-ad" class="input-case-l" name="mail_ad" value="">
									</div>
								</dd>
							</dl>

							<dl class="input-area">
								<dt class="input-list">パスワード
									<span class="required-icon">※</span>
								</dt>
								<dd class="input-item">
									<div class="item-outer">
										<div class="item-label">
											<p class="err-password"><!-- error message --></p>
										</div>
										<input type="text" id="signup-pass" class="input-case-l" name="password" value="">
									</div>
								</dd>
							</dl>

							<dl id="check-submit-area">
								<!--戻るボタン-->
								<span id="signup-return-btn" class="block-btn">戻る</span>
								<input type="hidden" name="admin" value="OFF">
								<input type="submit" class="local-btn" name="check_submit" value="確認画面へ">
							</dl>
						</div>
					</form>
				</div>

				<!--リザルト-->
				<div id="signup-err-outer">
					<div id="signup-err">
						<!-- error message -->
						<?php print ($signup_err); ?>
					</div>
				</div>
			</div>
		</main>

		<!--==[フッター]==-->
		<?php
			require("../../footer.php");
		?>
	</body>
</html>
