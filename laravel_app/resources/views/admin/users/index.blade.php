@extends('layouts.master')

@section('title', 'ユーザーリスト')

@section('content')
@include('partials.message')
    <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">タイトル</th>
            <th scope="col">メールアドレス</th>
            <th scope="col">役割</th>
            <th scope="col">アクション</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="table-light">
                    <th scope="row"><a href="#">{{ $user->name }}</a></th>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach ($user->roles as $role)
                        <span class="badge badge-info">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <div class="row">
                            <a href="{{ route('admin.users.assign_role', $user->id) }}" class="btn btn-secondary">オーソライズ</a>&nbsp;
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="post">
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
    {{-- {{ $articles->links('vendor.pagination.bootstrap-4') }} --}}
@endsection
