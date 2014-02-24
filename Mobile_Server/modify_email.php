<?php
require 'SQL-DAO.php';

if (isset ( $_REQUEST ["old_email"] ) && isset ( $_REQUEST ["passwd"] ) && isset ( $_REQUEST ["new_email"] )) {
	$callback = $_GET ["callback"];
	$SQLDAO = new SQLDAO ();
	$old_email = $_REQUEST ["old_email"];
	$passwd = $_REQUEST ["passwd"];
	$new_email = $_REQUEST ["new_email"];
	$QueryStr = "select email,password from userinfo where email = '$old_email'";
	$temp = $SQLDAO->SQL_Query ( $QueryStr );
	
	if ($temp) {
		$result = mysql_fetch_array ( $temp );
		if ($result == null || $result == "") {
			$response = array (
					"error" => "true",
					"message" => "账号不存在！" 
			);
			echo $callback . "(" . json_encode ( $response ) . ")";
		} else {
			if (strcmp ( $passwd, $result ["password"] ) != 0) {
				$response = array (
						"error" => "true",
						"message" => "密码输入错误！" 
				);
				echo $callback . "(" . json_encode ( $response ) . ")";
			} else {
				$UpdateStr1 = "update userinfo set email = '$new_email' where email = '$old_email'";
				$UpdateStr2 = "update homepage set email = '$new_email' where email = '$old_email'";
				$result1 = $SQLDAO->SQL_Update ( $UpdateStr1 );
				$result2 = $SQLDAO->SQL_Update ( $UpdateStr2 );
				if ($result1 && $result2) {
					$response = array (
							"error" => "false",
							"message" => "修改成功！" 
					);
					echo $callback . "(" . json_encode ( $response ) . ")";
				} else {
					$response = array (
							"error" => "true",
							"message" => "账号修改失败！" 
					);
					echo $callback . "(" . json_encode ( $response ) . ")";
				}
			}
		}
	} else {
		$response = array (
				"error" => "true",
				"message" => "数据库错误！" 
		);
		echo $callback . "(" . json_encode ( $response ) . ")";
	}
} else {
	$callback = $_GET ["callback"];
	$response = array (
			"error" => "true",
			"message" => "未接收到邮箱！" 
	);
	echo $callback . "(" . json_encode ( $response ) . ")";
}