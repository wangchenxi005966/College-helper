<?php
 require 'SQL-DAO.php';

 $callback = $_GET['callback'];
 $latest = $_GET['latest'];
 $flag = true;
 $dao = new SQLDAO;
 $temp = $dao->SQL_Query("select homepage.id from homepage,userinfo where homepage.email=userinfo.email order by homepage.id desc limit 1");
 while($row = mysql_fetch_array($temp))
 {
	 if($latest == $row['id'])   //更新到最新
	 {
		 $flag = false;
	 }
 }
 $sql = "select userinfo.head_sculpture,homepage.id,homepage.content,homepage.image,homepage.username from homepage,userinfo where homepage.email=userinfo.email order by homepage.id desc limit 30";
 $result = $dao->SQL_Query($sql);
 $response = array(array("latest"=>"","id"=>0,"head_pic"=>"","username"=>"","content"=>"","image"=>""));
 if($flag)
 {
 while($row = mysql_fetch_array($result))
 {
	 $data = array(array("latest"=>"false","id"=>$row['id'],"head_pic"=>$row['head_sculpture'],
		 "username"=>$row['username'],"content"=>$row['content'],"image"=>$row['image']));
	 $response = array_merge($response,$data);
 }
 array_splice($response,0,1);
 echo $callback."(".json_encode($response).")";
 }else{
	while($row = mysql_fetch_array($result))
 {
	 $data = array(array("latest"=>"true","id"=>$row['id'],"head_pic"=>$row['head_sculpture'],
		 "username"=>$row['username'],"content"=>$row['content'],"image"=>$row['image']));
	 $response = array_merge($response,$data);
 }
 array_splice($response,0,1);
 echo $callback."(".json_encode($response).")";
 }