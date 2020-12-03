@extends('layouts.master')

@section('title', '新しいタグの作成')

@section('content')
<div class="content">
    @include('partials.message')
    <form method="post" action="{{ route('admin.tags.store') }}" enctype="multipart/form-data">
        @csrf
        <fieldset>
            <legend>新しいタグの作成</legend>
            @include('partials.error')
            <div class="form-group">
                <label for="name">タグ名</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <button type="reset" class="btn btn-danger">キャンセル</button>
            <button type="submit" class="btn btn-primary">作成する</button>
        </fieldset>
    </form>
</div>
@endsection