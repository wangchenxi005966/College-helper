<?php
header ( "Content-Type: text/html;charset=utf-8" );
require 'SQL-DAO.php';

$callback = $_GET['callback'];
$SQLDAO = new SQLDAO();
$result = $SQLDAO->SQL_Query("select * from bus");
$response = array(array("name"=>""));
while($row = mysql_fetch_array($result))
 {
	 $data = array(array("name"=>$row['name']));
	 $response = array_merge($response,$data);
 }
 array_splice($response,0,1);
 echo $callback."(".json_encode($response).")";