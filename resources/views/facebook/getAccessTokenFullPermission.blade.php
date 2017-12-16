@extends('layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-offset-2">
                <h3>Đăng nhập bằng tài khoản Facebook</h3>
                <div class="alert alert-danger">
                    <p>Chú ý :</p>
                    <ul>
                        <li>Nếu tên đăng nhập là số điện thoại thì cần thêm +84 ở trước !</li>
                        <li>VD: 012345678 => +8412345678 </li>
                    </ul>
                </div>
                <form action="{{route('postAccessTokenFull')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="username">Tên đăng nhập :</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Tên đăng nhập facebook">
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button id="click" type="submit" class="btn btn-default">Đăng nhập</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
   {{-- <script>
        $(document).ready(function () {
            $('#click').click(function () {
                var password = $('#password').val();
                alert(password);
            });
        });
    </script>--}}
@endsection
