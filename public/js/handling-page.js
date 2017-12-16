
/*****************************************************************************************/
/*******************************************Auto post page*****************************************/
/*****************************************************************************************/
var _List; // List id

var _ListIndex = -1;

var _link; // Attribute link
var _message; // Attribute message


var _List_access_token; // List access token page

var _monitor; // Message post

//Function start
function StartPost() {
    _link = document.getElementById('link').value;
    _message = document.getElementById('message').value;
    _monitor = document.getElementById('response');
    _List = document.getElementById('page_ids').value.split(';');
    _List_access_token = document.getElementById('access_token_page').value;
    _ListIndex = -1;
    _wait_time = parseInt(document.getElementById('time').value);
    _wait_time = _wait_time + Math.floor(Math.random()*20);
    setTimeout("_AutoCall()", 1000);
}
function _AutoCall() {
    var CallAutoCall = true;
    if (_wait_time === 0) {
        _wait_time = parseInt(document.getElementById('time').value);
        _ListIndex++;
        if (_ListIndex < (_List.length-1)) {
            //Delete space
            if (_List[_ListIndex] === "") {
                CallAutoCall = false;
            } else {
                _List[_ListIndex] = _List[_ListIndex].trim();
                _List_access_token= _List_access_token.trim();
                _PostToPageId(_List[_ListIndex], _List_access_token);
            }
        } else {
            CallAutoCall = false;
        }
    } else {
        _wait_time--;
        document.getElementById('timer').innerHTML = _wait_time;
    }
    if (CallAutoCall) {
        setTimeout("_AutoCall()", 1000);
    } else {
        var _p = document.createElement('p');
        _p.innerHTML = '*** ĐÃ HẾT NHÓM CẦN POST';
        _monitor.appendChild(_p);
    }
}

//Run post
function _PostToPageId(_pageid, _access_token_page) {
    FB.api('/' + _pageid + '/feed', 'post', {
        link: _link,
        message: _message,
        access_token: _access_token_page
    }, function (response) {
        var ms_post = document.createElement('p');
        if (!response || response.error) {
            ms_post.innerHTML = "Có lỗi" + response.error + " khi post bài vào pageid = " + _pageid;
            _monitor.appendChild(ms_post);
        } else {
            //Ajax send $_GET['idPost']
           $.get('http://localhost/FacebookAuto/public/user/acction/save-id-post',{idPost:response.id},function (data) {
           });
            ms_post.innerHTML = "Đã post thành công vào page id " + _pageid;
            _monitor.appendChild(ms_post);
            _wait_time = _wait_time + Math.floor(Math.random()*20);
        }
    });
}
/*****************************************************************************************/
/*******************************************End auto post page*****************************************/
/*****************************************************************************************/


