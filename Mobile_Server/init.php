<?php
/*
 * Created on Nov 19, 2013 To change the template for this generated file go to Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require 'SQL-DAO.php';

$callback = $_GET ['callback'];
$dao = new SQLDAO ();
$sql = "select userinfo.head_sculpture,homepage.id,homepage.content,homepage.image,homepage.username from homepage,userinfo where homepage.email=userinfo.email order by homepage.id desc limit 30";
$result = $dao->SQL_Query ( $sql );
$response = array (
		array (
				"id" => 0,
				"head_pic" => "",
				"username" => "",
				"content" => "",
				"image" => "" 
		) 
);
while ( ($row = mysql_fetch_array ( $result )) != null ) {
	$data = array (
			array (
					"id" => $row ['id'],
					"head_pic" => $row ['head_sculpture'],
					"username" => $row ['username'],
					"content" => $row ['content'],
					"image" => $row ['image'] 
			) 
	);
	$response = array_merge ( $response, $data );
}
array_splice ( $response, 0, 1 );
echo $callback . "(" . json_encode ( $response ) . ")";
