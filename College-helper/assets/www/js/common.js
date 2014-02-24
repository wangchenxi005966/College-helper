function stringtojson(str)
{ 
     var json = eval('(' + str + ')'); 
     return json;
};
function jsontostring(obj)
{   
	var THIS = this;    
	switch(typeof(obj)){   
		case 'string':   
			return '"' + obj.replace(/(["\\])/g, '\\$1') + '"';   
		case 'array':   
			return '[' + obj.map(THIS.jsontostring).join(',') + ']';   
		case 'object':   
			 if(obj instanceof Array){   
				var strArr = [];   
				var len = obj.length;   
				for(var i=0; i<len; i++){   
					strArr.push(THIS.jsontostring(obj[i]));   
				}   
				return '[' + strArr.join(',') + ']';   
			}else if(obj==null){   
				return 'null';   

			}else{   
				var string = [];   
				for (var property in obj) string.push(THIS.jsontostring(property) + ':' + THIS.jsontostring(obj[property]));   
				return '{' + string.join(',') + '}';   
			}   
		case 'number':   
			return obj;   
		case false:   
			return obj;   
	}  
};

function ssenvoyget(fieldname)
{
	return localStorage.getItem(fieldname);
};

function ssenvoyset(fieldname,val)
{
	localStorage.setItem(fieldname,val);
};

function ssenvoyremove(fieldname)
{
	localStorage.removeItem(fieldname);
};

function sessionset(fieldname,val)
{
	sessionStorage.setItem(fieldname,val);
};

function sessionget(fieldname){
	return sessionStorage.getItem(fieldname);
};

function modifyDate(data)
{
	var food_tag_json=stringtojson(ssenvoyget("food_tag"));
	var food_info_json=stringtojson(ssenvoyget("food_info"));
	$.each(data, function(infoIndex,info) {
		var num=get_index_food(info["shop"],food_tag_json);
		if(num!=-1){//已存在
			var food_info_json_each=stringtojson(food_info_json[num]);
			var food_json=stringtojson(food_tag_json[num]);
			if(info["version"]==-1)
			{
				food_tag_json.splice(num,1);
				food_info_json.splice(num,1);
			}
			else
			{				
				food_json["version"]=info["version"];
				food_json["phone"]=info["phone"];
				var food_str=jsontostring(food_json);
				food_tag_json.splice(num,1,food_str);

				food_info_json_each["value"]=info["value"];
				var food_info_str=jsontostring(food_info_json_each);
				food_info_json.splice(num,1,food_info_str);
			}
		}
		else{//新数据
			food_tag_json.push(jsontostring({"shop":info["shop"],"version":info["version"],"phone":info["phone"]}));
			food_info_json.push(jsontostring({"shop":info["shop"],"value":info["value"]}));
		}
	});
	ssenvoyset("food_tag",jsontostring(food_tag_json));
	ssenvoyset("food_info",jsontostring(food_info_json));
}
function handleDate(data)
{
	var food_tag_array=new Array();
	var food_info_array=new Array();
	$.each(data, function(infoIndex, info) {
		food_tag_array.push(jsontostring({"shop":info["shop"],"version":info["version"],"phone":info["phone"]}));
		food_info_array.push(jsontostring({"shop":info["shop"],"value":info["value"]}));
	});
	ssenvoyset("food_tag",jsontostring(food_tag_array));
	ssenvoyset("food_info",jsontostring(food_info_array));
}

function get_index_food(shop,json)
{
	for(var i=0;i<json.length;i++)
	{
		if(shop==stringtojson(json[i]).shop)
			return i;
	}
	return -1;
}
function showLoading() {
	$.mobile.loadingMessageTextVisible = true;
	$.mobile.showPageLoadingMsg("a", "加载中...");
}
function hideLoading() {
	$.mobile.hidePageLoadingMsg();
}
function showMyAlert(text){
    $.mobile.loadingMessageTextVisible = true;
    $.mobile.showPageLoadingMsg("a", text, true);
}

function myAlert(text){
    showMyAlert(text);
    setTimeout(hideLoading, 2000);
}