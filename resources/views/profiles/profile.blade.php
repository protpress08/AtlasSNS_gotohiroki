<x-login-layout>
  <div class="profile-container">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
      </div>
    @endif

    {!! Form::open(['url' => 'profile/update', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'profile-form']) !!}
    @csrf

    <div class="profile-item">
      <div class="profile-icon-area">
        <img src="{{ asset('images/' . Auth::user()->icon_image) }}" class="user-icon">
      </div>

      <div class="profile-input-group">
        <div class="form-row">
          <label>ユーザー名</label>
          {!! Form::text('username', Auth::user()->username, ['class' => 'form-control']) !!}
        </div>
        <div class="form-row">
          <label>メールアドレス</label>
          {!! Form::email('email', Auth::user()->email, ['class' => 'form-control']) !!}
        </div>
        <div class="form-row">
          <label>パスワード</label>
          {!! Form::password('password', ['class' => 'form-control']) !!}
        </div>
        <div class="form-row">
          <label>パスワード確認</label>
          {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
        </div>
        <div class="form-row">
          <label>自己紹介</label>
          {!! Form::text('bio', Auth::user()->bio, ['class' => 'form-control']) !!}
        </div>
        <div class="form-row file-row">
          <label>アイコン画像</label>
          <div class="file-input-wrapper" id="icon_preview_area">
            <span id="placeholder_text" class="custom-file-btn">ファイルを選択</span>
            {!! Form::file('icon_image', ['id' => 'icon_image_input', 'accept' => 'image/*', 'style' => 'display:none;']) !!}
          </div>
        </div>
      </div>
    </div>

    <div class="profile-submit-area">
      <button type="submit" class="btn btn-danger update-btn">更新</button>
    </div>
    {!! Form::close() !!}
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('icon_image_input');
        const previewArea = document.getElementById('icon_preview_area');
        const placeholder = document.getElementById('placeholder_text');

        previewArea.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const oldImg = previewArea.querySelector('img');
                    if (oldImg) oldImg.remove();
                    placeholder.style.display = 'none';
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.className = 'preview-img'; // CSSでサイズ調整用
                    previewArea.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    });
  </script>
</x-login-layout>