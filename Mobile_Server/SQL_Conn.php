<?php
header("Content-Type: text/html;charset=utf-8");
class ConnDB{
	private $SQL_URL="localhost";
	private $SQL_USERNAME="root";//用户名
	private $SQL_PASSWORD="wang005966";//密码
	private $conn;
	
	function Conn_DB()
	{
		$this->conn=mysql_connect($this->SQL_URL,$this->SQL_USERNAME,$this->SQL_PASSWORD);
		if(!$this->conn)
		{
			echo "Could not connect: " . mysql_error ();
			return null;
		}
		
		if(! mysql_select_db ( "college-helper" ))
		{
			echo "Could not connect data-base:".mysql_errno();
			return null;
		}
		
		return $this->conn;
	}
}