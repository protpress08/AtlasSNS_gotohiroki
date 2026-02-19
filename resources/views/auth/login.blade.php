<x-logout-layout>


<div class="login-box">
  @if ($errors->any())
    <ul class="error">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif

  {!! Form::open(['route' => 'login', 'method' => 'post']) !!}
  @csrf

  <p class="welcome-text">AtlasSNSへようこそ</p>

  <div class="input-group">
    {{ Form::label('email', 'メールアドレス') }}
    {{ Form::email('email', old('email'), ['class' => 'input']) }}
  </div>

  <div class="input-group">
    {{ Form::label('password', 'パスワード') }}
    {{ Form::password('password', ['class' => 'input']) }}
  </div>

  <div class="submit-container">
    {{ Form::submit('ログイン', ['class' => 'btn-red']) }}
  </div>

  <p class="register-link"><a href="{{ route('register') }}">新規ユーザーの方はこちら</a></p>

  {!! Form::close() !!}
</div>

</x-logout-layout>