<x-login-layout>
    {{-- 投稿フォームエリア --}}
    <div class="post-block">
        {!! Form::open(['url' => 'post/create']) !!}
        @csrf
        <div class="post-form-flex">
            {{-- ログインユーザーのアイコン --}}
            <div class="user-icon-area">
                <img src="{{ asset('images/' . Auth::user()->icon_image) }}" class="user-icon" alt="user-icon">
            </div>

            {{-- 入力エリア --}}
            <div class="input-area">
                {!! Form::textarea('newPost', null, [
                    'required',
                    'class' => 'post-textarea',
                    'placeholder' => '投稿内容を入力してください。',
                    'rows' => '3'
                ]) !!}
            </div>

            {{-- 送信ボタン --}}
            <div class="submit-area">
                <button type="submit" class="post-submit-btn">
                    <img src="{{ asset('images/post.png') }}" alt="送信">
                </button>
            </div>
        </div>

        @if ($errors->has('newPost'))
            <p class="error-message">{{ $errors->first('newPost') }}</p>
        @endif
        {!! Form::close() !!}
    </div>

    {{-- 投稿一覧表示エリア --}}
    <div class="post-list">
        @foreach ($posts as $post)
            <div class="post-item">
                {{-- 左側：ユーザーアイコン --}}
                <div class="post-item-icon">
                    <img src="{{ asset('images/' . $post->user->icon_image) }}" class="user-icon" alt="icon">
                </div>

                {{-- 中央：ユーザー名と投稿内容 --}}
                <div class="post-item-content">
                    <div class="post-header">
                        <span class="username">{{ $post->user->username }}</span>
                        <span class="created-at">{{ $post->created_at->format('Y-m-d H:i') }}</span>
                    </div>
                    <div class="post-body">
                        {!! nl2br(e($post->post)) !!}
                    </div>
                </div>

                {{-- 右下：アクションボタン（自分の投稿のみ） --}}
                @if(Auth::id() === $post->user_id)
                <div class="post-actions">
                    {{-- 編集ボタン --}}
                    <a href="" class="js-modal-open" post="{{ $post->post }}" post_id="{{ $post->id }}">
                        <img src="{{ asset('images/edit.png') }}" alt="編集">
                    </a>

                    {{-- 削除ボタン --}}
                    <a href="/post/{{ $post->id }}/delete" onclick="return confirm('この投稿を削除しますか？')" class="delete-link">
                      <img src="{{ asset('images/trash.png') }}" class="trash-icon default" alt="削除">
                      <img src="{{ asset('images/trash-h.png') }}" class="trash-icon hover" alt="削除">
                    </a>

                </div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- モーダル本体 --}}
    <div class="modal js-modal">
        <div class="modal__bg js-modal-close"></div>
        <div class="modal__content">
            <form action="{{ route('post.update') }}" method="POST">
                @csrf
                <textarea name="upPost" class="modal_post"></textarea>
                <input type="hidden" name="id" class="modal_id">
                <button type="submit" class="modal_update-btn">更新</button>
            </form>
            <a class="js-modal-close" href="">閉じる</a>
        </div>
    </div>
</x-login-layout>