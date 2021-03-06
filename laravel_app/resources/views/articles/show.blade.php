@extends('layouts.master')

@section('title', $article->title)

@section('content')
@include('partials.message')
<div class="content">
    <h5>{{ $article->title }}</h5>
    <p>{{ $article->content }}</p>
    @if (!empty($article->thumbnail))
        <img src="{!! asset('images/'.$article->thumbnail) !!}" class="d-block w-100" alt="{{ $article->slug }}"><br>
    @endif
    <ul class="img-list">
        @foreach ($article->images as $image)
            <li><img src="{!! asset('images/'.$image->path) !!}" class="img-list-item" alt="{{ $article->slug }}"></li><br>
        @endforeach
    </ul>
</div>
<div class="article-more">
@foreach ($article->tags as $tag)
    <span class="badge badge-pill badge-info">{{ $tag->name }}</span>
@endforeach
<p>作家: {{ $article->user->name }}</p>
</div>
@endsection