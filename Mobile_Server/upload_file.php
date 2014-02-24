<?php
header ( "Content-Type: text/html;charset=utf-8" );
require 'SQL-DAO.php';

$SQLDAO = new SQLDAO();
if (isset ($_FILES["file"])) {
	if ($_FILES["file"]["error"] > 0) {
		$response = array (
			"error" => "true",
			"message" => $_FILES["file"]["error"]
		);
		echo json_encode($response);
	}
	elseif (($_FILES["file"]["size"] > 2000000)) {
		$response = array (
			"error" => "true",
			"message" => "file too big"
		);
		echo json_encode($response);
	} else {
		$username = $_REQUEST["username"];
		$content = $_REQUEST["content"];
		$email = $_REQUEST["email"];
		$filename = $_FILES["file"]["name"];
		move_uploaded_file($_FILES["file"]["tmp_name"], "image/" . $filename);
		$sqlStr = "insert into homepage(username,content,image,email) values(\"$username\",\"$content\",\"$filename\",\"$email\")";
		$result = $SQLDAO->SQL_Insert($sqlStr);
		if ($result) {
			$response = array (array(
				"error" => "false",
				"message" => "success"
			));
			echo json_encode($response);
		} else {
			$response = array (
				"error" => "true",
				"message" => "Êý¾Ý¿âÐÞ¸Ä´íÎó"
			);
			echo json_encode($response);
		}
	}
} else {
	$callback = $_GET['callback'];
	$temp_user = $_GET['username'];
	$temp_co = $_GET['inputContent'];
	$temp_email = $_GET['email'];
	$username = urldecode($temp_user);
	$content = urldecode($temp_co);
	$email = urldecode($temp_email);
	$dao = new SQLDAO;
	$sql = "insert into homepage(username,content,email) values(\"$username\",\"$content\",\"$email\")";
	$result = $dao->SQL_Insert($sql);
	if ($result) {
		$response = array (
			"value" => "ok"
		);
		echo $callback . "(" . json_encode($response) . ")";
	} else {
		$response = array (
			"value" => "fail"
		);
		echo $callback . "(" . json_encode($response) . ")";
	}
}
?>
