@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-12">

                <div class="content-right post-group">
                    <h3>Chọn group theo ID :</h3>
                    <hr>
                    <!-- Lay id group-->
                    <form action="{{route('postPostGroupId')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="group_ids">ID group :</label>
                            <textarea name="group" class="form-control" id="group_ids" cols="30"
                                      rows="3">@if(isset($_POST['group'])){{trim($_POST['group'])}}@endif</textarea>
                        </div>
                        <input type="submit" class="btn btn-info" style="margin-top: 5px;" id="btn-checkbox-group"
                               value="Chọn group">
                    </form>
                    <!--End lay id group-->
                    <div class="row mt-5 mb-5 alert alert-success">
                        <div class="col-md-6 ">
                            <div>
                                <h3>Đăng bài lên group đã chọn</h3>
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
                        <div class="col-md-6">
                            <h3>Thông báo | <span id="timer">0</span> giây</h3>
                            <hr>
                            <div id="response" class="" style="height:auto;padding: 10px">
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>
    <div class="row">
        <div class="test">
            <?php
            $fb = new Facebook\Facebook([
                'app_id' => env('FACEBOOK_APP_ID'),
                'app_secret' => env('FACEBOOK_APP_SECRET'),
                'default_graph_version' => env('FACEBOOK_API_VERSION'),
            ]);
            $checked = "";
            if (isset($_POST['group'])) {
                $ids_group = explode(';', $_POST['group']);
                foreach ($ids_group as $id_group) {
                    $res = $fb->get('/' . $id_group, Session::get('accessToken_user'));
                    $res = $res->getDecodedBody();
                    $name_group = $res['name'];
                    echo " <div class='checkbox'>
                         <label><input type='checkbox' name='checkbox-group[]' value='" . $id_group . "' " . $checked . ">" . $name_group . "</label>
                   </div>";
                }
            }
            ?>
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