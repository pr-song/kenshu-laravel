@extends('layouts.master')

@section('title', '役割の編集')

@section('content')
<div class="content">
    @include('partials.message')
    <form method="post" action="{{ route('admin.users.update_role', $user->id) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <fieldset>
            <legend>記事の編集</legend>
            @include('partials.error')
            <div class="form-group">
                <label for="name">名前</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" disabled>
            </div>
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" disabled>
            </div>
            <div class="form-group">
                <label for="address">住所</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}" disabled>
            </div>
            <div class="form-group">
                <label for="roles">役割</label>
                <select class="form-control" id="tags" name="roles[]" multiple>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}"  @if(in_array($role->name, $selected_roles)) selected @endif>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="reset" class="btn btn-danger">キャンセル</button>
            <button type="submit" class="btn btn-primary">変更する</button>
        </fieldset>
    </form>
</div>
@endsection