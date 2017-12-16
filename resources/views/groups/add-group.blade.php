@extends('layout')
@section('content')
    <div class="col-md-12">
        <div class="content-right">
            <h3 class="title-content-right">Thêm group</h3>
            <hr>
            <form class="form-horizontal" action="{{route('postAddGroup')}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="control-label col-sm-2" for="group_id">Id:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="group_id"  name="group_id" placeholder="Nhập id group">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="group_name">Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Nhập name group">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="id_category">Category:</label>
                    <div class="col-sm-10">
                        <select name="id_category" id="id_category" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Thêm</button>
                    </div>
                </div>
            </form>
        </div>
        @if(session('error'))
            <div class="alert alert-danger">
                <strong>{{session('error')}}</strong>
            </div>
        @endif
        @if(count($errors) >0)
            <div class="alert alert-danger">
                @foreach($errors->all() as $err)
                    <strong>{{$err}}</strong>
                @endforeach
            </div>
        @endif
    </div>
@endsection