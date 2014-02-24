<?php
session_start();

if(!isset($_SESSION["name"])&&!isset($_SESSION["passwd"]))
{
	echo "<script>location='login.html';</script>";
}
else
{
	$name=$_SESSION["name"];
	$passwd=$_SESSION["passwd"];
	$shopname=$_REQUEST['shopname'];
	$SQLDAO=new SQLDAO();
	$QueryStr="select * from food_tag where owner='$name' and password='$passwd' and shop='$shopname'";
	$result=$SQLDAO->SQL_Query($QueryStr);
	$list=mysql_fetch_array($result);
	if($list=="")
	{
		echo "<script>location='login.html';</script>";
	}
}
