<?php
header("Content-Type:text/html;charset=utf-8");

if(isset($_REQUEST["href"])&&isset($_REQUEST["callback"]))
{
	$url=$_REQUEST["href"];
	$callback=$_REQUEST["callback"];
	$url=str_replace("..","http://sse.tongji.edu.cn",$url);
	//$url=str_replace("\"","",$url);
	//<div class="item">([\s\S]*)<div id="attachment" class="attachment">([\s\S]*?\</ul>[\s\D]*?\</div>|[\s\D]*?\</div>)[\s\D]*?\</div>
	$pattern = "/<div class=\"item\">([\s\S]*)<div id=\"attachment\" class=\"attachment\">([\s\S]*?\<\/ul>[\s\D]*?\<\/div>|[\s\D]*?\<\/div>)[\s\D]*?\<\/div>/";
	$list=getWebHtml($url,$pattern);
	$reponse=array("value"=>$list[1][0]);
	echo $callback."(".json_encode($reponse).")";
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