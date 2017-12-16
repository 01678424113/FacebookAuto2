/**
 * Created by Admin on 9/24/2017.
 */
var ids = '';
var _a_list = document.getElementsByTagName('a');
for (var i = 0; i < _a_list.length; i++) {
    if (_a_list[i].getAttribute('href')) {
        var _href = _a_list[i].getAttribute('href');
        var _group = _href.substring(1,7);
        if (_a_list[i].getAttribute('data-hovercard') && _group === "groups") {
            var _hvc = _a_list[i].getAttribute('data-hovercard');
            var id = _hvc.substring(_hvc.lastIndexOf('=') + 1);
            ids += id + ';' ;
        }
    }
}
console.log(ids);

