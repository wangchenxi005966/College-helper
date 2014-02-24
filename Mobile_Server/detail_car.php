<?php
header ( "Content-Type: text/html;charset=utf-8" );
require 'SQL-DAO.php';

$callback = $_GET ['callback'];
$SQLDAO = new SQLDAO ();
$result = $SQLDAO->SQL_Query ( "select * from duanbo" );
$response = array (
		array (
				"time" => "",
				"way" => "" 
		) 
);
while ( ($row = mysql_fetch_array ( $result )) != null ) {
	$data = array (
			array (
					"time" => $row ["time"],
					"way" => $row ["way"] 
			) 
	);
	$response = array_merge ( $response, $data );
}
array_splice ( $response, 0, 1 );
echo $callback . "(" . json_encode ( $response ) . ")";