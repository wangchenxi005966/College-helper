//同步网址
var course_id="http://college-helper-server.wicp.net/get_web_course.php";
/*
通过id数据查找出对应的课程信息
*/
function search(time,week,json)
{
	for(var i=0;i<json.length;i++)
	{
		if(time==stringtojson(json[i]).time&&(week==stringtojson(json[i]).week||stringtojson(json[i]).week=="1-17周"))
		{
			return json[i];
		}
	}
	return -1;
}
/*
根据时间周数找到该条课程数据信息，返回string格式
*/
function get_course()
{
	var time=sessionget("course_time");
	var week=sessionget("weektype");
	var course_list=stringtojson(ssenvoyget("course"));
	var cur_course=search(time,week,course_list);//string格式
	return cur_course;
}
/*
找到该条数据在第几条
*/
function get_num(time,week,json)
{
	for(var i=0;i<json.length;i++)
	{
		if(time==stringtojson(json[i]).time&&week==stringtojson(json[i]).week)
			return i;
	}
	return -1;
}
/*
判断是否已存在，存在返回false，即表示不可插入该课程信息
*/
function search_course(time,week,json)
{
	for(var i=0;i<json.length;i++)
	{
		if(time==stringtojson(json[i]).time)
		{
			if(stringtojson(json[i]).week=="1-17周")
				return false;
			else
			{
				if(week=="1-17周"||(week!="1-17周"&&week==stringtojson(json[i]).week))
					return false;
			}
		}
	}
	return true;
}
/*
将周一第一节转化为1-1
*/
function convert(id)
{
	var str=id.split(" ");
	var day1,day2;
	switch(str[0])
	{
		case "周一":
			day1="1";
			break;
		case "周二":
			day1="2";
			break;
		case "周三":
			day1="3";
			break;
		case "周四":
			day1="4";break;
		case "周五":
			day1="5";break;
		case "周六":
			day1="6";break;
		case "周日":
			day1="7";break;
	}
	switch(str[1])
	{
		case "第1节":
			day2="1";break;
		case "第2节":
			day2="2";break;
		case "第3节":
			day2="3";break;
		case "第4节":
			day2="4";break;
		case "第5节":
			day2="5";break;
	}
	return day1+"-"+day2;
}

/*
将周数转化为单双周
*/
function convertweek(num)
{
	var week;
	if(num%2==0)
		week="双周";
	else
		week="单周";
	sessionset("weektype",week);
	return week;
}
/*
检查是否联网
*/
function checkInternet() {
	var networkState = navigator.network.connection.type;
	if (networkState == Connection.NONE) {
		//return false;
		return true;
	}else{
		return true;
	}
}

function showLoadings() {
	$.mobile.loadingMessageTextVisible = true;
	$.mobile.showPageLoadingMsg("a", "加载中...");
}

function hideLoadings() {
	$.mobile.hidePageLoadingMsg();
}