@extends('layouts.master')

@section('title', 'ログイン')

@section('content')
<div class="container col-md-6 col-md-offset-3">
    <div class="card mt-5">
        <div class="card-header ">
            <h5 class="float-left">ログイン</h5>
            <div class="clearfix"></div>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('login') }}">
                @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
                @endforeach

                @csrf
                <div class="form-group">
                    <label for="email" class="col-lg-12 control-label">メールアドレス</label>
                    <div class="col-lg-12">
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-lg-12 control-label">パスワード</label>
                    <div class="col-lg-12">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    </div>
                </div>

                <fieldset class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('ログイン記録') }}
                        </label>
                    </div>
                </fieldset>

                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <button type="reset" class="btn btn-danger">キャンセル</button>
                        <button type="submit" class="btn btn-info">ログインする</button>
                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('パスワードを忘れましたか?') }}
                        </a>
                        @endif
                        <a class="btn btn-link" href="{{ route('register') }}">
                            {{ __('アカウント登録?') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection