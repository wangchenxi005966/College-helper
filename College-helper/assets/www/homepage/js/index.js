var myScroll, pullDownEl, pullDownOffset, pullUpEl, pullUpOffset, generatedCount = 0;
/**
 * 初始化iScroll控件
 */
function initIscrolla(){
    if (myScroll != null) {
        myScroll.destroy();
    }
    
    pullDownEl = document.getElementById('pullDown');
    pullDownOffset = pullDownEl.offsetHeight;
    pullUpEl = document.getElementById('pullUp');
    pullUpOffset = pullUpEl.offsetHeight;
    
    myScroll = new iScroll('wrapperIndex', {
        useTransition: false, 
        useTransform: false,
        topOffset: pullDownOffset,
        fixedScrollbar: true,
        hideScrollbar: true,
        hScrollbar: false,
        vScrollbar: false,
        onRefresh: function(){
            if (pullDownEl.className.match('loading')) {
                pullDownEl.className = '';
                pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉刷新...';
            }
            else 
                if (pullUpEl.className.match('loading')) {
                    pullUpEl.className = '';
                    pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多...';
                }
        },
        onScrollMove: function(){
            if (this.y > 5 && !pullDownEl.className.match('flip')) {
                pullDownEl.className = 'flip';
                pullDownEl.querySelector('.pullDownLabel').innerHTML = '松手开始更新...';
                this.minScrollY = 0;
            }
            else 
                if (this.y < 5 && pullDownEl.className.match('flip')) {
                    pullDownEl.className = '';
                    pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉刷新...';
                    this.minScrollY = -pullDownOffset;
                }
                else 
                    if (this.y < (this.maxScrollY - 15) &&
                    !pullUpEl.className.match('flip')) {
                        pullUpEl.className = 'flip';
                        pullUpEl.querySelector('.pullUpLabel').innerHTML = '松手开始更新...';
                        this.maxScrollY = this.maxScrollY;
                    }
                    else 
                        if (this.y > (this.maxScrollY + 15) &&
                        pullUpEl.className.match('flip')) {
                            pullUpEl.className = '';
                            pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多...';
                            this.maxScrollY = pullUpOffset;
                        }
        },
        onScrollEnd: function(){
            if (pullDownEl.className.match('flip')) {
                pullDownEl.className = 'loading';
                pullDownEl.querySelector('.pullDownLabel').innerHTML = '加载中...';
                pullDownAction();
            }
            else 
                if (pullUpEl.className.match('flip')) {
                    pullUpEl.className = 'loading';
                    pullUpEl.querySelector('.pullUpLabel').innerHTML = '加载中...';
                    pullUpAction(); 
                }
        }
    });
    setTimeout(function(){
        document.getElementById('wrapperIndex').style.left = '0';
    }, 800);
    initialize();
    //update();
}

//检测元素是否在数组中已经存在
function in_array(stringToSearch, arrayToSearch){
    for (s = 0; s < arrayToSearch.length; s++) {
        thisEntry = arrayToSearch[s].toString();
        if (thisEntry == stringToSearch) {
            return false;//已经存在,返回false
        }
    }
    return true;
}

// 初始化空间信息
function initialize(){
    var arr1 = new Array();
    var arr3 = new Array();
    sessionStorage.removeItem("id");
    showLoading();
    $.getJSON("http://college-helper-server.wicp.net/init.php?callback=?", function(data){
        var len = data.length;
        var con = 0;
        if (len < 7) {
            con = len;
        }
        else {
            con = 7;
        }
        $("#cl").empty();
        $.each(data, function(infoIndex, info){
            if (infoIndex == 0) {
                sessionStorage.setItem("latest", info.id);
            }
            if (infoIndex == con - 1) {
                sessionStorage.setItem("id", info.id);
            }
            if (infoIndex < con) {
                if (info.head_pic != "null" && info.head_pic != "NULL" &&
                info.head_pic != "" &&
                info.head_pic != null) {
                    if (in_array(info.head_pic, arr3)) {
                        arr3.splice(0, 0, info.head_pic);
                    }
                }
                if (info.image != null && info.image != "NULL" &&
                info.image != "" &&
                info.image != "null") {
                    arr1.splice(0, 0, info.image);
                }
                var html = getHtml(info);
                $("#cl").append(html);
            }
        });
        for (var x = 0; x < arr3.length; x++) {
            var url = "http://college-helper-server.wicp.net/image/" + arr3[x]; // 目标图片地址
            //alert("arr3[" + x + "]=" + arr3[x]);
            localFile_head(url, arr3[x]);
        }
        for (x in arr1) {
            var url = "http://college-helper-server.wicp.net/image/" + arr1[x]; // 目标图片地址
            localFile(url, arr1[x]);
        }
        $("#cl").listview('refresh');
        setTimeout(function(){
            myScroll.refresh();
            hideLoading();
        }, 1500);
    });
}

