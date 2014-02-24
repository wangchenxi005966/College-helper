function save(){
    var date = new Date($('#start_time').val());
    var date1 = new Date($('#over_time').val());
    var id = newGuid();
    
    if ($('#event_name').val() == "") 
        alert("事件名称不能为空！");
    else 
        if ($('#event_participator').val() == "") 
            alert("事件参与人不能为空！");
        else 
            if (date > date1) {
                alert("结束时间必须大于开始时间");
            }
            else 
                if ($('#event_name').val() != "" && $('#event_participator').val() != "") {
                    if (ssenvoyget("event_of_week") == null) {
                    
                        var repeat_number = 0;
                        if ($('#demo_dummy').val() == "单次") 
                            repeat_number = 0;
                        else 
                            if ($('#demo_dummy').val() == "每天重复") 
                                repeat_number = 1;
                            else 
                                if ($('#demo_dummy').val() == "每周重复") 
                                    repeat_number = 7;
                        var event_of_week = [{
                            "event_name": $('#event_name').val(),
                            "event_category": $('#demo_dummy').val(),
                            "event_participator": $('#event_participator').val(),
                            "remind": $('#remind').val(),
                            "start_time": $('#start_time').val(),
                            "over_time": $('#over_time').val(),
                            "remind_time": $('#demo1_dummy').val(),
                            "repeat": repeat_number,
                            "data_theme": "e",
                            "id": id,
                            "version": 0,
                            "delflag": 0,
                            "reminded": 0
                        }];
                        ssenvoyset("event_of_week", jsontostring(To_String(event_of_week)));
                        $.mobile.changePage("jh_index.html");
                    }
                    else {
                    
                        var event_of_week = To_Json(stringtojson(ssenvoyget("event_of_week")));
                        var repeat_number = 0;
                        if ($('#demo2_dummy').val() == "单次") 
                            repeat_number = 0;
                        else 
                            if ($('#demo2_dummy').val() == "每天重复") 
                                repeat_number = 1;
                            else 
                                if ($('#demo2_dummy').val() == "每周重复") 
                                    repeat_number = 7;
                        event_of_week.push({
                            "event_name": $('#event_name').val(),
                            "event_category": $('#demo_dummy').val(),
                            "event_participator": $('#event_participator').val(),
                            "remind": $('#remind').val(),
                            "start_time": $('#start_time').val(),
                            "over_time": $('#over_time').val(),
                            "remind_time": $('#demo1_dummy').val(),
                            "repeat": repeat_number,
                            "data_theme": "e",
                            "id": id,
                            "version": 0,
                            "delflag": 0,
                            "reminded": 0
                        });
                        ssenvoyset("event_of_week", jsontostring(To_String(event_of_week)));
                        $.mobile.changePage("jh_index.html");
                        checkname();
                    }
                }
}


function save2(){
    if ($('#event_name').val() == "") 
        alert("事件名称不能为空！");
    else {
        var number = ssenvoyget("event_date");
        var event_of_beiwang = To_Json(stringtojson(ssenvoyget("event_of_beiwang")));
        var repeat_number = 0;
        if ($('#demo_dummy').val() == "单次") 
            repeat_number = 0;
        else 
            if ($('#demo_dummy').val() == "每天重复") 
                repeat_number = 1;
            else 
                if ($('#demo_dummy').val() == "每周重复") 
                    repeat_number = 7;
        event_of_beiwang[number].event_name = $("#event_name").val();
        
        event_of_beiwang[number].start_time = $("#start_time").val();
        
        event_of_beiwang[number].repeat = repeat_number;
        event_of_beiwang[number].remarks = $("#remarks").val();
        event_of_beiwang[number].version++;
        ssenvoyset("event_of_beiwang", jsontostring(To_String((event_of_beiwang))));
        $.mobile.changePage("event.html?id=2&position=" + number, {
            transition: "slidedown"
        });
        
    }
}


