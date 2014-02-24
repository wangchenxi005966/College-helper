<?php
header ( "Content-Type: text/html;charset=utf-8" );
require 'SQL-DAO.php';

$SQLDAO = new SQLDAO ();
if (isset ( $_FILES ["file"] )) {
	if ($_FILES ["file"] ["error"] > 0) {
		$response = array (
				"error" => "true",
				"message" => $_FILES ["file"] ["error"] 
		);
		echo json_encode ( $response );
	} else {
		$id = $_REQUEST ["id"];
		$filename = $id . "_" . $_FILES ["file"] ["name"];
		move_uploaded_file ( $_FILES ["file"] ["tmp_name"], "image/" . $filename );
		$UpdateStr = "update userinfo set head_sculpture ='$filename' where id = '$id'";
		$result = $SQLDAO->SQL_Update ( $UpdateStr );
		if ($result) {
			$response = array (
					"error" => "false",
					"message" => "success" 
			);
			echo json_encode ( $response );
		} else {
			$response = array (
					"error" => "true",
					"message" => "数据库修改错误" 
			);
			echo json_encode ( $response );
		}
	}
} else {
	$callback = $_GET ["callback"];
	$username = $_REQUEST ["username"];
	if (! get_magic_quotes_gpc ()) {
		$username = addslashes ( $username );
	}
	$email = $_REQUEST ["email"];
	$sex = $_REQUEST ["sex"];
	$birthday = $_REQUEST ["birthday"];
	$school = $_REQUEST ["school"];
	$college = $_REQUEST ["college"];
	$major = $_REQUEST ["major"];
	$id = $_REQUEST ["id"];
	
	$UpdateStr = "update userinfo set username = '$username', sex = '$sex', birthday = '$birthday', school = '$school', college = '$college', " . "major = '$major' where id = '$id'";
	// echo $username . $school . $sex . $college . $major . $birthday;
	
	$result = $SQLDAO->SQL_Update ( $UpdateStr );
	if ($result) {
		$response = array (
				"error" => "false",
				"message" => "success" 
		);
		echo $callback . "(" . json_encode ( $response ) . ")";
	} else {
		$response = array (
				"error" => "true",
				"message" => $UpdateStr
		);
		echo $callback . "(" . json_encode ( $response ) . ")";
	}
}

?>