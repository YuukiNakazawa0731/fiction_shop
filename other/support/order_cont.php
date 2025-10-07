<?php
	require_once("../base_cont.php");

	//直接アクセス禁止
	if(!isset($_POST["to_order"])){
		header("Location:../products/all.php");
	}
	//二重送信防止トークン
	elseif(!isset($_SESSION["order_token"]) || ($_SESSION["order_token"] != "token_on")){
		header("Location:../products/all.php");
	}

	//セッション格納
	$cart = isset($_SESSION["cart"])? $_SESSION["cart"]:[];

	//日付情報取得
	$now_date = date('Y-m-d');

	//DB接続
	require_once("../shop_DB.php");
	$pdo = db_connect();

	//購入結果表示
	foreach($cart as $key => $item){
		$item_code = $key;
		$order_amount = $item["amount"];
		//sql(購入商品)
		$sql ="SELECT * FROM item WHERE code LIKE :item_code";
		$statement = $pdo -> prepare($sql);
		$statement -> bindValue(":item_code", $item_code);
		$statement -> execute();
		$cart_result = $statement -> fetch(PDO::FETCH_ASSOC);
		if($order_amount <= $cart_result["stock"]){
			try{
				$sql = "INSERT INTO order_result SET
				order_date = NOW(),
				user_id = :user_id,
				item_name = :item_name,
				price = :price,
				amount = :amount,
				state = :state,
				state_date = :state_date,
				img_name = :img_name";
				$statement = $pdo -> prepare($sql);
				$statement -> bindValue(":user_id", $user_id);
				$statement -> bindValue(":item_name", $cart_result["item_name"]);
				$statement -> bindValue(":price", $cart_result["price"]);
				$statement -> bindValue(":amount", $order_amount);
				$statement -> bindValue(":state", "未発送");
				$statement -> bindValue(":state_date", $now_date);
				$statement -> bindValue(":img_name", $cart_result["img_name"]);
				$statement -> execute();
			}
			catch(PDOException $e){
				print("DB接続エラー！:" . $e -> getMessage());
			}

			//在庫-注文数
			$new_stock = ($cart_result["stock"] - $order_amount);
			//sql(在庫数更新)
			try{
				$sql = "UPDATE item SET stock=:stock WHERE code=:code";
				$statement = $pdo -> prepare($sql);
				$statement -> bindParam(":code",$item_code);
				$statement -> bindParam(":stock",$new_stock);
				$statement -> execute();
			}
			catch(PDOException $e){
				print("DB接続エラー！:" . $e -> getMessage());
			}

			$state = "OK";
			$_SESSION["cart"]["$item_code"] = ["amount" => "$order_amount","action" => "未発送","state" => "$state"];
		}
		else{
			$state = "NG";
			$_SESSION["cart"]["$item_code"] = ["amount" => "$order_amount","action" => "未発送","state" => "$state"];
		}
	}

	header("Location:order_thank.php");