/**
 * 下拉刷新 myScroll.refresh(); // 数据加载完成后，调用界面更新方法
 */
function pullDownAction(){
    setTimeout(update, 1000); // <-- Simulate network congestion, remove
    // setTimeout from production!
}

/**
 * 上拉刷新 myScroll.refresh(); // 数据加载完成后，调用界面更新方法
 */
function pullUpAction(){
    setTimeout(loadData, 1000); // <-- Simulate network congestion, remove
    // setTimeout from production!
}

function update(){
    showLoading();
    var lat = sessionStorage.getItem("latest");
    $.ajax({
        type: "get",
        url: "http://college-helper-server.wicp.net/update.php?latest=" + lat +
        "&callback=?",
        dataType: "json",
        timeout: 5000,
        success: function(json){
            display(json);
        },
        error: function(msg){
            console.log("请求出错，请检查网络状况");
            myScroll.refresh();
        }
    });
}

function display(data){
    var flag = false;
    var arr2 = new Array();
    var arr4 = new Array();
    sessionStorage.removeItem("id");
    sessionStorage.removeItem("latest");
    $("#cl").empty();
    var len = data.length;
    var con = 0;
    if (len < 7) {
        con = len;
    }
    else {
        con = 7;
    }
    $.each(data, function(infoIndex, info){
        if (info.latest == "true") {
            flag = true;
        }
        if (infoIndex < con) {
            if (info.head_pic != "null" && info.head_pic != "NULL" &&
            info.head_pic != "" &&
            info.head_pic != null) {
                if (in_array(info.head_pic, arr4)) {
                    arr4.splice(0, 0, info.head_pic);
                }
            }
            if (info.image != null && info.image != "NULL" &&
            info.image != "" &&
            info.image != "null") {
                arr2.splice(0, 0, info.image);
            }
            var text = getHtml(info);
            $("#cl").append(text);
        }
        if (infoIndex == 0) {
            sessionStorage.setItem("latest", info.id);
        }
        if (infoIndex == con - 1) {
            sessionStorage.setItem("id", info.id);
        }
    });
    for (var x = 0; x < arr4.length; x++) {
        var url = "http://college-helper-server.wicp.net/image/" + arr4[x]; // 目标图片地址
        localFile_head(url, arr4[x]);
    }
    for (x in arr2) {
        var uri = "http://college-helper-server.wicp.net/image/" + arr2[x]; // 目标图片地址
        localFile(uri, arr2[x]);
    }
    $("#cl").listview('refresh');
    setTimeout(function(){
        myScroll.refresh();
        hideLoading();
        if (flag) {
            myAlert("亲，已经更新到最新了呦");
        }
    }, 1500);
}

function loadData(){
    showLoading();
    var num = sessionStorage.getItem("id");
    $.ajax({
        type: "get",
        url: "http://college-helper-server.wicp.net/load.php?id=" + num +
        "&callback=?",
        dataType: "json",
        timeout: 5000,
        success: function(json){
            load(json);
        },
        error: function(msg){
            console.log("请求出错，请检查网络状况");
            myScroll.refresh();
        }
    });
}

function load(data){//每次返回3条数据
    var bit = 0;
    var arr5 = new Array();
    var arr6 = new Array();
    if (data.length == 0) {
        bit = 1;
    }
    sessionStorage.removeItem("id");
    $.each(data, function(infoIndex, info){
        if (info.head_pic != "null" && info.head_pic != "NULL" &&
        info.head_pic != "" &&
        info.head_pic != null) {
            if (in_array(info.head_pic, arr5)) {
                arr5.splice(0, 0, info.head_pic);
            }
        }
        if (info.image != null && info.image != "NULL" &&
        info.image != "" &&
        info.image != "null") {
            arr6.splice(0, 0, info.image);
        }
        var text = getHtml(info);
        $("#cl").append(text);
        if (infoIndex == 2) {
            sessionStorage.setItem("id", info.id);
        }
    });
    for (var x = 0; x < arr5.length; x++) {
        var url = "http://college-helper-server.wicp.net/image/" + arr5[x]; // 目标图片地址
        localFile_head(url, arr5[x]);
    }
    for (x in arr6) {
        var uri = "http://college-helper-server.wicp.net/image/" + arr6[x]; // 目标图片地址
        localFile(uri, arr6[x]);
    }
    $("#cl").listview('refresh');
    setTimeout(function(){
        myScroll.refresh();
        hideLoading();
        if (bit) {
            myAlert("所有信息已加载完毕");
        }
    });
}
