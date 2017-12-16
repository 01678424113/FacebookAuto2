@extends('layout')
@section('content')
    <div class="col-md-12 ">
        <div class="content-right show-page">
            <h3 class="title-content-right">Danh sách page</h3>
            <hr>
            <table class="table-hover" style="width: 100%">
                <tr>
                    <td>ID</td>
                    <td>Id page</td>
                    <td>Name page</td>
                    <td>Category page</td>
                    <td></td>
                    <td></td>
                </tr>
                @foreach($pages as $page)
                    <tr>
                        <td>{{$page->id}}</td>
                        <td>{{$page->page_id}}</td>
                        <td>{{$page->page_name}}</td>
                        <td>{{$page->category->name}}</td>
                        <td>
                            <button class="btn btn-info"><a href="{{route('getEditPage',$page->id)}}">Edit</a></button>
                        </td>
                        <td>
                            <button class="btn btn-danger"><a href="{{route('deletePage',$page->id)}}">Delete</a></button>
                        </td>
                    </tr>
                @endforeach
            </table>
            <button class="btn btn-info btn-add"><a href="{{route('getAddPage')}}">Add page</a></button>
        </div>
        @if(session('message'))
            <div class="alert alert-success">
                <strong>{{session('message')}}</strong>
            </div>
        @endif
    </div>
@endsection