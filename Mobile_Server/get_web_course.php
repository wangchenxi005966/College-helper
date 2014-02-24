<?php
require 'SQL-DAO.php';

header ( "Content-Type:text/html;charset=utf-8" );

if (isset ( $_REQUEST ["course"] ) && isset ( $_REQUEST ["user"] ) && isset ( $_REQUEST ["ope"] )) {
	$course = $_REQUEST ["course"];
	$user = $_REQUEST ["user"];
	$operate = $_REQUEST ["ope"];
	$callback = $_REQUEST ["callback"];
	if ($operate == "uplode") { 
		$post = insert ( $course, $user );
	} else if ($operate == "update") {
		$post = update ( $course, $user );
	} else if ($operate == "del") {
		$post = deleteVal ( $course, $user );
	} else if ($operate == "get") {
		$post = getVal ( $user );
	}
	echo $callback . "(" . json_encode ( $post ) . ")";
}
function insert($course, $user) {
	$SQLDAO = new SQLDAO ();
	$json = json_decode ( $course, true );
	$time = $json ["time"];
	$week = $json ["week"];
	$name = $json ["name"];
	$classroom = $json ["classroom"];
	$teacher_name = $json ["teacher_name"];
	$teacher_tel = $json ["teacher_tel"];
	$teacher_mail = $json ["teacher_mail"];
	$zhujiao_name = $json ["zhujiao_name"];
	$zhujiao_tel = $json ["zhujiao_tel"];
	$zhujiao_mail = $json ["zhujiao_mail"];
	$beizhu = $json ["beizhu"];
	$InsertStr = "insert into course(user,time,week,name,classroom,teacher_name,teacher_tel,teacher_mail,zhujiao_name,zhujiao_tel,zhujiao_mail,beizhu) value ('$user','$time','$week','$name','$classroom','$teacher_name','$teacher_tel','$teacher_mail','$zhujiao_name','$zhujiao_tel','$zhujiao_mail','$beizhu')";
	$result = $SQLDAO->SQL_Insert ( $InsertStr );
	if ($result) {
		$reponse = array (
				"value" => 1 
		);
	} else {
		$reponse = array (
				"value" => 0 
		);
	}
	return $reponse;
}
function update($course, $user) {
	$SQLDAO = new SQLDAO ();
	$json = json_decode ( $course, true );
	$time = $json ["time"];
	$week = $json ["week"];
	$name = $json ["name"];
	$classroom = $json ["classroom"];
	$teacher_name = $json ["teacher_name"];
	$teacher_tel = $json ["teacher_tel"];
	$teacher_mail = $json ["teacher_mail"];
	$zhujiao_name = $json ["zhujiao_name"];
	$zhujiao_tel = $json ["zhujiao_tel"];
	$zhujiao_mail = $json ["zhujiao_mail"];
	$beizhu = $json ["beizhu"];
	$old_time = $json ["old_time"];
	$old_week = $json ["old_week"];
	$updateStr = "update course set time= '$time',week='$week',name='$name',classroom='$classroom',teacher_name='$teacher_name',teacher_tel='$teacher_tel',teacher_mail='$teacher_mail',zhujiao_name='$zhujiao_name',zhujiao_tel='$zhujiao_tel',zhujiao_mail='$zhujiao_mail',beizhu='$beizhu' where time='$old_time' and week='$old_week' and user='$user'";
	$result = $SQLDAO->SQL_Update ( $updateStr );
	if ($result) {
		$reponse = array (
				"value" => 1 
		);
	} else {
		$reponse = array (
				"value" => 0 
		);
	}
	return $reponse;
}
function deleteVal($course, $user) {
	$SQLDAO = new SQLDAO ();
	$json = json_decode ( $course, true );
	$old_time = $json ["time"];
	$old_week = $json ["week"];
	$deleteStr = "delete from course where time='$old_time' and week='$old_week' and user='$user'";
	$result = $SQLDAO->SQL_Delete ( $deleteStr );
	if ($result) {
		$reponse = array (
				"value" => 1 
		);
	} else {
		$reponse = array (
				"value" => 0 
		);
	}
	return $reponse;
}
function getVal($user) {
	$SQLDAO = new SQLDAO ();
	$search = "select * from course where user='$user' ";
	$i = 0;
	$list_arr = array ();
	$result1 = $SQLDAO->SQL_Query ( $search );
	while(($list=mysql_fetch_array($result1))!=null)
	{
		$arr = array (
				"time" => $list ["time"],
				"week" => $list ["week"],
				"name" => $list ["name"],
				"classroom" => $list ["classroom"],
				"teacher_name" => $list ["teacher_name"],
				"teacher_tel" => $list ["teacher_tel"],
				"teacher_mail" => $list ["teacher_mail"],
				"zhujiao_name" => $list ["zhujiao_name"],
				"zhujiao_tel" => $list ["zhujiao_tel"],
				"zhujiao_mail" => $list ["zhujiao_mail"],
				"beizhu" => $list ["beizhu"] 
		);
		$list_arr [$i] = $arr;
		$i ++;
	}
	return $list_arr;
}