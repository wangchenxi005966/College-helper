<?php
require 'SQL-DAO.php';
header ( "Content-Type:text/html;charset=utf-8" );

/* 客户端发送数据位本地每个菜单的版本号，服务端获取之后判断回馈 */

if (isset ( $_REQUEST ["food"] ) && isset ( $_REQUEST ["callback"] )) {
	$food = $_REQUEST ["food"]; // string套string
	$callback = $_REQUEST ["callback"];
	if ($food == "update") {
		$post = getall ();
	} else {
		$food_json = json_decode ( $food, true );
		$post = array ();
		for($i = 0; $i < count ( $food_json ); $i ++) {
			$food_each_str = $food_json [$i];
			$food_each = json_decode ( $food_each_str, true );
			$returnval = check ( $food_each );
			if ($returnval != false) {
				array_push ( $post, $returnval );
			}
		}
		$other = getother ( $food_json );
		if ($other != false) {
			for($j = 0; $j < count ( $other ); $j ++) {
				array_push ( $post, $other [$j] );
			}
		}
	}
	echo $callback . "(" . json_encode ( $post ) . ")";
}
function getother($food_json) {
	$SQLDAO = new SQLDAO ();
	$index = count ( $food_json ) - 1;
	$shop_json = $food_json [$index];
	$food_each = json_decode ( $shop_json, true );
	$shop = $food_each ["shop"];
	$search = "select * from food_tag where shop='$shop'";
	$result1 = $SQLDAO->SQL_Query ( $search );
	$list1 = mysql_fetch_array ( $result1 );
	$id = $list1 ["Id"];
	
	$search2 = "select * from food_tag where id>'$id' and version!=-1";
	$result2 = $SQLDAO->SQL_Query ( $search2 );
	if (! $result2) {
		return false;
	} else {
		$i = 0;
		$list_arr = array ();
		while ( ($list = mysql_fetch_array ( $result2 )) != null ) {
			$shop_name = $list ["shop"];
			$search3 = "select * from food_info where shopname='$shop_name'";
			$result3 = $SQLDAO->SQL_Query ( $search3 );
			$j = 0;
			$list_arr2 = array ();
			while ( ($list2 = mysql_fetch_array ( $result3 )) != null ) {
				$arr2 = array (
						"foodname" => $list2 ["foodname"],
						"price" => $list2 ["price"] 
				);
				$list_arr2 [$j] = $arr2;
				$j ++;
			}
			$arr = array (
					"shop" => $list ["shop"],
					"version" => $list ["version"],
					"phone" => $list ["phone"],
					"value" => $list_arr2 
			);
			$list_arr [$i] = $arr;
			$i ++;
		}
	}
	return $list_arr;
}
function check($food) {
	$SQLDAO = new SQLDAO ();
	$version = $food ["version"];
	$shop = $food ["shop"];
	$search = "select * from food_tag where shop='$shop'";
	$result1 = $SQLDAO->SQL_Query ( $search );
	$list2 = mysql_fetch_array ( $result1 );
	if ($list2 ["version"] == - 1) { /* 删除数据 */
		$post = array (
				"shop" => $shop,
				"version" => $list2 ["version"],
				"phone" => $list2 ["phone"] 
		);
		return $post;
	} else {
		$list_arr = array ();
		$i = 0;
		if ($list2 ["version"] != $version) {
			$search2 = "select * from food_info where shopname='$shop'";
			$result2 = $SQLDAO->SQL_Query ( $search2 );
			while ( ($list = mysql_fetch_array ( $result2 )) != null ) {
				$arr = array (
						"foodname" => $list ["foodname"],
						"price" => $list ["price"] 
				);
				$list_arr [$i] = $arr;
				$i ++;
			}
			$post = array (
					"shop" => $shop,
					"version" => $list2 ["version"],
					"phone" => $list2 ["phone"],
					"val" => $list_arr 
			);
			return $post;
		} else {
			return false;
		}
	}
}
function getall() {
	$SQLDAO = new SQLDAO ();
	$search = "select * from food_tag where version!=-1";
	$list_arr = array ();
	$i = 0;
	$result1 = $SQLDAO->SQL_Query ( $search );
	while ( ($list = mysql_fetch_array ( $result1 )) != null ) {
		/* 获取菜单信息 */
		$shop_name = $list ["shop"];
		$search2 = "select * from food_info where shopname='$shop_name'";
		$result2 = $SQLDAO->SQL_Query ( $search2 );
		$j = 0;
		$list_arr2 = array ();
		while ( ($list2 = mysql_fetch_array ( $result2 )) != null ) {
			$arr2 = array (
					"foodname" => $list2 ["foodname"],
					"price" => $list2 ["price"] 
			);
			$list_arr2 [$j] = $arr2;
			$j ++;
		}
		$arr = array (
				"shop" => $list ["shop"],
				"version" => $list ["version"],
				"phone" => $list ["phone"],
				"value" => $list_arr2 
		);
		$list_arr [$i] = $arr;
		$i ++;
	}
	return $list_arr;
}
