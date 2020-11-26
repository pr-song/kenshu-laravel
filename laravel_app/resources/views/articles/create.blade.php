@extends('layouts.master')

@section('title', '新記事の作成')

@section('content')
<div class="content">
    @include('partials.message')
    <form method="post" action="{{ route('articles.store') }}" enctype="multipart/form-data">
        @csrf
        <fieldset>
            <legend>新記事の作成</legend>
            @include('partials.error')
            <div class="form-group">
                <label for="title">タイトル</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="form-group">
                <label for="content">コンテンツ</label>
                <textarea class="form-control" id="content" rows="30" name="content"></textarea>
            </div>
            <div class="form-group">
                <label for="tags">タグ</label>
                <select class="form-control" id="tags" name="tags[]" multiple>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="thumbnail_image" id="thumbnail_image">
            <div class="form-group">
                <label for="file">イメージ</label>
                <input type="file" class="form-control-file" id="file" name="images[]" multiple>
                <small id="fileHelp" class="form-text text-muted">複数アプロード可能</small>
            </div>
            <div id="imagePreview"></div>
            <button type="reset" class="btn btn-danger">キャンセル</button>
            <button type="submit" class="btn btn-primary">作成する</button>
        </fieldset>
    </form>
</div>
@endsection