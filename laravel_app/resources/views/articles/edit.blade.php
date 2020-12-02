@extends('layouts.master')

@section('title', '記事の編集')

@section('content')
<div class="content">
    @include('partials.message')
    <form method="post" action="{{ route('articles.update', $article->slug) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <fieldset>
            <legend>記事の編集</legend>
            @include('partials.error')
            <div class="form-group">
                <label for="title">タイトル</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $article->title }}">
            </div>
            <div class="form-group">
                <label for="content">コンテンツ</label>
                <textarea class="form-control" id="content" rows="30" name="content">{{ $article->content }}</textarea>
            </div>
            <div class="form-group">
                <label for="tags">タグ</label>
                <select class="form-control" id="tags" name="tags[]" multiple>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}"  @if(in_array($tag->id, $selected_tags)) selected @endif>{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="thumbnail_image" id="thumbnail_image" value="{{ $article->thumbnail }}">
            <div class="form-group">
                <label for="file">イメージ</label>
                <input type="file" class="form-control-file" id="file" name="images[]" multiple>
                <small id="fileHelp" class="form-text text-muted">複数アプロード可能</small>
            </div>
            @if (!empty($article->thumbnail))
                <img src="{!! asset('images/'.$article->thumbnail) !!}" class="d-block w-100" alt="{{ $article->slug }}"><br>
            @endif
            <div id="imagePreview">
                <ul class="img-list">
                    @foreach ($article->images as $image)
                        <li><img src="{!! asset('images/'.$image->path) !!}" name="{{ $image->path }}" class="img-list-item" alt="{{ $article->slug }}"></li><br>
                    @endforeach
                </ul>
            </div>
            <button type="reset" class="btn btn-danger">キャンセル</button>
            <button type="submit" class="btn btn-primary">編集する</button>
        </fieldset>
    </form>
</div>
@endsection