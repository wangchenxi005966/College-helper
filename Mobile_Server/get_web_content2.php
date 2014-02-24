<?php
require 'SQL-DAO.php';

header("Content-Type:text/html;charset=utf-8");
update();

function update()
{
	$SQLDAO=new SQLDAO();
	$QueryStr="select href from notice where id=1";
	$result=$SQLDAO->SQL_Query($QueryStr);
	if(!$result)
	{
		$reponse=array("info"=>"数据库错误","value"=>"false");
		$reponse=json_encode($reponse);
		echo $reponse;
	}
	else
	{
		$result=mysql_fetch_array($result);
		$url="http://sse.tongji.edu.cn/InfoCenter/Lastest_Notice.aspx";
		$pattern = "/<a id=\"GridView1_HyperLink1_[0-9]{1,2}\" href=\"(.*)\">(.*?)<\/a>[\s\D]*<span id=\"GridView1_PublishTime_[0-9]{1,2}\" class=\"news_date\">(.*)<\/span>/";
		$list=getWebHtml($url,$pattern);
		$length=count($list[1]);
		if($result==null)
		{//数据库为空		
			for($i=0;$i<$length;$i++)
			{
				$val1=$list[2][$i];
				//echo $val1;
				$val2=$list[1][$i];
				$val3=$list[3][$i];
				$val4=getShortNote($val2);
				$id=$i+1;
				$InsertStr="insert into notice(id,title,href,time,content) value ('$id','$val1','$val2','$val3','$val4')";
				$result=$SQLDAO->SQL_Insert($InsertStr);
			}
		}
		else
		{
			$lastnews=$result["href"];
			for($i=0;$i<$length;$i++)
			{
				$val1=$list[2][$i];
				$val2=$list[1][$i];
				$val3=$list[3][$i];
				$val4=getShortNote($val2);
				echo $val4;
				$id=$i+1;
				if($lastnews==$val2)
				{
					echo "已到最新";
					return ;
				}
				else
				{
					$update="update notice set id = id+1  where id >$i";
					$result1=$SQLDAO->SQL_Update($update);
					$InsertStr="insert into notice(id,title,href,time,content) value ('$id','$val1','$val2','$val3','$val4')";
					$result=$SQLDAO->SQL_Insert($InsertStr);
				}
			}
		}
	}
}


function getWebHtml($strUrl,$matchList)
{
	if(!$strUrl)return false;
	$strHtml=file_get_contents($strUrl);
	$list=array();
	$match_temp=array();
	+ preg_match_all($matchList, $strHtml, $match_temp);
	if($match_temp)
	{
		$list=$match_temp;
	}
	return  $list;
}

function getShortNote($urls)
{
	$url=str_replace("..","http://sse.tongji.edu.cn",$urls);
	$pattern = "/<div id=\"content\" class=\"content\">[\s\S]*?\<div id=\"attachment\" class=\"attachment\">/";
	$list=getWebHtml($url,$pattern);
	$reponse=$list[0][0];	
	$reponse=preg_replace("/<(.*?)>/","",$reponse);
	$reponse=preg_replace("/<[\/\!]*?[^<>]*?>/","",$reponse);	
	$reponse=preg_replace("/&nbsp;|&ldquo;|&rdquo;/","",$reponse);
	$reponse=preg_replace("/\s+/", " ", $reponse);/*过滤回车*/
	if(strlen($reponse)>200)
		$content=msubstr($reponse,0,200);
	else
		$content=$reponse;
	return $content."……";
}

function msubstr($str, $start, $len) {
	$tmpstr = "";
	$strlen = $start + $len;
	$last=$strlen-50;
	for($i = 0; $i < $strlen; $i++) {
		if(ord(substr($str, $i, 1)) > 0xa0) {
			$tmpstr.= substr($str, $i,3);
			$i+=2;
			if($i>$last)
			{
				echo $tmpstr;
				return $tmpstr;
			}
		}
		else{
			$tmpstr.= substr($str, $i, 1);
			if($i>$last)
			{
				echo $tmpstr;
				return $tmpstr;
			}
		}
	}
	return $tmpstr;
}

