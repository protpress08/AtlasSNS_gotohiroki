<x-logout-layout>

<div class="login-box">
    @if ($errors->any())
        <ul class="error" style="color: #ffcccc; margin-bottom: 15px; text-align: left; list-style: none;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    {!! Form::open(['route' => 'register.post', 'method' => 'post']) !!}
    @csrf

    <h2 class="welcome-text">新規ユーザー登録</h2>

    <div class="input-group">
        {{ Form::label('username', 'ユーザー名') }}
        {{ Form::text('username', old('username'), ['class' => 'input']) }}
    </div>

    <div class="input-group">
        {{ Form::label('email', 'メールアドレス') }}
        {{ Form::email('email', old('email'), ['class' => 'input']) }}
    </div>

    <div class="input-group">
        {{ Form::label('password', 'パスワード') }}
        {{ Form::password('password', ['class' => 'input']) }}
    </div>

    <div class="input-group">
        {{ Form::label('password_confirmation', 'パスワード確認') }}
        {{ Form::password('password_confirmation', ['class' => 'input']) }}
    </div>

    <div class="submit-container">
        {{ Form::submit('新規登録', ['class' => 'btn-red']) }}
    </div>

    <p class="register-link"><a href="{{ route('login') }}">ログイン画面に戻る</a></p>

    {!! Form::close() !!}
</div>

</x-logout-layout>