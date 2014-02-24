<?php
date_default_timezone_set ( 'Asia/Shanghai' );
require_once 'PHPMail/class.phpmailer.php';
function send_email($body, $name, $address, $formname, $title) {
	$mail = new PHPMailer (); // 建立邮件发送类
	                          // $address = "wayneislwm@gmail.com";
	$mail->IsSMTP (); // 使用SMTP方式发送
	$mail->Host = "smtp.163.com"; // 您的企业邮局域名
	$mail->SMTPAuth = true; // 启用SMTP验证功能
	$mail->Username = "college_helper@163.com"; // 邮局用户名(请填写完整的email地址)
	$mail->Password = "collegehelper"; // 邮局密码
	$mail->Port = 25;
	$mail->From = "college_helper@163.com"; // 邮件发送者email地址
	$mail->CharSet = "utf-8";                                 
	$mail->FromName = "=?utf-8?B?" . base64_encode ( $formname ) . "?=";
	$name = "=?utf-8?B?" . base64_encode ( $name ) . "?=";
	$mail->AddAddress ( "$address", "$name" ); // 收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
	
	$mail->Subject = "=?utf-8?B?" . base64_encode ( $title ) . "?=";
	
	//$body = "=?utf-8?B?" . base64_encode ( $body ) . "?=";
	$mail->Body = $body; // 邮件内容

	if (! $mail->Send ()) {
		$result = array (
				"success" => false,
				"errorInfo" => $mail->ErrorInfo 
		);
		return json_encode ( $result );
	} else {
		$result = array (
				"success" => true,
				"errorInfo" => "" 
		);
		return json_encode ( $result );
	}
}
?>