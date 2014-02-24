function synchronize(key, account){
    showloading("同步数据中···");
    $.getJSON("http://college-helper-server.wicp.net/syncdata_jh.php?callback=?", {
        "key": key,
        "account": account
    }).done(function(data){
        if (data.error == "true") {
            hideloading();
            alert(data.message);
        }
        else {
            var value_0 = new Array();
            if (data.value_0 != "" && data.value_0 != null) {
                value_0 = data.value_0;
                value_0 = To_String(value_0);
            }
            var value_1 = new Array();
            if (data.value_1 != "" && data.value_1 != null) {
                value_1 = data.value_1;
                value_1 = To_String(value_1);
            }
            syncdata(value_0, "event_of_week", account);
            syncdata(value_1, "event_of_beiwang",account);
            hideloading();
        }
    });
}



function syncdata(data, key, account){
    var localdata = new Array();
    var localdata_str = ssenvoyget(key)
    if (localdata_str != null && localdata_str != "") {
        localdata = stringtojson(localdata_str);
    }
    var result = commbine(data, localdata);
    if (result.length != null && result != "") {
    
        if (result.length != 0) {
        
            ssenvoyset(key, jsontostring(result));
            upload(result,key,account);  
        }
        
    }
    
}

function commbine(webdata, localdata){
    var result = new Array();
    var localdata_id = getIDFromArray(localdata);
    var webdata_id = getIDFromArray(webdata);
    
    for (var i = 0; i < localdata.length; i++) {
        var oned = localdata[i];
        var oned_json = stringtojson(oned);
        if (oned_json.delflag == 0) {
            if ($.inArray(oned_json.id, webdata_id) == -1) {
                result.push(oned);
            }
            else {
                var oned_index = webdata.indexOf(oned);
               // alert("oned_index:" + oned_index);
                if (oned_index != -1) {
                    var web_oned = webdata[oned_index];
					var web_oned_json=stringtojson(web_oned);
                    if (parseInt(web_oned_json.version) > parseInt(oned_json.version)) {
                        result.push(web_oned);
                    }
                    else {
                        result.push(oned);
                    }
                    
                }
            }
        }
    }
    
    for (var j = 0; j < webdata.length; j++) {
        var newone = webdata[j];
		var newone_json=stringtojson(newone);
        if (newone_json.delflag != 1) {
            if ($.inArray(newone_json.id, localdata_id) == -1) {
                result.push(newone);
            }
        }
        
    }
    return result;
}

function getIDFromArray(array){
    var i = 0;
    var id_array = new Array();
    for (i; i < array.length; i++) {
        var temp = stringtojson(array[i]);
        $.each(temp, function(key, value){
            if (key == "id") {
                id_array.push(value);
            }
        });
        id_array.push(array[i].id);
    }
    return id_array;
}


function upload(result, key, account){

   var result_str = jsontostring(result);
    $.ajax({
        url: "http://college-helper-server.wicp.net/syncdata_jh.php",
        type: "post",
        dataType: "jsonp",
        jsonp: "callback",
        data: {
            "account": account,
            "key": "jh_upload",
            "key_1": key,
            "value": result_str
        },
        success: function(data){
			alert(data.error+" "+data.message);
        },
        fail: function(){
        }
    });
}
