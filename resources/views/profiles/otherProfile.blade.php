<x-login-layout>
    {{-- 相手のユーザー情報エリア --}}
    <div class="other-profile-container">
        <div class="other-profile-flex">
            {{-- 相手のアイコン --}}
            <div class="user-icon-area">
                <img src="{{ asset('images/' . $user->icon_image) }}" class="user-icon" alt="user-icon">
            </div>

            {{-- ユーザー詳細情報：ここを画像に合わせて修正 --}}
            <div class="profile-details">
                <div class="profile-row">
                    <span class="profile-label">ユーザー名</span>
                    <span class="profile-content">{{ $user->username }}</span>
                </div>
                <div class="profile-row">
                    <span class="profile-label">自己紹介</span>
                    <span class="profile-content">{{ $user->bio }}</span>
                </div>
            </div>

            {{-- フォローボタンエリア --}}
            <div class="profile-btn-area">
                @if (Auth::user()->isFollowing($user->id))
                    <a href="{{ route('unfollow', ['id' => $user->id]) }}" class="btn btn-danger search-btn-size">フォロー解除</a>
                @else
                    <a href="{{ route('follow', ['id' => $user->id]) }}" class="btn btn-primary search-btn-size">フォローする</a>
                @endif
            </div>
        </div>
    </div>

    {{-- 相手の投稿一覧エリア --}}
    <div class="post-list">
        @foreach ($posts as $post)
            <div class="post-item">
                <div class="post-item-icon">
                    <img src="{{ asset('images/' . $user->icon_image) }}" class="user-icon" alt="icon">
                </div>
                <div class="post-item-content">
                    <div class="post-header">
                        <span class="username">{{ $user->username }}</span>
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