@extends('layouts.master')

@section('title', 'タグリスト')

@section('content')
@include('partials.message')
    <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">タグ名</th>
            <th scope="col">作成日時</th>
            <th scope="col">アクション</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($tags as $tag)
                <tr class="table-light">
                    <th scope="row"><a href="#">{{ $tag->name }}</a></th>
                    <td>{{ $tag->created_at }}</td>
                    <td>
                        <div class="row">
                            <a href="#" class="btn btn-secondary">編集</a>&nbsp;
                            <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="post">
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
    {{ $tags->links('vendor.pagination.bootstrap-4') }}
@endsection
