<?php
header ( "Content-Type: text/html;charset=utf-8" );
require 'SQL-DAO.php';

$callback = $_GET ['callback'];
$SQLDAO = new SQLDAO ();
$result = $SQLDAO->SQL_Query ( "select * from stop" );
$response = array (
		array (
				"name" => "",
				"site" => "" 
		) 
);
while ( ($row = mysql_fetch_array ( $result )) != null ) {
	$data = array (
			array (
					"name" => $row ["name"],
					"site" => $row ["site"] 
			) 
	);
	$response = array_merge ( $response, $data );
}
array_splice ( $response, 0, 1 );
echo $callback . "(" . json_encode ( $response ) . ")";