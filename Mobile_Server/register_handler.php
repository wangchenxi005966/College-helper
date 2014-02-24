<?php
require 'SQL-DAO.php';
header("Content-Type: text/html;charset=utf-8");
if(isset($_REQUEST["email"])&&isset($_REQUEST["passwd"])&&isset($_REQUEST["username"]))
{
	$username=$_REQUEST["username"];
	$email=$_REQUEST["email"];
	$passwd=$_REQUEST["passwd"];
	
	$SQLDAO=new SQLDAO();
	
	$QueryStr="select * from userinfo where email = '$email'";
	$result=$SQLDAO->SQL_Query($QueryStr);
	
	if(!$result)
	{
		$reponse=array("info"=>"数据库错误","value"=>"false");
		$reponse=json_encode($reponse);
		$callback=$_GET['callback'];
		echo $callback."($reponse)";
		
	}
	else {
		$result=mysql_fetch_array($result);
		if($result!=null)
		{
			$reponse=array("info"=>"该邮箱已被注册！","value"=>"false");
			$reponse=json_encode($reponse);
			$callback=$_GET['callback'];
			echo $callback."($reponse)";
		}
		else {
			//echo $username;
			if(!get_magic_quotes_gpc()){
				$username=addslashes($username);
				
			}
			$InsertStr="insert into userinfo (username , email , password ) value ('$username' , '$email' , '$passwd')";
			$result=$SQLDAO->SQL_Insert($InsertStr);
			if($result)
			{
				$reponse=array("info"=>"注册成功！","value"=>"true");
				$reponse=json_encode($reponse);
				$callback=$_GET['callback'];
				echo $callback."($reponse)";
			}
			else {
				$reponse=array("info"=>"注册失败(用户民可能包含特殊字符)！","value"=>"false");
				$reponse=json_encode($reponse);
				$callback=$_GET['callback'];
				echo $callback."($reponse)";
			}
		}
	}
}
else {
	$reponse=array("info"=>"数据错误！","value"=>"false");
	$reponse=json_encode($reponse);
	$callback=$_GET['callback'];
	echo $callback."($reponse)";
}

