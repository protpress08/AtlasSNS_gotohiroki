<x-logout-layout>
  <div class="login-box">
    <div id="clear">
      <p class="welcome-text">{{ session('username') }}さん</p>
      <p class="added-message">ようこそ！AtlasSNSへ！</p>
      
      <div class="added-info">
        <p>ユーザー登録が完了しました。</p>
        <p>早速ログインをしてみましょう。</p>
      </div>

      <div class="submit-container" style="text-align: center;">
        <a href="{{ route('login') }}" class="btn-red" style="text-decoration: none; display: inline-block;">
          ログイン画面へ
        </a>
      </div>
    </div>
  </div>
</x-logout-layout>