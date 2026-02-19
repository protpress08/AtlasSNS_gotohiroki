<x-login-layout>
  <div class="follow-header">
    <h2 class="follow-title">フォローリスト</h2>
    <div class="follow-icon-list">
      @foreach($followList as $user)
        {{-- アイコン一覧のリンク --}}
        <a href="{{ route('profile.other', ['id' => $user->id]) }}">
          <img src="{{ asset('images/' . $user->icon_image) }}" class="user-icon" alt="{{ $user->username }}">
        </a>
      @endforeach
    </div>
  </div>

  <hr class="search-separator">

  <div class="post-list">
    @foreach($posts as $post)
      <div class="post-item">
        <div class="post-item-icon">
          {{-- 投稿一覧のアイコンリンク --}}
          <a href="{{ route('profile.other', ['id' => $post->user->id]) }}">
            <img src="{{ asset('images/' . $post->user->icon_image) }}" class="user-icon" alt="icon">
          </a>
        </div>
        
        <div class="post-item-content">
          <div class="post-header">
            {{-- 名前をクリックしても飛べるようにすると親切です --}}
            <a href="{{ route('profile.other', ['id' => $post->user->id]) }}" class="post-user-name">
              {{ $post->user->username }}
            </a>
            <span class="post-date">{{ $post->created_at->format('Y-m-d H:i') }}</span>
          </div>
          <div class="post-body">
            {!! nl2br(e($post->post)) !!}
          </div>
        </div>
      </div>
    @endforeach
  </div>
</x-login-layout>