@extends('layout')
@section('content')
    <div class="col-md-12">
        <div class="content-right post-group">
            <div class="row alert alert-success">
                <div class="col-md-6">
                    <!--Show list group-->
                    <div class="mt-5 mb-5">
                        <h3>Danh sách các Group đã tham gia</h3>
                        <hr>
                        <form action="{{route('addGroupIntoCategory')}}" method="post">
                            {{csrf_field()}}
                            <select name="id_category" id="id_category" class="form-control">
                                @foreach($categories as $category)
                                    <option @if($category->id_category == $category->id)
                                            {{"selected"}}
                                            @endif
                                            value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            <?php
                            $fb = new Facebook\Facebook([
                                'app_id' => env('FACEBOOK_APP_ID'),
                                'app_secret' => env('FACEBOOK_APP_SECRET'),
                                'default_graph_version' => env('FACEBOOK_API_VERSION'),
                            ]);
                            if (Session::has('accessToken_user')) {
                                $res = $fb->get('/me/groups', Session::get('accessToken_user'));
                                $res = $res->getDecodedBody();
                                $checked = "";
                                foreach ($res['data'] as $group) {
                                    if (isset($_POST['checkbox-group'])) {
                                        foreach ($_POST['checkbox-group'] as $value) {
                                            if ($value == $group['id']) {
                                                $checked = "checked";
                                                break;
                                            } else {
                                                $checked = "";
                                            }
                                        }
                                    }
                                    echo " <div class='checkbox'>
                                    <label><input type='checkbox' name='checkbox-group[]' value='" . $group['id']. "-" . $group['name'] . "' " . $checked . ">" . $group['name'] . " - " . $group['id'] . "</label>
                                   </div>";
                                }
                            }
                            ?>
                            <input type="submit" class="btn btn-info" style="margin-top: 5px;" id="btn-checkbox-group"
                                   value="Thêm vào thể loại vừa chọn">
                        </form>
                    </div>
                    <!--End show list group-->
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="js/tabs-post.js"></script>
    <script src="js/handling-group-link.js"></script>
    <script src="js/handling-group-photo.js"></script>
    <script src="js/handling-group-video.js"></script>
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