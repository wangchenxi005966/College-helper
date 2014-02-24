<?php
require 'SQL-DAO.php';
header ( "Content-Type: text/html;charset=utf-8" );

if (isset ( $_REQUEST ["email"] ) && isset ( $_REQUEST ["passwd"] )) {
	$email = $_REQUEST ["email"];
	$passwd = $_REQUEST ["passwd"];
	
	$SQLDAO = new SQLDAO ();
	$QueryStr = "select * from userinfo where email = '$email' and password = '$passwd'";
	$QueryResult = $SQLDAO->SQL_Query ( $QueryStr );
	
	if (! $QueryResult) {
		$reponse = array (
				"info" => "数据库错误",
				"value" => "false",
				"personinfo" => "" 
		);
		$reponse = json_encode ( $reponse );
		$callback = $_GET ['callback'];
		echo $callback . "($reponse)";
	} else {
		$Result = mysql_fetch_array ( $QueryResult );
		
		if ($Result == null) {
			$reponse = array (
					"info" => "邮箱或密码错误",
					"value" => "false",
					"personinfo" => "" 
			);
			$reponse = json_encode ( $reponse );
			$callback = $_GET ['callback'];
			echo $callback . "($reponse)";
		} 

		else {
			$result = array (
					"id" => $Result ["id"],
					"head_sculpture"=>$Result["head_sculpture"],
					"username" => $Result ["username"],
					"email"=>$Result["email"],
					"sex"=>$Result["sex"],
					"school"=>$Result["school"],
					"college"=>$Result["college"],
					"major"=>$Result["major"],
					"birthday"=>$Result["birthday"] 
			);
			if($result["head_sculpture"]==NULL)
			{
				$result["head_sculpture"]="";
			}
			
			//print_r($result);
			$reponse = array (
					"info" => "登陆成功",
					"value" => "true",
					"personinfo" => $result 
			);
			$reponse = json_encode ( $reponse );
			$callback = $_GET ['callback'];
			echo $callback . "($reponse)";
		}
	}
} 

else {
	$reponse = array (
			"info" => "用户不存在",
			"value" => "false",
			"personinfo" => "" 
	);
	$reponse = json_encode ( $reponse );
	$callback = $_GET ['callback'];
	echo $callback . "($reponse)";
}