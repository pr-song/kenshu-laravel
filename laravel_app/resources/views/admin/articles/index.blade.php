@extends('layouts.master')

@section('title', '記事リスト')

@section('content')
@include('partials.message')
    <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">タイトル</th>
            <th scope="col">作家</th>
            <th scope="col">作成日時</th>
            <th scope="col">アクション</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($articles as $article)
                <tr class="table-light">
                    <th scope="row"><a href="{{ route('articles.show', $article->slug) }}">{{ mb_substr($article->title, 0, 20) }}...</a></th>
                    <td>{{ $article->user->name }}</td>
                    <td>{{ $article->created_at }}</td>
                    <td>
                        <div class="row">
                            <a href="{{ route('articles.edit', $article->slug) }}" class="btn btn-secondary">編集</a>&nbsp;
                            <form action="{{ route('articles.destroy', $article->slug) }}" method="post">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger">削除</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $articles->links('vendor.pagination.bootstrap-4') }}
@endsection
