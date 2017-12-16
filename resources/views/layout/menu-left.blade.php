<div class="nav-side-menu">
    <div class="brand"><a href="">Shares.vn</a></div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

    <div class="menu-list">

        <ul id="menu-content" class="menu-content collapse out">
            <li>
                <a href="#">
                    <i class="fa fa-dashboard fa-lg"></i> Dashboard
                </a>
            </li>
            {{--Page--}}
            <li  data-toggle="collapse" data-target="#page" class="collapsed ">
                <a href="#"><i class="fa fa-gift fa-lg"></i> Page <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="page">
                <li class="list-group-item"><a href="{{route('getPostPage')}}">Đăng lên page</a></li>
                <li class="list-group-item"><a href="{{--{{route('showPage')}}--}}">Danh sách page</a></li>
            </ul>

            {{--Group--}}
            <li  data-toggle="collapse" data-target="#group" class="collapsed">
                <a href="#"><i class="fa fa-gift fa-lg"></i> Group <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="group">
                <li class="list-group-item"><a href="{{route('getPostGroupMe')}}">Đăng lên group của bạn</a></li>
                <li class="list-group-item"><a href="{{route('getPostGroupId')}}">Đăng lên theo id</a></li>
                <li class="list-group-item"><a href="{{route('showGroup')}}">Thêm group vào thể loại</a></li>
            </ul>

            {{--History--}}
            <li  data-toggle="collapse" data-target="#history" class="collapsed">
                <a href="#"><i class="fa fa-gift fa-lg"></i> Lịch sử bài đăng <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="history">
                <li class="list-group-item"><a href="{{route('getPosts')}}">Lịch sử đăng</a></li>
            </ul>

            {{--Category--}}
            <li  data-toggle="collapse" data-target="#category" class="collapsed">
                <a href="#"><i class="fa fa-gift fa-lg"></i> Quản lí thể loại <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="category">
                <li class="list-group-item"><a href="{{route('showCategory')}}">Danh sách</a></li>
            </ul>

            <li>
                <a href="#">
                    <i class="fa fa-user fa-lg"></i> Profile
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fa fa-users fa-lg"></i> Users
                </a>
            </li>
        </ul>
    </div>
</div>

