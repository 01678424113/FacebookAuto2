@extends('layout')
@section('content')
    <div class="col-md-12 ">
        <div class="content-right post-page">
            <div class="row alert alert-success">
                <!--Show list page-->
                <div class="col-md-6 mt-5 mb-5">
                    <h3>Danh sách các page của mình</h3>
                    <hr>
                    <form action="{{route('getPostPage')}}" method="post">
                        {{csrf_field()}}
                        <?php
                        $fb = new Facebook\Facebook([
                            'app_id' => env('FACEBOOK_APP_ID_ANDROID'),
                            'app_secret' => env('FACEBOOK_APP_SECRET_ANDROID'),
                            'default_graph_version' => env('FACEBOOK_API_VERSION'),
                        ]);
                        if ((Session::has('accessToken_user'))) {
                            $res = $fb->get('/me/accounts', Session::get('accessToken_user'));
                            $res = $res->getDecodedBody();
                            $checked = "";

                            foreach ($res['data'] as $page) {
                                if (isset($_POST['checkbox-page'])) {
                                    foreach ($_POST['checkbox-page'] as $value) {
                                        if ($value == $page['id']) {
                                            $checked = "checked";
                                            break;
                                        } else {
                                            $checked = "";
                                        }
                                    }
                                } else if (Session::get('page_ids')) {
                                    foreach (Session::get('page_ids') as $page_id) {
                                        if ($page_id == $page['id']) {
                                            $checked = "checked";
                                            break;
                                        } else {
                                            $checked = "";
                                        }
                                    }
                                }
                                echo " <div class='checkbox'>
                                    <label><input type='checkbox' name='checkbox-page[]' value='" . $page['id'] . "' " . $checked . ">" . $page['name'] . " - " . $page['id'] . "</label>
                                   </div>";
                            }
                        }
                        ?>
                        <input type="submit" class="btn btn-info" style="margin-top: 5px;" id="btn-checkbox-page"
                               value="Chọn page">
                    </form>
                </div>
                <!--End show list page-->
                {{--Thông báo--}}
                <div class="col-md-6">
                    <h3>Thông báo | <span id="timer">0</span> giây</h3>
                    <hr>
                    <div id="response" class="" style="height:auto;padding: 10px">
                    </div>
                </div>
            {{--End thông báo--}}
            <!-- Lay access token-->
                <form action="{{route('getAccessTokenPage')}}" method="post">
                    {{csrf_field()}}
                    <textarea hidden name="page_ids" id="page_ids" style="width: 500px;height: 200px;"
                              placeholder="Nhập id các page">
                            <?php
                        if (isset($_POST['checkbox-page'])) {
                            foreach ($_POST['checkbox-page'] as $value) {
                                echo trim($value) . ";";
                            }
                        } else if (Session::get('page_ids')) {
                            foreach (Session::get('page_ids') as $page_id) {
                                echo trim($page_id) . ";";
                            }
                        }
                        ?>
                        </textarea><br>
                </form>
                <!--End lay access token-->
            </div>
            <div class="row">
                <div class="col-md-12 col-no-padding">
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
                                                    <h3>Đăng link lên page đã chọn</h3>
                                                    <hr>
                                                    <textarea name="access_token" id="access_token_page"
                                                              style="width: 100%;height: 200px;" hidden>
                                                    @if(Session::has('accessToken_user'))
                                                            {{trim(Session::get('accessToken_user'))}}
                                                        @endif
                                                    </textarea><br>
                                                    <div class="form-group">
                                                        <label for="url-link">Link :</label>
                                                        <input type="url" class="form-control" name="url-link"
                                                               id="url-link">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="message-link">Message :</label>
                                                        <input type="url" class="form-control" name="message-link"
                                                               id="message-link">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="time-link">Tự đăng sau :</label>
                                                        <input type="number" class="form-control" name="time-link"
                                                               id="time-link">
                                                    </div>

                                                    <input type="button" value="Đăng bài" class="btn btn-info"
                                                           onclick="StartPostPageLink()">
                                                    <a class="btn btn-danger" href={{route('reset')}}>Reset</a>
                                                    <hr>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="form-photo">
                                            <div class="row">
                                                <div class="col-md-8 col-md-offset-2">
                                                    <div>
                                                        <h3>Đăng ảnh lên page đã chọn</h3>
                                                        <hr>
                                                        <form enctype="multipart/form-data" method="post">
                                                            {{csrf_field()}}
                                                            <div class="form-group">
                                                                <label for="message-photo">Message :</label>
                                                                <input type="text" class="form-control"
                                                                       name="message-photo"
                                                                       id="message-photo">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="url-photo">URL ảnh :</label>
                                                                <input type="url" class="form-control" name="url-photo"
                                                                       id="url-photo">
                                                            </div>
                                                            <textarea hidden name="access_token_user"
                                                                      style="width: 500px;height: 200px;"
                                                                      id="access_token_user"><?php if (Session::has('accessToken_user')) {
                                                                    echo Session::get('accessToken_user');
                                                                }?></textarea>
                                                            <br>

                                                            <div class="form-group">
                                                                <label for="time-photo">Tự đăng sau :</label>
                                                                <input type="number" class="form-control"
                                                                       name="time-photo"
                                                                       id="time-photo">
                                                            </div>
                                                            <input type="button" value="Đăng bài" class="btn btn-info"
                                                                   onclick="StartPostPagePhoto()">
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
                                                            <input type="text" class="form-control" name="message-video"
                                                                   id="message-video">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="url-video">Link :</label>
                                                            <input type="url" class="form-control" name="url-video"
                                                                   id="url-video">
                                                        </div>
                                                        <textarea hidden name="access_token_user"
                                                                  style="width: 500px;height: 200px;"
                                                                  id="access_token_user"><?php if (Session::has('accessToken_user')) {
                                                                echo Session::get('accessToken_user');
                                                            }?></textarea>
                                                        <br>
                                                        <div class="form-group">
                                                            <label for="time-video">Tự đăng sau :</label>
                                                            <input type="number" class="form-control" name="time-video"
                                                                   id="time-video">
                                                        </div>
                                                        <input type="button" value="Đăng bài" class="btn btn-info"
                                                               onclick="StartPostGroupVideo()">
                                                        <a class="btn btn-danger" href={{route('reset')}}>Reset</a>
                                                    </div>
                                                    <hr>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="settings">
                                            <h3 class="head text-center">Drop comments!</h3>
                                            <p class="narrow text-center">
                                                Lorem ipsum dolor sit amet, his ea mollis fabellas principes. Quo mazim
                                                facilis
                                                tincidunt ut, utinam saperet facilisi an vim.
                                            </p>

                                            <p class="text-center">
                                                <a href="" class="btn btn-success btn-outline-rounded green"> start
                                                    using
                                                    bootsnipp
                                                    <span style="margin-left:10px;"
                                                          class="glyphicon glyphicon-send"></span></a>
                                            </p>
                                        </div>
                                        <div class="tab-pane fade" id="doner">
                                            <div class="text-center">
                                                <i class="img-intro icon-checkmark-circle"></i>
                                            </div>
                                            <h3 class="head text-center">thanks for staying tuned! <span
                                                        style="color:#f48260;">♥</span> Bootstrap</h3>
                                            <p class="narrow text-center">
                                                Lorem ipsum dolor sit amet, his ea mollis fabellas principes. Quo mazim
                                                facilis
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
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="js/handling-page-link.js"></script>
    <script src="js/handling-page-photo.js"></script>
@endsection