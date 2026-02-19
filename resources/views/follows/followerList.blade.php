<x-login-layout>
  <div class="follow-header">
    {{-- タイトル --}}
    <h2 class="follow-title">フォロワーリスト</h2>

    {{-- アイコン一覧を表示するエリア --}}
    <div class="follow-icon-list">
      @foreach($followerList as $user)
        <a href="{{ route('profile.other', ['id' => $user->id]) }}">
          <img src="{{ asset('images/' . $user->icon_image) }}" class="user-icon" alt="{{ $user->username }}">
        </a>
      @endforeach
    </div>
  </div>

  <hr class="search-separator">

  {{-- 投稿一覧エリア --}}
  <div class="post-list">
    @foreach($posts as $post)
      <div class="post-item">
        {{-- ユーザーアイコン --}}
        <div class="post-item-icon">
          <a href="{{ route('profile.other', ['id' => $post->user->id]) }}">
            <img src="{{ asset('images/' . $post->user->icon_image) }}" class="user-icon" alt="icon">
          </a>
        </div>

        <div class="post-item-content">
          <div class="post-header">
            {{-- ユーザー名 --}}
            <a href="{{ route('profile.other', ['id' => $post->user->id]) }}" class="post-user-name">
              {{ $post->user->username }}
            </a>
            {{-- 投稿日時 --}}
            <span class="post-date">{{ $post->created_at->format('Y-m-d H:i') }}</span>
          </div>
          {{-- 投稿内容 --}}
          <div class="post-body">
            {!! nl2br(e($post->post)) !!}
          </div>
        </div>
      </div>
    @endforeach
  </div>
</x-login-layout>