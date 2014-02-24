<?php
require 'send_email.php';
require 'SQL-DAO.php';

if (isset ( $_REQUEST ["email"] )) {
	$SQLDAO = new SQLDAO ();
	$callback = $_REQUEST ["callback"];
	$email = $_REQUEST ["email"];
	$QueryStr = "select username , email , password from userinfo where email = '$email'";
	$result = $SQLDAO->SQL_Query ( $QueryStr );
	
	if (! $result) {
		$response = array (
				"error" => "true",
				"message" => "数据库错误!" 
		);
		echo $callback . "(" . json_encode ( $response ) . ")";
	} 
	else {
		$result = mysql_fetch_array ( $result );
		if ($result == null || $result == "") {
			$response = array (
					"error" => "true",
					"message" => "邮箱不存在!" 
			);
			echo $callback . "(" . json_encode ( $response ) . ")";
		} 
		else {
			$body = "亲爱的" . $result ["username"] . ":\n        你申请了找回密码，如若不是自己操作，请及时修改密码。\n        密码：" . $result ["password"];
			$send_result = send_email ( $body, $result ["username"], $email, "大学生活助手", "大学生活助手 - 遗忘密码" );
			$send_result = json_decode ( $send_result, true );
			if ($send_result ["success"]) {
				$response = array (
						"error" => "false",
						"message" => "密码已发送至账号邮箱，请及时查看!" 
				);
				echo $callback . "(" . json_encode ( $response ) . ")";
			} 
			else {
				$response = array (
						"error" => "true",
						"message" => $send_result ["errorInfo"] 
				);
				echo $callback . "(" . json_encode ( $response ) . ")";
			}
		}
	}
}
