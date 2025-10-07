<!DOCTYPE html>
<html lang="ja">
	<head>
		<?php
			//==[パスコントロール]==//
			//-[shop]-//
			if($contents == "shop"){
				$p_shop = "shop.php";
				$p_login = "other/account/login.php";
				$p_mycart = "other/account/mycart.php";
				$p_all = "other/products/all.php";
				$p_order_result = "other/support/order_result.php";
				$p_order_manage = "other/support/order_manage.php";
				$p_item_manage = "other/products/item_manage.php";
				$p_item_signup = "other/products/item_signup.php";
				$p_labels = "other/support/labels.php";
				$p_privacy = "other/support/privacy.php";
				$p_main = "../fiction/main.php";
				$p_img = '';
				$p_logout = "";
			}

			//-[account]-//
			if($contents == "account"){
				$p_shop = "../../shop.php";
				$p_login = "login.php";
				$p_mycart = "mycart.php";
				$p_all = "../products/all.php";
				$p_order_result = "../support/order_result.php";
				$p_order_manage = "../support/order_manage.php";
				$p_item_manage = "../products/item_manage.php";
				$p_item_signup = "../products/item_signup.php";
				$p_labels = "../support/labels.php";
				$p_privacy = "../support/privacy.php";
				$p_main = "../../../fiction/main.php";
				$p_img = '../../';
				$p_logout = "-other";
			}

			//-[products]-//
			if($contents == "products"){
				$p_shop = "../../shop.php";
				$p_login = "../account/login.php";
				$p_mycart = "../account/mycart.php";
				$p_all = "all.php";
				$p_order_result = "../support/order_result.php";
				$p_order_manage = "../support/order_manage.php";
				$p_item_manage = "item_manage.php";
				$p_item_signup = "item_signup.php";
				$p_labels = "../support/labels.php";
				$p_privacy = "../support/privacy.php";
				$p_main = "../../../fiction/main.php";
				$p_img = '../../';
				$p_logout = "-other";
			}

			//-[support]-//
			if($contents == "support"){
				$p_shop = "../../shop.php";
				$p_login = "../account/login.php";
				$p_mycart = "../account/mycart.php";
				$p_all = "../products/all.php";
				$p_order_result = "order_result.php";
				$p_order_manage = "order_manage.php";
				$p_item_manage = "../products/item_manage.php";
				$p_item_signup = "../products/item_signup.php";
				$p_labels = "labels.php";
				$p_privacy = "privacy.php";
				$p_main = "../../../fiction/main.php";
				$p_img = '../../';
				$p_logout = "-other";
			}
		?>
	</head>

	<body>
		<header>
			<div id="header-contents-l">
				<a href="<?php print($p_shop); ?>" class="main-link">
					<img src="<?php print($p_img); ?>images/logo_title.png" id="header-logo" alt="logo">
				</a>
			</div>
			<div id="header-contents-r">
				<div id="header-menu-box">
					<div id="header-account" style="display: <?php print s($logon); ?>;">
						<img src="<?php print($p_img); ?>images/account.png" class="header-login-icon" alt="login_icon" style="display: <?php print s($logoff); ?>;">
						<p class="header-login-name">
							<?php print($account_name); ?>
						</p>
						<p id="name-after">さん</p>
					</div>
					<a href="<?php print s($p_login); ?>" id="header-login" style="display: <?php print s($logoff); ?>;">
						<img src="<?php print($p_img); ?>images/account.png" class="header-login-icon" alt="login_icon">
						<p class="header-login-txt">ログイン</p>
					</a>
					<a href="<?php print($p_mycart); ?>" id="header-cart" style="display: <?php print s($logon); ?>;">
						<img src="<?php print($p_img); ?>images/cart.png" id="header-cart-icon" alt="cart_icon">
						<p id="header-cart-txt">カート</p>
					</a>
					<div id="menu-icon-outer">
						<img src="<?php print($p_img); ?>images/menu_icon.png" id="menu-icon" alt="menu-icon">
					</div>
				</div>
			</div>

			<div id="sns-container">
				<ol id="sns-list">
					<li class="sns-item"><img src="<?php print($p_img); ?>images/facebook.png" alt="facebook"></li>
					<li class="sns-item"><img src="<?php print($p_img); ?>images/x.png" alt="X"></li>
					<li class="sns-item"><img src="<?php print($p_img); ?>images/LINE.png" alt="LINE"></li>
				</ol>
			</div>


			<!--==[メニューモーダル]==-->
			<div id="menu-modal">
				<div id="menu-bar">
					<div id="bar-head">
						<img src="<?php print($p_img); ?>images/close.png" id="close-icon" alt="close_icon">
					</div>
					<ol id="menu-list">
						<li class="menu-item" style="display: <?php print s($logoff); ?>;">
							<a href="<?php print($p_login); ?>" class="menu-child">ログイン</a>
						</li>
						<li class="menu-item" style="display: <?php print s($admin_on); ?>;">
							<div id="admin-menu">管理者メニュー</div>
						</li>
						<li class="menu-item" style="display: <?php print ($admin_on); ?>;">
							<a href="<?php print($p_order_manage); ?>" class="menu-child">注文管理</a>
						</li>
						<li class="menu-item" style="display: <?php print ($admin_on); ?>;">
							<a href="<?php print($p_item_manage); ?>" class="menu-child">商品管理</a>
						</li>
						<li class="menu-item" style="display: <?php print ($admin_on); ?>;">
							<a href="<?php print($p_item_signup); ?>" class="menu-child">商品登録</a>
						</li>
						<li class="menu-item">
							<a href="<?php print($p_all); ?>" class="menu-child">商品一覧</a>
						</li>
						<li class="menu-item" style="display: <?php print s($logon); ?>;">
							<a href="<?php print($p_mycart); ?>" class="menu-child">ショッピングカート</a>
						</li>
						<li class="menu-item" style="display:<?php print s($logon); ?>; justify-content:<?php print($align_view); ?>;">
							<a href="<?php print($p_order_result); ?>" class="menu-child">注文履歴</a>
						</li>
						<li class="menu-item">
							<a href="<?php print($p_labels); ?>" class="menu-child">特定商取引法に基づく表記</a>
						</li>
						<li class="menu-item">
							<a href="<?php print($p_privacy); ?>" class="menu-child">プライバシーポリシー</a>
						</li>
						<li class="menu-item" style="display:<?php print s($logon); ?>">
							<div id="logout-btn" class="menu-child">ログアウト</div>
						</li>
						<li class="menu-item">
							<a href="<?php print($p_main); ?>" class="menu-child">コーポレートサイトへ
								<img src="<?php print($p_img); ?>images/blank.png" id="blank-icon" alt="blank_icon">
							</a>
						</li>
					</ol>
				</div>
			</div>


			<!--==[ログアウトモーダル]==-->
			<?php
				if(isset($_POST["logout_submit"])){
					session_destroy();
				};
			?>
			<div id="logout-modal">
				<iframe id="logout-iframe" name="logout-iframe" style="display: none;"></iframe>
				<form target="logout-iframe" id="logout-container" method=post action="" >
					<p id="logout-nav">ログアウトしますか？</p>
					<div id="logout-btn-area">
						<button type="button" id="logout-return" class="block-btn" name="logout_return">戻る</button>
						<button type="submit" id="logout-submit" class="block-btn" name="logout_submit">ログアウト</button>
					</div>
				</form>
			</div>

			<!--[ログアウト完了]-->
			<div id="logout-thank-modal<?php print($p_logout); ?>">
				<div id="logout-thank">
					<div id="item-top">ログアウトしました</div>
					<canvas id="center-line"></canvas>
					<div id="item-bottom">see you</div>
				</div>
				<p id="return-top" class="fla-nav">画面クリックでTOPページへ戻ります</p>
			</div>
		</header>
	</body>
</html>
