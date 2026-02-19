<x-login-layout>
  <div class="search-form-container">
    {!! Form::open(['url' => '/search', 'method' => 'GET', 'class' => 'search-form']) !!}
      @csrf
      {!! Form::text('keyword', $keyword ?? null, ['class' => 'search-input', 'placeholder' => 'ユーザー名']) !!}
      <button type="submit" class="search-btn-img">
        <img src="{{ asset('images/search.png') }}" alt="検索">
      </button>

      @if(!empty($keyword))
        <p class="search-word-display">検索ワード：{{ $keyword }}</p>
      @endif
    {!! Form::close() !!}
  </div>

  <hr class="search-separator">

  {{-- ユーザー一覧表示エリア --}}
  <div class="user-list-wrapper">
    @foreach ($users as $user)
      <div class="user-item-flex">
        {{-- 左側：アイコンとユーザー名 --}}
        <div class="user-info-side">
          <img src="{{ asset('images/' . $user->icon_image) }}" class="user-icon" alt="icon">
          <span class="user-name">{{ $user->username }}</span>
        </div>

        {{-- 右側：ボタン --}}
        <div class="user-action-side">
          @if (Auth::user()->isFollowing($user->id))
            <a href="/user/{{ $user->id }}/unfollow" class="btn btn-danger search-btn-size">フォロー解除</a>
          @else
            <a href="/user/{{ $user->id }}/follow" class="btn btn-primary search-btn-size">フォローする</a>
          @endif
        </div>
      </div>
    @endforeach
  </div>
</x-login-layout>