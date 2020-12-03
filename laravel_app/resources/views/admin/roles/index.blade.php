@extends('layouts.master')

@section('title', '役割一覧')

@section('content')
@include('partials.message')
    <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">役割</th>
            <th scope="col">作成日時</th>
            <th scope="col">アクション</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr class="table-light">
                    <th scope="row">{{ $role->name }}</th>
                    <td>{{ $role->created_at }}</td>
                    <td>
                        <div class="row">
                            <a href="#" class="btn btn-secondary">編集</a>&nbsp;
                            <form action="#" method="post">
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
@endsection
