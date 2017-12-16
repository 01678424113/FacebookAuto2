@extends('layout')
@section('content')
    <div class="col-md-12">
        <div class="content-right post-group">
            <div class="row alert alert-success">
                <div class="col-md-6">
                    <div class="content-test">
                        <h3>Chọn group thể loại :</h3>
                        <hr>
                        <form action="{{route('postPostGroupCategory')}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <select class="form-control" id="categories">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="groups">

                            </div>
                            <input type="submit" class="btn btn-info" style="margin-top: 5px;" id="btn-checkbox-group"
                                   value="Chọn group">
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3>Thông báo | <span id="timer">0</span> giây</h3>
                    <hr>
                    <div id="response" class="" style="height:auto;padding: 10px">
                    </div>
                </div>
                <div class="col-md-6 hidden">
                    <!-- Lay id group-->
                    <div class="form-group">
                        <h3>Các id groups đã được chọn :</h3>
                        <hr>
                        <label for="group_ids">Id group :</label>
                        <textarea name="group_ids" class="form-control" id="group_ids" style="width: 500px;height: 200px;"
                                  placeholder="Nhập id các group"><?php if (isset($_POST['checkbox-group'])) {
                                foreach ($_POST['checkbox-group'] as $value) {
                                    echo trim($value) . ";";
                                }
                            } ?></textarea>
                    </div>
                    <!--End lay id group-->
                </div>
            </div>
            <div class="row mt-5 mb-5 alert alert-info">
                <div class="col-md-6 col-md-offset-3">
                    <div>
                        <h3>Post bài lên group đã chọn</h3>
                        <hr>
                        <div class="form-group">
                            <label for="message">Message :</label>
                            <input type="text" class="form-control" name="message" id="message">
                        </div>
                        <textarea hidden name="access_token_user" style="width: 500px;height: 200px;"
                                  id="access_token_user"><?php if (Session::has('accessToken_user')) {
                                echo Session::get('accessToken_user');
                            }?></textarea>
                        <br>
                        <div class="form-group">
                            <label for="time">Tự đăng sau :</label>
                            <input type="number" class="form-control" name="time" id="time">
                        </div>
                        <input type="button" value="Đăng bài" class="btn btn-info" onclick="StartPostGroup()">
                        <a class="btn btn-danger" href={{route('reset')}}>Reset</a>
                    </div>
                    <hr>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="js/handling-group.js"></script>
    <script>
        $(document).ready(function () {
            $('#categories').change(function () {
                var id_category = $(this).val();
                $.get("user/ajax/group/" + id_category, function (data) {
                    $('#groups').html(data);
                });
            });
        });
    </script>
@endsection