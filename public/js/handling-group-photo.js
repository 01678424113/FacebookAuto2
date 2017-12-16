/*****************************************************************************************/
/*******************************************Auto post group*****************************************/
/*****************************************************************************************/

//Function start
function StartPostGroupPhoto() {
    _messageGroup = document.getElementById('message-photo').value;
    _urlGroup = document.getElementById('url-photo').value;

    _accessTokenUser = document.getElementById('access_token_user').value;
    _monitor = document.getElementById('response');
    _List = document.getElementById('group_ids').value.split(';');
    _ListIndex = -1;
    _wait_time = parseInt(document.getElementById('time-photo').value);
    _wait_time = _wait_time + Math.floor(Math.random()*20);
    setTimeout("_AutoCallGroupPhoto()", 1000);
}
function _AutoCallGroupPhoto() {
    var CallAutoCallGroup = true;
    if (_wait_time === 0) {
        _wait_time = parseInt(document.getElementById('time-photo').value);
        _ListIndex++;
        if (_ListIndex < _List.length) {
            //Delete space
            if (_List[_ListIndex] === "") {
                CallAutoCallGroup = false;
            } else {
                _List[_ListIndex] = _List[_ListIndex].trim();
                _PostToGroupIdPhoto(_List[_ListIndex], _accessTokenUser);
            }
        } else {
            CallAutoCallGroup = false;
        }
    } else {
        _wait_time--;
        document.getElementById('timer').innerHTML = _wait_time;
    }
    if (CallAutoCallGroup) {
        setTimeout("_AutoCallGroupPhoto()", 1000);
    } else {
        var _p = document.createElement('p');
        _p.innerHTML = '*** ĐÃ HẾT NHÓM CẦN POST';
        _monitor.appendChild(_p);
    }
}
//Run post
function _PostToGroupIdPhoto( _groupid, _access_token_user) {
    FB.api('/' + _groupid + '/photos', 'post', {
        message: _messageGroup,
        url : _urlGroup,
        access_token: _access_token_user
    }, function (response) {
        var ms_post = document.createElement('p');
        if (!response || response.error) {
            console.log(response.error);
            ms_post.innerHTML = "Có lỗi" + response.error + " khi post bài vào groupid = " + _groupid;
            _monitor.appendChild(ms_post);
        } else {
            //Ajax send $_GET['idPost']
            $.get('http://localhost/FacebookAuto/public/user/acction/save-id-post',{idPost:response.id},function (data) {
            });
            ms_post.innerHTML = "Đã post photo thành công vào group id  " + _groupid;
            _monitor.appendChild(ms_post);
            _wait_time = _wait_time + Math.floor(Math.random()*20);
        }
    });
}
/*****************************************************************************************/
/*******************************************End auto post*****************************************/
/*****************************************************************************************/