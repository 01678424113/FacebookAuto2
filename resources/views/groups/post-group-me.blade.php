@extends('layout')
@section('content')
    <div class="col-md-12">
        <div class="content-right post-group">
            <div class="row alert alert-success">
                <div class="col-md-6">
                    <div class="content-test">
                        <h3>Chọn group thể loại :</h3>
                        <hr>
                        <form action="{{route('postPostGroupMe')}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <select class="form-control" id="categories">
                                    <option value="">Chọn thể loại</option>
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
                        <label for="group_ids">ID group :</label>
                        <textarea name="group_ids" class="form-control" id="group_ids"
                                  style="width: 500px;height: 200px;"
                                  placeholder="Nhập id các group"><?php if (isset($_POST['checkbox-group'])) {
                                foreach ($_POST['checkbox-group'] as $value) {
                                    echo trim($value) . ";";
                                }
                            } ?></textarea>
                    </div>
                    <!--End lay id group-->
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-post">
            <section style="background:#efefe9;">

                <div class="row">
                    <div class="board">
                        <!-- <h2>Welcome to IGHALO!<sup>™</sup></h2>-->
                        <div class="board-inner">
                            <ul class="nav nav-tabs" id="myTab">
                                <div class="liner"></div>
                                <li class="active">
                                    <a href="#form-link" data-toggle="tab" title="welcome">
                      <span class="round-tabs one">
                              <i class="fa fa-link" aria-hidden="true"></i>
                      </span>
                                    </a></li>

                                <li><a href="#form-photo" data-toggle="tab" title="profile">
                     <span class="round-tabs two">
                         <i class="fa fa-picture-o" aria-hidden="true"></i>
                     </span>
                                    </a>
                                </li>

                                <li><a href="#form-video" data-toggle="tab" title="bootsnipp goodies">
                     <span class="round-tabs three">
                          <i class="fa fa-video-camera" aria-hidden="true"></i>
                     </span> </a>
                                </li>
                                <li><a href="#settings" data-toggle="tab" title="blah blah">
                         <span class="round-tabs four">
                              <i class="glyphicon glyphicon-comment"></i>
                         </span>
                                    </a></li>

                                <li><a href="#doner" data-toggle="tab" title="completed">
                         <span class="round-tabs five">
                              <i class="glyphicon glyphicon-ok"></i>
                         </span> </a>
                                </li>

                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="form-link">
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div>
                                            <h3>Đăng link lên group đã chọn</h3>
                                            <hr>
                                            <div class="form-group">
                                                <label for="message-link">Message :</label>
                                                <input type="text" class="form-control" name="message-link" id="message-link">
                                            </div>
                                            <div class="form-group">
                                                <label for="url-link">Link :</label>
                                                <input type="url" class="form-control" name="url-link" id="url-link">
                                            </div>
                                            <textarea hidden name="access_token_user" style="width: 500px;height: 200px;"
                                                      id="access_token_user"><?php if (Session::has('accessToken_user')) {
                                                    echo Session::get('accessToken_user');
                                                }?></textarea>
                                            <br>
                                            <div class="form-group">
                                                <label for="time-link">Tự đăng sau (s) :</label>
                                                <input type="number" class="form-control" name="time-link" id="time-link">
                                            </div>
                                            <input type="button" value="Đăng bài" class="btn btn-info" onclick="StartPostGroupLink()">
                                            <a class="btn btn-danger" href={{route('reset')}}>Reset</a>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="form-photo">
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div>
                                            <h3>Đăng ảnh lên group đã chọn</h3>
                                            <hr>
                                            <form enctype="multipart/form-data" method="post">
                                                {{csrf_field()}}
                                                <div class="form-group">
                                                    <label for="message-photo">Message :</label>
                                                    <input type="text" class="form-control" name="message-photo" id="message-photo">
                                                </div>
                                                <div class="form-group">
                                                    <label for="url-photo">URL ảnh :</label>
                                                    <input type="url" class="form-control" name="url-photo" id="url-photo">
                                                </div>
                                                <textarea hidden name="access_token_user" style="width: 500px;height: 200px;"
                                                          id="access_token_user"><?php if (Session::has('accessToken_user')) {
                                                        echo Session::get('accessToken_user');
                                                    }?></textarea>
                                                <br>

                                                <div class="form-group">
                                                    <label for="time-photo">Tự đăng sau :</label>
                                                    <input type="number" class="form-control" name="time-photo" id="time-photo">
                                                </div>
                                                <input type="button" value="Đăng bài" class="btn btn-info" onclick="StartPostGroupPhoto()">
                                                <a class="btn btn-danger" href={{route('reset')}}>Reset</a>
                                            </form>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="form-video">
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div>
                                            <h3>Đăng video lên group đã chọn</h3>
                                            <hr>
                                            <div class="form-group">
                                                <label for="message-video">Message :</label>
                                                <input type="text" class="form-control" name="message-video" id="message-video">
                                            </div>
                                            <div class="form-group">
                                                <label for="url-video">Link :</label>
                                                <input type="url" class="form-control" name="url-video" id="url-video">
                                            </div>
                                            <textarea hidden name="access_token_user" style="width: 500px;height: 200px;"
                                                      id="access_token_user"><?php if (Session::has('accessToken_user')) {
                                                    echo Session::get('accessToken_user');
                                                }?></textarea>
                                            <br>
                                            <div class="form-group">
                                                <label for="time-video">Tự đăng sau :</label>
                                                <input type="number" class="form-control" name="time-video" id="time-video">
                                            </div>
                                            <input type="button" value="Đăng bài" class="btn btn-info" onclick="StartPostGroupVideo()">
                                            <a class="btn btn-danger" href={{route('reset')}}>Reset</a>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="settings">
                                <h3 class="head text-center">Drop comments!</h3>
                                <p class="narrow text-center">
                                    Lorem ipsum dolor sit amet, his ea mollis fabellas principes. Quo mazim facilis
                                    tincidunt ut, utinam saperet facilisi an vim.
                                </p>

                                <p class="text-center">
                                    <a href="" class="btn btn-success btn-outline-rounded green"> start using bootsnipp
                                        <span style="margin-left:10px;" class="glyphicon glyphicon-send"></span></a>
                                </p>
                            </div>
                            <div class="tab-pane fade" id="doner">
                                <div class="text-center">
                                    <i class="img-intro icon-checkmark-circle"></i>
                                </div>
                                <h3 class="head text-center">thanks for staying tuned! <span
                                            style="color:#f48260;">♥</span> Bootstrap</h3>
                                <p class="narrow text-center">
                                    Lorem ipsum dolor sit amet, his ea mollis fabellas principes. Quo mazim facilis
                                    tincidunt ut, utinam saperet facilisi an vim.
                                </p>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                </div>

            </section>
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
                $.get("user/acction/ajax/group/" + id_category, function (data) {
                    $('#groups').html(data);
                });
            });
        });
    </script>
@endsection