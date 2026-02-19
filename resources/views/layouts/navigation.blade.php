<div id="head">
    <h1 class="logo">
        <a href="{{ url('/top') }}">
            <img src="{{ asset('images/atlas.png') }}" alt="TOPへ">
        </a>
    </h1>

    <div x-data="{ open: false }" class="nav-user">
        <div class="nav-trigger" @click="open = !open">
            <span class="username">{{ Auth::user()->username }} さん</span>
            <span class="arrow" :class="{ 'open': open }"></span>
            <img src="{{ asset('images/icon1.png') }}" class="user-icon">
        </div>

        <ul
            x-show="open"
            x-cloak
            @click.outside="open = false"
            class="dropdown-menu"
        >
            <li class="{{ request()->is('home') || request()->is('top') ? 'active' : '' }}">
                <a href="{{ url('/home') }}">HOME</a>
            </li>
            
            <li class="{{ request()->is('profile') ? 'active' : '' }}">
                <a href="{{ route('profile') }}">プロフィール編集</a>
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit">ログアウト</button>
                </form>
            </li>
        </ul>
    </div>
</div>