<?php
require 'SQL-DAO.php';
header("Content-Type:text/html;charset=utf-8");

session_start();
$name=$_REQUEST['name'];
$passwd=$_REQUEST['passwd'];
if($name=="")
	echo "<script>alert('用户名不能为空!');location='login.html';</script>";
else if($passwd=="")
	echo "<script>alert('密码不能为空!');location='login.html';</script>";
else
{
	check($name,$passwd);
}

function check($name,$passwd)
{
	$SQLDAO=new SQLDAO();
	$QueryStr="select * from food_tag where owner='$name' and password='$passwd'";
	$result=$SQLDAO->SQL_Query($QueryStr);
	if(!$result)
	{
		$reponse=array("info"=>"数据库错误","value"=>"false");
		$reponse=json_encode($reponse);
		echo $reponse;
	}
	else
	{
		$list=mysql_fetch_array($result);
		if($list=="")
		{
			echo "<script>alert('用户名和密码不匹配');location='login.html';</script>";
		}
		else
		{
			$shopname=$list["shop"];
			echo "<script>location='index.php?action=show&shopname=$shopname';</script>";
			$_SESSION['name']=$name;
			$_SESSION['passwd']=$passwd;
		}
	}
}

