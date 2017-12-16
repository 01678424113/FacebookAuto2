@extends('layout')
@section('content')
        <div class="content-right show-page" style="height: 100%">
            <h3 class="title-content-right">Danh sách thể loại</h3>
            <hr>
            <table class="table-hover" style="width: 100%">
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Edit</td>
                    <td>Delete</td>
                </tr>
                @foreach($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td>
                            <button class="btn btn-info"><a href="{{route('getEditCategory',$category->id)}}">Edit</a></button>
                        </td>
                        <td>
                            <button class="btn btn-danger"><a href="{{route('deleteCategory',$category->id)}}">Delete</a></button>
                        </td>
                    </tr>
                @endforeach
            </table>
            <button class="btn btn-info btn-add"><a href="{{route('getAddCategory')}}">Thêm thể loại</a></button>
        </div>
        @if(session('message'))
            <div class="alert alert-success">
                <strong>{{session('message')}}</strong>
            </div>
        @endif
@endsection