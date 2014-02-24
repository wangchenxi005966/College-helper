<?php
require 'SQL-DAO.php';

if (isset ( $_REQUEST ["key"] ) && isset ( $_REQUEST ["account"] )) {
	$SQLDAO = new SQLDAO ();
	$key = $_REQUEST ["key"];
	$email = $_REQUEST ["account"];
	$callback = $_GET ["callback"];
	
	if (strcmp ( $key, "jh_download" ) == 0) {
		$QueryStr = "select * from jh_data where account = '$email' and `key` = 'event_of_week'";
		$result = $SQLDAO->SQL_Query ( $QueryStr );
		
		if (! $result) {
			$response = array (
					"error" => "true",
					"message" => "数据库查询错误!" 
			);
			echo $callback . "(" . json_encode ( $response ) . ")";
		} else {
			$temp = array ();
			$i = 0;
			while ( ($array_result = mysql_fetch_array ( $result )) != null ) {
				$value = json_decode ( $array_result ["value"] );
				$temp [$i] = $value;
				$i ++;
			}
			$response = array (
					"error" => "false",
					"value_0" => $temp,
					"value_1" => "" 
			);
			$QueryStr = "select * from jh_data where account = '$email' and `key` = 'event_of_beiwang'";
			
			$result = $SQLDAO->SQL_Query ( $QueryStr );
			if (! $result) {
				$response = array (
						"error" => "true",
						"message" => "数据库查询错误!" 
				);
				echo $callback . "(" . json_encode ( $response ) . ")";
			} else {
				$temp_1 = array ();
				$j = 0;
				while ( ($array_result = mysql_fetch_array ( $result )) != null ) {
					$value = json_decode ( $array_result ["value"] );
					$temp_1 [$j] = $value;
					$j ++;
				}
				$response ["value_1"] = $temp_1;
				//echo json_encode ( $response );
				echo $callback . "(" . json_encode ( $response ) . ")";
			}
		}
	} 

	else if (strcmp ( $key, "jh_upload" ) == 0) {
		$key_1 = $_REQUEST ["key_1"];
		$value = $_REQUEST ["value"];
		
		$DeleteStr = "delete from jh_data where account = '$email' and `key` = '$key_1'";
		$result = $SQLDAO->SQL_Delete ( $DeleteStr );
		if (! $result) {
			$response = array (
					"error" => "true",
					"message" => "数据库查询错误!" 
			);
			echo $callback . "(" . json_encode ( $response ) . ")";
		} else {
			$error = false;
			$value = json_decode ( $value );
			// print_r ($value);
			foreach ( $value as $arr ) {
				// echo $arr;
				if (! get_magic_quotes_gpc ()) {
					$arr = addslashes ( $arr );
				}
				//echo $arr;
				$InsertStr = "insert into jh_data (`key`,account,`value`) values ('$key_1','$email','$arr')";
				//echo 
				$result = $SQLDAO->SQL_Insert ( $InsertStr );
				if (! $result) {
					$error = true;
					break;
				}
			}
			if ($error) {
				$response = array (
						"error" => "true",
						"message" => "数据库插入错误!" 
				);
				echo $callback . "(" . json_encode ( $response ) . ")";
			} else {
				$response = array (
						"error" => "false",
						"message" => "同步成功!" 
				);
				echo $callback . "(" . json_encode ( $response ) . ")";
			}
		}
	}
}

	
