<?php
header("Content-Type: text/html;charset=utf-8");
require 'SQL_Conn.php';

class SQLDAO
{
	private $ConnDB;
	private $conn;
	
	function SQLDAO()
	{
		$this->ConnDB=new ConnDB();
	}
	
	
	function SQL_Query($QueryStr)
	{
		$this->conn=$this->ConnDB->Conn_DB();
		if($this->conn!=null)
		{
			$result=mysql_query($QueryStr);
			mysql_close($this->conn);
			return $result;
		}
		else
		{
			return null;
		}
	}
	
	function SQL_Update($UpdateStr)
	{
		$this->conn=$this->ConnDB->Conn_DB();
		if($this->conn!=null)
		{
			$result=mysql_query($UpdateStr);
			mysql_close($this->conn);
			if($result)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else {
			return false;
		}
	}
	
	function SQL_Delete($DeleteStr)
	{
		$this->conn=$this->ConnDB->Conn_DB();
		if($this->conn!=null)
		{
			$result=mysql_query($DeleteStr);
			mysql_close($this->conn);
			if($result)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else {
			return false;
		}
	}
	
	function SQL_Insert($InsertStr)
	{
		$this->conn=$this->ConnDB->Conn_DB();
		if($this->conn!=null)
		{
			$result=mysql_query($InsertStr);
			mysql_close($this->conn);
			if($result)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else {
			return false;
		}
	}
	
}