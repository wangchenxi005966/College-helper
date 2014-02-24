function goTo(page){
    showLoading();
    $.mobile.changePage(page, {
        transition: "slide"
    });
}

function goBack(){
    $.mobile.back();
}

function showLoading(){
    $.mobile.loadingMessageTextVisible = true;
    $.mobile.showPageLoadingMsg("a", "加载中...");
}

function hideLoading(){
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

function getUrlParam(string){
    var obj = new Array();
    if (string.indexOf("?") != -1) {
        var string1 = string.substr(string.indexOf("?") + 1);
        var strs = string1.split("&");
        for (var i = 0; i < strs.length; i++) {
            var tempArr = strs[i].split("=");
            obj[i] = tempArr[1];
        }
    }
    return obj;
}

/**
 * 检查网络情况
 * @returns {Boolean}
 */
function checkConnection(){
    var networkState = navigator.network.connection.type;
    if (networkState == Connection.NONE) {
        navigator.notification.confirm('请确认网络连接已开启,并重试', showAlert, '提示', '确定');
        return false;
    }
    else {
        return true;
    }
}

function showAlert(button){
    return false;
}

/**
 * 下载图片
 *  @param sourceUrl 目标图片地址
 *  @param targetUrl 图片存储地址
 *  @param id        页面图片id
 */
function downloadPic(sourceUrl, targetUrl, id){
    var fileTransfer = new FileTransfer();
    var uri = encodeURI(sourceUrl);
    fileTransfer.download(uri, targetUrl, function(entry){
        var smallImage = document.getElementById(id);
        smallImage.style.display = 'block';
        smallImage.src = entry.fullPath;
        hideLoading();
    }, function(error){
        console.log("下载网络图片出现错误");
    });
}

function downloadPic_head(sourceUrl, targetUrl, id){
    var fileTransfer = new FileTransfer();
    var uri = encodeURI(sourceUrl);
    fileTransfer.download(uri, targetUrl, function(entry){
        var small = document.getElementsByClassName(id);
        //alert("small.length=" + small.length);
        for (var i = 0; i < small.length; i++) {
            //alert("small[i]=" + small[i]);
            small[i].style.display = 'block';
            small[i].src = entry.fullPath + "?" + (new Date()).getTime();
        }
    }, function(){
        console.log("下载网络图片出现错误");
    });
}

var dir = "college-helper/homepage";
/**
 * 加载图片 若缓存中没有该图片则下载
 * @param sourceUrl 目标图片地址
 * @param imgName 图片名称/图片id
 */
function localFile_head(sourceUrl, imgName){
    window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){
        fileSystem.root.getDirectory(dir, {
            create: true,
            exclusive: false
        }, function(fileEntry){
            console.log("创建目录");
        }, function(){
            alert('创建目录失败');
            console.log("创建目录失败");
        });
        var _localFile = dir + "/" + imgName;
        var _url = sourceUrl;
        //查找文件
        fileSystem.root.getFile(_localFile, null, function(fileEntry){
            //文件存在就直接显示
            //alert("imgName=" + imgName);
            var small = document.getElementsByClassName(imgName);
            //alert("small.length=" + small.length);
            for (var i = 0; i < small.length; i++) {
                //alert("small[i]=" + small[i]);
                small[i].style.display = 'block';
                small[i].src = fileEntry.fullPath + "?" + (new Date()).getTime();
            }
        }, function(){
            //否则就到网络下载图片!
            fileSystem.root.getFile(_localFile, {
                create: true,
                exclusive: false
            }, function(fileEntry){
                var targetURL = fileEntry.fullPath;
                downloadPic_head(_url, targetURL, imgName);
            }, function(){
                //alert('下载图片出错1');
                console.log('下载图片出错1');
            });
        });
    }, function(evt){
        alert("加载文件系统出现错误");
        console.log("加载文件系统出现错误");
    });
}

function localFile(sourceUrl, imgName){
    window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){
        fileSystem.root.getDirectory(dir, {
            create: true,
            exclusive: false
        }, function(fileEntry){
            console.log("创建目录");
        }, function(){
            alert('创建目录失败');
            console.log("创建目录失败");
        });
        var _localFile = dir + "/" + imgName;
        var _url = sourceUrl;
        //查找文件
        fileSystem.root.getFile(_localFile, null, function(fileEntry){
            //文件存在就直接显示
            var small = document.getElementById(imgName);
            small.style.display = 'block';
            small.src = fileEntry.fullPath;
        }, function(){
            //否则就到网络下载图片!
            fileSystem.root.getFile(_localFile, {
                create: true,
                exclusive: false
            }, function(fileEntry){
                var targetURL = fileEntry.fullPath;
                downloadPic(_url, targetURL, imgName);
            }, function(){
                //alert('下载图片出错2');
                console.log('下载图片出错2');
            });
        });
    }, function(evt){
        alert("加载文件系统出现错误");
        console.log("加载文件系统出现错误");
    });
}

function getHtml(info){
    var html = "";
    html += "<li>";
    if (info.head_pic != "null" && info.head_pic != "NULL" &&
    info.head_pic != "" &&
    info.head_pic != null) {
        html = html + "<img class=\"listpic" + " " + info.head_pic + "\" src=\"./image/loading_2.gif\">";
    }
    else {
        html += "<img src=\"./image/default.png\" class=\"listpic\">";
    }
    html += "<p class=\"listtitle\">";
    html += info.username;
    html += "</p><p class=\"listcontent\">";
    html += info.content;
    html += "</p>";
    if (info.image != null && info.image != "NULL" &&
    info.image != "" &&
    info.image != "null") {
        var imageName = info.image;
        html = html + "<img id=\"" + imageName + "\" src=\"./image/loading.gif\" class=\"content_pic\"\">";
    }
    html += "</li>";
    return html;
}

function clear_cache(){
    var fsFail = function(){
        alert("删除失败");
    };
    
    var delete_success = function(){
        if ($.mobile.activePage.is("#indexPage")) {
            alert("缓存删除成功");
            $.mobile.changePage("../lwm/setting.html", {
                transition: "slide"
            });
        }
    };
    
    var success = function(directoryEntry){
        directoryEntry.removeRecursively(delete_success, fsFail);
    };
    
    var gotFileSystem = function(fileSystem){
        fileSystem.root.getDirectory("college-helper/homepage", {
            create: true,
            exclusive: false
        }, success, fsFail);
    };
    
    window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, gotFileSystem, fsFail);
}