function save1(){
    var id = newGuid();
    if ($('#event_name').val() == "") 
        alert("事件名称不能为空！");
    else 
        if ($('#event_name').val() != "") {
            if (!ssenvoyget("event_of_beiwang")) {
            
                var repeat_number = 0;
                if ($('#demo_dummy').val() == "单次") 
                    repeat_number = 0;
                else 
                    if ($('#demo_dummy').val() == "每天重复") 
                        repeat_number = 1;
                    else 
                        if ($('#demo_dummy').val() == "每周重复") 
                            repeat_number = 7;
                var event_of_beiwang = [{
                    "event_name": $('#event_name').val(),
                    "start_time": $('#start_time').val(),
                    "repeat": repeat_number,
                    "remarks": $('#remarks').val(),
                    "id": id,
                    "version": 0,
                    "delflag": 0
                }];
                
                ssenvoyset("event_of_beiwang", jsontostring(To_String(event_of_beiwang)));
                // window.location.href = "beiwang.html";
                $.mobile.changePage("beiwang.html", {
                    transition: "slidedown"
                });
            }
            else {
                var event_of_beiwang = To_Json(stringtojson(ssenvoyget("event_of_beiwang")));
                var repeat_number = 0;
                if ($('#demo_dummy').val() == "单次") 
                    repeat_number = 0;
                else 
                    if ($('#demo_dummy').val() == "每天重复") 
                        repeat_number = 1;
                    else 
                        if ($('#demo_dummy').val() == "每周重复") 
                            repeat_number = 7;
                event_of_beiwang.push({
                    "event_name": $('#event_name').val(),
                    "start_time": $('#start_time').val(),
                    "repeat": repeat_number,
                    "remarks": $('#remarks').val(),
                    "id": id,
                    "version": 0,
                    "delflag": 0
                });
                
                ssenvoyset("event_of_beiwang", jsontostring(To_String(event_of_beiwang)));
                
                //  ssenvoyset("event_detail", JSON.stringify(event_of_beiwang.event_details));
                $.mobile.changePage("beiwang.html", {
                    transition: "slidedown"
                });
            }
        }
}

function save3(){
    var date = new Date($('#start_time').val());
    var date1 = new Date($('#over_time').val());
    var repeat_number = 0;
    if ($('#event_name').val() == "") 
        alert("事件名称不能为空！");
    else 
        if ($('#event_participator').val() == "") 
            alert("事件参与人不能为空！");
        else 
            if (date > date1) {
                alert("结束时间必须大于开始时间");
            }
            else 
                if ($('#event_name').val() != "" && $('#event_participator').val() != "") {
                
                    var edit_number = ssenvoyget("event_date");
                    //var event_of_week = JSON.parse(ssenvoyget("event_of_week"));
                    var event_of_week = To_Json(stringtojson(ssenvoyget("event_of_week")));
                    event_of_week[edit_number].event_name = $("#event_name").val();
                    event_of_week[edit_number].event_participator = $("#event_participator").val();
                    event_of_week[edit_number].event_category = $("#demo_dummy").val();
                    
                    event_of_week[edit_number].remind = $("#remind").val();
                    
                    event_of_week[edit_number].start_time = $("#start_time").val();
                    
                    event_of_week[edit_number].over_time = $("#over_time").val();
                    // alert(2);
                    event_of_week[edit_number].remind_time = $("#demo1_dummy").val();
                    event_of_week[edit_number].version++;
					event_of_week[edit_number].reminded=0;
                    // alert(event_of_week[edit_number].version);
                    if ($('#demo2_dummy').val() == "单次") 
                        repeat_number = 0;
                    else 
                        if ($('#demo2_dummy').val() == "每天重复") 
                            repeat_number = 1;
                        else 
                            if ($('#demo2_dummy').val() == "每周重复") 
                                repeat_number = 7;
                    event_of_week[edit_number].repeat = repeat_number;
                    ssenvoyset("event_of_week", jsontostring(To_String(event_of_week)));
                    $.mobile.changePage("event.html?id=1&position=" + edit_number, {
                        transition: "slidedown"
                    });
                }
}

function GetRequest(){

    var url = location.search; //获取url中"?"符后的字串
    //$.mobile.path.get(url);
    // alert(url);
    var theRequest = new Object();
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        strs = str.split("&");
        for (var i = 0; i < strs.length; i++) {
            theRequest[strs[i].split("=")[0]] = (strs[i].split("=")[1]);
        }
    }
    return theRequest;
}

function Delete(delete_pos){
    var request = GetRequest();
    var id = request["id"];
    
    if (id == 1) {
        var event_of_week = To_Json(stringtojson(ssenvoyget("event_of_week")));
        event_of_week[delete_pos].delflag = 1;
        
        ssenvoyset("event_of_week", jsontostring(To_String(event_of_week)));
        //ssenvoyset("event_details", JSON.stringify(event_of_week));
        $.mobile.changePage("jh_index.html");
    }
    else {
        var event_of_beiwang = To_Json(stringtojson(ssenvoyget("event_of_beiwang")));
        event_of_beiwang[delete_pos].delflag = 1;
        ssenvoyset("event_of_beiwang", jsontostring(To_String(event_of_beiwang)));
        $.mobile.changePage("beiwang.html");
        
    }
}

