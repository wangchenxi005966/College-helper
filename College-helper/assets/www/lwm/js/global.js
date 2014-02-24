Date.prototype.format = function(format){
    var o = {
        "M+": this.getMonth() + 1, //month
        "d+": this.getDate(), //day
        "h+": this.getHours(), //hour
        "m+": this.getMinutes(), //minute
        "s+": this.getSeconds(), //second
        "q+": Math.floor((this.getMonth() + 3) / 3), //quarter
        "S": this.getMilliseconds()
        //millisecond
    };
    if (/(y+)/.test(format)) 
        format = format.replace(RegExp.$1, (this.getFullYear() +
        "").substr(4 - RegExp.$1.length));
    for (var k in o) 
        if (new RegExp("(" + k + ")").test(format)) 
            format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k] : ("00" + o[k]).substr(("" + o[k]).length));
    return format;
};
Date.prototype.addDays = function(d){
    this.setDate(this.getDate() + d);
};


Date.prototype.addWeeks = function(w){
    this.addDays(w * 7);
};


Date.prototype.addMonths = function(m){
    var d = this.getDate();
    this.setMonth(this.getMonth() + m);
    
    if (this.getDate() < d) 
        this.setDate(0);
};



function To_String(array){
    var new_array = new Array();
    for (var i = 0; i < array.length; i++) {
        new_array.push(jsontostring(array[i]));
    }
    
    return new_array;
}

function To_Json(array){
    var new_array = new Array();
    for (var i = 0; i < array.length; i++) {
        new_array.push(stringtojson(array[i]));
    }
    return new_array;
}

function newGuid(){
    var guid = "";
    for (var i = 1; i <= 32; i++) {
        var n = Math.floor(Math.random() * 16.0).toString(16);
        guid += n;
        if ((i == 8) || (i == 12) || (i == 16) || (i == 20)) 
            guid += "-";
    }
    return guid;
}


function getWeekBegin(year, month, day){
    var today = new Date(year, month - 1, day);
    var week = today.getDay();
    if (week == 0) {
        week = 7;
    }
    var monday = new Date(today.valueOf() - (week - 1) * 24 * 60 * 60 * 1000);
    return monday.getFullYear() + "/" + ((monday.getMonth() + 1).toString().length == 1 ? ("0" + (monday.getMonth() + 1)) : (monday.getMonth() + 1)) +
    "/" +
    (monday.getDate().toString().length == 1 ? "0" + monday.getDate() : monday.getDate());
}

function getWeekEnd(year, month, day){
    var today = new Date(year, month - 1, day);
    var week = today.getDay();
    if (week == 0) {
        week = 7;
    }
    var monday = new Date(today.valueOf() - (week - 1) * 24 * 60 * 60 * 1000);
    var sunday = new Date(monday.valueOf() + 6 * 24 * 60 * 60 * 1000);
    return sunday.getFullYear() + "/" + ((sunday.getMonth() + 1).toString().length == 1 ? ("0" + (sunday.getMonth() + 1)) : (sunday.getMonth() + 1)) + "/" + (sunday.getDate().toString().length == 1 ? "0" + sunday.getDate() : sunday.getDate());
}

function compareDate(strDate1, strDate2){

    var date1 = new Date(strDate1.replace(/\-/g, "\/"));
    var date2 = new Date(strDate2.replace(/\-/g, "\/"));
    //alert(date1);
    //alert(date2);
    return date1 - date2;
    
}

function showloading(str){
    $.mobile.loading('show', {
        text: str,
        textVisible: true,
        theme: 'a',
        html: ""
    });
}

String.prototype.trim = function(){
    return this.replace(/(^\s*)|(\s*$)/g, "");
};
String.prototype.ltrim = function(){
    return this.replace(/(^\s*)/g, "");
};
String.prototype.rtrim = function(){
    return this.replace(/(\s*$)/g, "");
};

function hideloading(){
    $.mobile.loading('hide');
}

//显示灰色JS遮罩层 
function showBg(){
    //alert("test");
    var header_height = $(".bg_header").height();
    // alert($(".bg_page").height()+" "+header_height);
    var bH = $(".bg_page").height() + header_height;
    var bW = $(".bg_page").width();
    //alert(bH+" "+bW);
    //  alert("test");
    $(".fullbg").css({
        top: header_height,
        width: bW,
        height: bH,
        display: "block"
    });
    
    $(window).scroll(function(){
        resetBg();
    });
    $(window).resize(function(){
        resetBg();
    });
    // alert("test");
}

function resetBg(){
    var fullbg = $(".fullbg").css("display");
    if (fullbg == "block") {
        var bH2 = $(".bg_page").height();
        var bW2 = $(".bg_page").width();
        $(".fullbg").css({
            width: bW2,
            height: bH2
        });
    }
}

//关闭灰色JS遮罩层和操作窗口 
function closeBg(){
    $(".fullbg").css({
        width: 0,
        height: 0,
        display: "none"
    });
}


function CovToLi(key, value){
    var HTML = "";
    HTML += "<li data-role=\"fieldcontain\">";
    HTML += "<div class=\"ui-grid-c\">";
    HTML += "<div class=\"ui-block-a\" style=\"width:25%;\">";
    HTML += "<label  class=\"text_label\">";
    HTML += key;
    HTML += "</label>";
    HTML += "</div>";
    HTML += "<div class=\"ui-block-b\" style=\"width:75%;text-align:left;font-weight:bold;color:black\">";
    HTML += "<p data-role=\"none\" class=\"showtext\" >" + value + "</p>";
    HTML += "</div>";
    HTML += "</div>";
    HTML += "</li>";
    return HTML;
}

function quit(){
    ssenvoyremove("personinfo");
    ssenvoyremove("personinfo_temp");
    ssenvoyset("login", "false");
    ssenvoyremove("course");
    sessionset("updatecourse", 0);
	$.mobile.changePage("login.html");
}

function create_dir(){
    var createDir = ssenvoyget("create_dir");
    if (createDir == null || createDir == "") {
        var fsFail = function(){
            alert("获取持久化文件系统失败！");
            ssenvoyset("create_dir", "false");
        };
        
        var success = function(){
            ssenvoyset("create_dir", "true");
        };
        
        var Fail = function(){
            alert("新建文件夹失败");
            ssenvoyset("create_dir", "false");
        };
        var gotFileSystem = function(fileSystem){
            fileSystem.root.getDirectory("college-helper", {
                create: true
            }, success, Fail);
        };
        window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, gotFileSystem, fsFail);
    }
    else {
        if (createDir == "false") {
            var fsFail = function(){
                alert("获取持久化文件系统失败！");
                ssenvoyset("create_dir", "false");
            };
            
            var success = function(fileentry){
                ssenvoyset("create_dir", "true");
            };
            
            var Fail = function(){
                alert("新建文件夹失败");
                ssenvoyset("create_dir", "false");
            };
            var gotFileSystem = function(fileSystem){
                fileSystem.root.getDirectory("college-helper", {
                    create: true
                }, success, Fail);
            };
            window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, gotFileSystem, fsFail);
        }
    }
    
    
}



