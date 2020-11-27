@extends("layouts.master")

@section("title", "ホーム")

@section("content")
    @include('partials.message')
    <div class="row">
        @foreach ($articles as $article)
            <div class="col-lg-4">
                <div class="bs-component">
                    <div class="card text-white bg-dark mb-5" style="min-height: 250px; width: 18rem;">
                        <div class="card-body">
                        <h6 class="card-title">{{ $article->title }}</h6>
                        <p>{{ $article->user->name }}</p>
                        <hr class="my-4">
                        <a href="{{ action('ArticlesController@show', $article->slug) }}" class="btn btn-info">詳細を見る</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection