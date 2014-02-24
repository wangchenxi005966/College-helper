<?php
header ( "Content-Type: text/html;charset=utf-8" );
require 'SQL-DAO.php';

$callback = $_GET ['callback'];
$SQLDAO = new SQLDAO ();
$result = $SQLDAO->SQL_Query ( "select * from subway" );
$response = array (
		array (
				"name" => "",
				"switch" => "" 
		) 
);
while ( ($row = mysql_fetch_array ( $result )) != null ) {
	$data = array (
			array (
					"name" => $row ["name"],
					"switch" => $row ["switch"] 
			) 
	);
	$response = array_merge ( $response, $data );
}
array_splice ( $response, 0, 1 );
echo $callback . "(" . json_encode ( $response ) . ")";