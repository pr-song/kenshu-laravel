<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="{{ route('home') }}">PR TIMES</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
    aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor02">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">ホーム
          <span class="sr-only">(current)</span>
        </a>
      </li>
      @if(Auth::check())
      <li class="nav-item active dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
          aria-expanded="false">{{ Auth::user()->name }}</a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="{{ route('articles.my_articles') }}">マイ記事</a>
          <a class="dropdown-item" href="{{ route('articles.create') }}">新記事作成</a>
          <div class="dropdown-divider"></div>
          <form action="{{ route('logout') }}" method="post">
            @csrf
            <input type="submit" class="dropdown-item" value="ログアウト">
          </form>
        </div>
      </li>
        @if (Auth::user()->hasRole('administrator'))
          <li class="nav-item active">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">アドミンダッシュボード</a>
          </li>
        @endif
      @else
      <li class="nav-item active">
        <a class="nav-link" href="{{ route('login') }}">ログイン</a>
      </li>
      @endif
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="キーワード検索">
      <button class="btn btn-primary my-2 my-sm-0" type="submit">検索</button>
    </form>
  </div>
</nav>