function edit(){
    var request = GetRequest();
    var id = request["id"];
    var position = request["position"];
    ssenvoyset("event_date", position);
    if (id == 1) 
        //window.location.href = "edit.html";
        $.mobile.changePage("edit.html", {
            transition: "slideup"
        });
    else 
        if (id == 2) 
            // window.location.href = "beiwang_edit.html";
            $.mobile.changePage("beiwang_edit.html", {
                transition: "slideup"
            });
    
}

function Return(){
    var request = GetRequest();
    var id = request["id"];
    if (id == 1) 
        $.mobile.changePage("jh_index.html");
    else 
        if (id == 2) {
            var event_of_beiwang = To_Json(stringtojson(ssenvoyget("event_of_beiwang")));
            var event_date = request["position"];
            var now = new Date();
            var date = new Date(event_of_beiwang[event_date].start_time);
            if (date > now) {
                $.mobile.changePage("beiwang.html");
            }
            else {
                $.mobile.changePage("beiwang_overdue.html");
            }
            
            
        }
}



function checkdate(){
    if (ssenvoyget("event_of_week") != null) {
    
        var event_of_week = To_Json(stringtojson(ssenvoyget("event_of_week")));
        var i = 0;
        var now = new Date();
        
        while (event_of_week[i]) {
            if (event_of_week[i].delflag != 1) {
                var date = new Date(event_of_week[i].start_time);
                var remind_time = event_of_week[i].remind_time * 60 * 1000;
                remind_time = date.getTime() - remind_time;
                var remind = event_of_week[i].remind;
                
                if (event_of_week[i].reminded == 0 && remind == "on" && remind_time <= now.getTime() && date.getTime() >= now.getTime()) {
                    var event_name = event_of_week[i].event_name + " 即将到期！请注意时间！";
                    //ssenvoyset("event_date", event_name);
                    window.plugins.statusBarNotification.notify('事件到时提醒！', event_of_week[i].event_name + "    (类型:" + event_of_week[i].event_category + " 参与人:" + event_of_week[i].event_participator + ")");
                    event_of_week[i].reminded = 1;
                    
					setTimeout("beep('1')",50);
					vibrate(1000);
                    ssenvoyset("event_of_week", jsontostring(To_String(event_of_week)));
                }
                else {
                    if (event_of_week[i].repeat >= 1 && now > date) {
                        var date_time = date.getTime() + (event_of_week[i].repeat * 1000 * 3600 * 24);
                        var over = new Date(event_of_week[i].over_time);
                        var over_time = over.getTime() + (event_of_week[i].repeat * 1000 * 3600 * 24);
                        var date2 = new Date(over_time);
                        var date1 = new Date(date_time);
                        event_of_week[i].reminded = 0;
                        event_of_week[i].start_time = date1.format("yyyy/MM/dd") + " " + date1.format("hh:mm");
                        event_of_week[i].over_time = date2.format("yyyy/MM/dd") + " " + date1.format("hh:mm");
                        ssenvoyset("event_of_week", jsontostring(To_String(event_of_week)));
                    }
                }
            }
            i++;
        }
    }
}
function beep(times)
{
	navigator.notification.beep(times);
}

function vibrate(time)
{
	navigator.notification.vibrate(time);
}
function checkname(){

    if (ssenvoyget("event_of_week") != null) {
        //var event_of_week =To_Json(stringtojson(ssenvoyget("event_of_week")));
        var event_of_week = To_Json(stringtojson(ssenvoyget("event_of_week")));
        var i = 0;
        
        while (event_of_week[i]) {
            if (event_of_week[i].delflag != 1) {
                var j = i + 1;
                
                while (event_of_week[j]) {
                    if (event_of_week[j].delflag != 1) 
                        var date1 = new Date(event_of_week[i].start_time);
                    var date2 = new Date(event_of_week[j].start_time);
                    //alert(date1+date2);
                    
                    if (date1.getTime() == date2.getTime()) {
                    
                        var arr = event_of_week[i].event_participator.split(" ");
                        
                        
                        var event_participator = event_of_week[j].event_participator;
                        var count = 0;
                        var m = 0;
                        while (m < arr.length) {
                            if (event_participator.indexOf(arr[m]) != -1) {
                                count++;
                            }
                            m++;
                        }
                        
                        if (count != 0) {
                            event_of_week[j].data_theme = "b";
                            event_of_week[i].data_theme = "b";
                            ssenvoyset("event_of_week", jsontostring(To_String(event_of_week)));
                        }
                    }
                    
                    j++;
                }
            }
            i++;
        }
    }
}
