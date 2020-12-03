@extends('layouts.master')

@section('title', '全ての記事')

@section('content')
    <div class="row">
        @foreach ($articles as $article)
            <div class="col-lg-4">
                <div class="bs-component">
                    <div class="card text-white bg-dark mb-3" style="min-height: 250px; max-width: 25rem;">
                        <div class="card-body">
                        <h6 class="card-title">{{ $article->title }}</h6>
                        <hr class="my-4">
                        <a href="{{ action('ArticlesController@show', $article->slug) }}" class="btn btn-info">詳細を見る</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $articles->links('vendor.pagination.bootstrap-4') }}
@endsection