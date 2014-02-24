<?php
require 'SQL-DAO.php';

if(isset($_REQUEST["email"])&&isset($_REQUEST["oldpasswd"])&&isset($_REQUEST["newpasswd"]))
{
	$callback=$_GET["callback"];
	$SQLDAO=new SQLDAO();
	$email=$_REQUEST["email"];
	$oldpasswd=$_REQUEST["oldpasswd"];
	$newpasswd=$_REQUEST["newpasswd"];
	$QueryStr="select email,password from userinfo where email = '$email'";
	$temp=$SQLDAO->SQL_Query($QueryStr);
	
	if($temp)
	{
		$result=mysql_fetch_array($temp);
		if($result==null||$result=="")
		{
			$response=array("error"=>"true","message"=>"账号不存在！");
			echo $callback."(".json_encode($response).")";
		}
		else {
			if(strcmp($oldpasswd, $result["password"])!=0)
			{
				$response=array("error"=>"true","message"=>"旧密码输入错误！");
				echo $callback."(".json_encode($response).")";
			}
			else {
				$UpdateStr="update userinfo set password = '$newpasswd' where email = '$email'";
				$result=$SQLDAO->SQL_Update($UpdateStr);
				if($result)
				{
					$response=array("error"=>"false","message"=>"修改成功！");
					echo $callback."(".json_encode($response).")";
				}
				else {
					$response=array("error"=>"true","message"=>"密码修改失败！");
					echo $callback."(".json_encode($response).")";
				}
			}
		}
	}
	else {
		$response=array("error"=>"true","message"=>"数据库错误！");
		echo $callback."(".json_encode($response).")";
	}
	
	
	
}
else
{
	$callback=$_GET["callback"];
	$response=array("error"=>"true","message"=>"未接收到密码！");
	echo $callback."(".json_encode($response).")";
}