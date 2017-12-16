@extends('layout')
@section('content')
    <div class="col-md-12">
        <div class="content-right">
            <h3 class="title-content-right">Sửa page : {{$category->name}}</h3>
            <hr>
            <form class="form-horizontal" action="{{route('postEditCategory',$category->id)}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="control-label col-sm-2" for="category_name">Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="category_name" minlength="5" name="category_name" placeholder="Nhập name thể loại mới" value="{{$category->name}}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Sửa</button>
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