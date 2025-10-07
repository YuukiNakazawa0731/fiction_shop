<!DOCTYPE html>
<html lang="ja">
	<body>
		<footer>
			<div id="footer-head">
				<a href="<?php print($p_shop); ?>" id="footer-logo">
					<img src="<?php print($p_img); ?>images/logo_title.png" id="footer-logo-img" alt="logo">
				</a>
			</div>
			<ol id="footer-menu-list">
				<li class="footer-menu-item">
					<a href="<?php print($p_all); ?>" class="footer-menu-child">商品一覧</a>
				</li>
				<li class="footer-menu-item">
					<a href="<?php print($p_mycart); ?>" class="footer-menu-child">ショッピングカート</a>
				</li>
				<li class="footer-menu-item">
					<a href="<?php print($p_labels); ?>" class="footer-menu-child">特定商取引法に基づく表記</a>
				</li>
				<li class="footer-menu-item">
					<a href="<?php print($p_privacy); ?>" class="footer-menu-child">プライバシーポリシー</a>
				</li>
			</ol>
			<p id="copy-right">Copyright © fiction CO., LTD. All Rights Reserved 2022</p>
		</footer>
	</body>
</html>
