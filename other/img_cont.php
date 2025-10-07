<?php
	//画像表示
	$base_size = '10';
	function img_tag(){
		if(file_exists("../../item_img/$img_name"))
			$image = "../../item_img/$img_name";
		//ファイル内になければ「ノーイメージ」を表示
		else{
			$image = "../../item_img/noimage.png";
		}
		//サイズ自動調整
		//メインHTMLから$base_sizeを取得
		$imageinfo = getimagesize($image);
		$width = $imageinfo[0];
		$height = $imageinfo[1];
		// 縦と横の大きいほうを取得
		$max = ($width > $height ? $width : $height);
		// 比率を保持して縮小
		$ratio = $max / $base_size;
		$new_width = round($width / $ratio);
		$new_height = round($height / $ratio);

		// HTMLタグを出力
		return '<img src="
			'.$image.'"
			width="'.$new_width.'"
			height="'.$new_height.'"
			class="edit-img"
			alt="edit_img">';
	}
