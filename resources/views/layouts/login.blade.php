<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <!--IEブラウザ対策-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="ページの内容を表す文章" />
  <title></title>
  <link rel="stylesheet" href="{{ asset('css/reset.css') }} ">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }} ">
  <!--スマホ,タブレット対応-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Scripts -->
  <!--サイトのアイコン指定-->
  <link rel="icon" href="画像URL" sizes="16x16" type="image/png" />
  <link rel="icon" href="画像URL" sizes="32x32" type="image/png" />
  <link rel="icon" href="画像URL" sizes="48x48" type="image/png" />
  <link rel="icon" href="画像URL" sizes="62x62" type="image/png" />
  <!--iphoneのアプリアイコン指定-->
  <link rel="apple-touch-icon-precomposed" href="画像のURL" />
  <!--Bootstrapの導入-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!--OGPタグ/twitterカード-->
   @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
  <header>
    @include('layouts.navigation')
  </header>
  <!-- Page Content -->
  <div id="row">
    <div id="container">
      {{ $slot }}
    </div>
    <div id="side-bar">
      <div id="confirm">
        <p>{{ Auth::user()->username }} さんの</p>
        <div class="side-content">
          <p>フォロー数</p>
          <p>{{ Auth::user()->follows()->count() }}人</p>
        </div>
        <div class="side-btn-container">
          <a href="{{ route('follow.list') }}" class="btn-blue">フォローリスト</a>
        </div>

        <div class="side-content">
          <p>フォロワー数</p>
          <p>{{ Auth::user()->followers()->count() }}人</p>
        </div>
        
        <div class="side-btn-container">
          <a href="{{ route('follower.list') }}" class="btn-blue">フォロワーリスト</a>
        </div>

      <div class="side-search-container">
        <a href="{{ route('user.search') }}" class="btn-blue search-btn">ユーザー検索</a>
      </div>

    </div>
  </div>
  <footer>
  </footer>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
