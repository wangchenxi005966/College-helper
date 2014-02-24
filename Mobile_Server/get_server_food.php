<?php
require 'SQL-DAO.php';
header ( "Content-Type:text/html;charset=utf-8" );

if (isset ( $_REQUEST ["shop"] ) && isset ( $_REQUEST ["callback"] )) {
	$shop = $_REQUEST ["shop"];
	$callback = $_REQUEST ["callback"];
	
	$post = get_food_info ( $shop );
	echo $callback . "(" . json_encode ( $post ) . ")";
}
function get_food_info($shop) {
	$SQLDAO = new SQLDAO ();
	$QueryStr = "select * from food_info where shopname='$shop'";
	$result = $SQLDAO->SQL_Query ( $QueryStr );
	if (! $result) {
		$reponse = array (
				"info" => "��ݿ����",
				"value" => "false" 
		);
		$reponse = json_encode ( $reponse );
		echo $reponse;
	} else {
		$i = 0;
		$list_arr = array ();
		while(($list=mysql_fetch_array($result))!=null)
		{
			$arr = array (
					"foodname" => $list ["foodname"],
					"price" => $list ["price"] 
			);
			$list_arr [$i] = $arr;
			$i ++;
		}
		return $list_arr;
	}
}