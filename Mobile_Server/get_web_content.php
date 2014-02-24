<?php
require 'SQL-DAO.php';

header ( "Content-Type:text/html;charset=utf-8" );

if (isset ( $_REQUEST ["href"] ) && isset ( $_REQUEST ["callback"] )) {
	$href = $_REQUEST ["href"];
	$callback = $_REQUEST ["callback"];
	$type = $_REQUEST ["type"];
	if ($href != - 1) {
		$post = get_data_from_database ( $href, $type );
	} else {
		$post = get_data_from_database_null ();
	}
	echo $callback . "(" . json_encode ( $post ) . ")";
}

function get_data_from_database_null() {
	$SQLDAO = new SQLDAO ();
	$search = "select * from notice where id<=20 order by id desc";
	$i = 0;
	$list_arr = array ();
	$result1 = $SQLDAO->SQL_Query ( $search );
	while ( ($list = mysql_fetch_array ( $result1 )) != null ) {
		$arr = array (
				"href" => $list ["href"],
				"title" => $list ["title"],
				"time" => $list ["time"],
				"content" => $list ["content"] 
		);
		$list_arr [$i] = $arr;
		$i ++;
	}
	$post = array (
			"latest" => 0,
			"deltag" => 1,
			"val" => $list_arr 
	);
	return $post;
}

function get_data_from_database($href, $type) {
	$SQLDAO = new SQLDAO ();
	$QueryStr = "select id from notice where href='$href'";
	$result = $SQLDAO->SQL_Query ( $QueryStr );
	if (! $result) {
		$reponse = array (
				"info" => "数据库错误",
				"value" => "false" 
		);
		$reponse = json_encode ( $reponse );
	} else {
		$result = mysql_fetch_array ( $result );
		if ($result == null) { 
			echo "error,cannot find this value";
		} else {
			if ($type == "forword") 			
			{
				$id = $result ["id"];
				if ($id == 1) {
					$post = array (
							"latest" => 1,
							"deltag" => 0,
							"val" => "" 
					);
				} else if ($id <= 20) { 
					$search = "select * from notice where id<'$id' order by id desc";
					$i = 0;
					$list_arr = array ();
					$result1 = $SQLDAO->SQL_Query ( $search );
					while ( ($list = mysql_fetch_array ( $result1 )) != null ) {
						$arr = array (
								"href" => $list ["href"],
								"title" => $list ["title"],
								"time" => $list ["time"],
								"content" => $list ["content"] 
						);
						$list_arr [$i] = $arr;
						$i ++;
					}
					$post = array (
							"latest" => 0,
							"deltag" => 0,
							"val" => $list_arr 
					);
				} else {
					$search = "select * from notice where id<=20 order by id desc";
					
					$i = 0;
					$list_arr = array ();
					$result1 = $SQLDAO->SQL_Query ( $search );
					while ( ($list = mysql_fetch_array ( $result1 )) != null ) {
						$arr = array (
								"href" => $list ["href"],
								"title" => $list ["title"],
								"time" => $list ["time"],
								"content" => $list ["content"] 
						);
						$list_arr [$i] = $arr;
						$i ++;
					}
					$post = array (
							"latest" => 0,
							"deltag" => 1,
							"val" => $list_arr 
					);
				}
			} else if ($type == "back") 			
			{
				$id = $result ["id"];
				$max = $id + 8;
				$search = "select * from notice where id>'$id' and id<='$max' order by id desc";
				$i = 0;
				$list_arr = array ();
				$result1 = $SQLDAO->SQL_Query ( $search );
				while ( ($list = mysql_fetch_array ( $result1 )) && $i != 8 ) {
					$arr = array (
							"href" => $list ["href"],
							"title" => $list ["title"],
							"time" => $list ["time"],
							"content" => $list ["content"] 
					);
					$list_arr [$i] = $arr;
					$i ++;
				}
				$post = array (
						"latest" => 0,
						"deltag" => 0,
						"val" => $list_arr 
				);
			}
			return $post;
		}
	}
}