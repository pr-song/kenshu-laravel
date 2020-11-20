@extends("layouts.master")

@section("title", "登録")

@section('content')
<div class="container col-md-6 col-md-offset-3">
    <div class="card mt-5">
        <div class="card-header ">
            <h5 class="float-left">新しいアカウント登録</h5>
            <div class="clearfix"></div>
        </div>
        <div class="card-body">
            <form method="post">
                @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
                @endforeach

                @csrf
                <div class="form-group">
                    <label for="name" class="col-lg-12 control-label">名前</label>
                    <div class="col-lg-12">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-lg-12 control-label">メールアドレス</label>
                    <div class="col-lg-12">
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="address" class="col-lg-12 control-label">アドレス</label>
                    <div class="col-lg-12">
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-lg-12 control-label">パスワード</label>
                    <div class="col-lg-12">
                        <input type="password" class="form-control" name="password">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-lg-12 control-label">パスワード確認</label>
                    <div class="col-lg-12">
                        <input type="password" class="form-control" name="password_confirmation">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <button type="reset" class="btn btn-danger">キャンセル</button>
                        <button type="submit" class="btn btn-info">登録する</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection