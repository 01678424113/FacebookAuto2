@extends('layout')
@section('content')
        <div class="content-right show-group" style="height: 100%">
            <h3 class="title-content-right">Danh sách group</h3>
            <hr>
            <table class="table-hover" style="width: 100%">
                <tr>
                    <td>ID</td>
                    <td>Post ID</td>
                    <td>Người đăng</td>
                </tr>
                @foreach($posts as $post)
                    @if($post->users->id == Session::get('id_user'))
                    <tr>
                        <td>{{$post->id}}</td>
                        <td>{{$post->post_id}}</td>
                        <td>{{$post->users->name}}</td>
                    </tr>
                    @endif
                @endforeach
            </table>
            {{$posts->links()}}
            <button class="btn btn-info btn-add"><a href="{{route('getAddGroup')}}">Add group</a></button>
        </div>
        @if(session('message'))
            <div class="alert alert-success">
                <strong>{{session('message')}}</strong>
            </div>
        @endif
@endsection