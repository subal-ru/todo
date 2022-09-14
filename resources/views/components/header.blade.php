<header class="header">
    <div class="header-contents-wrapper">
        <div class="header-contents">
            @if(!session('name'))
                <div><a class="register">登録</a></div>
                <div><a class="login">ログイン</a></div>
            @else
                <div class="header-loginUser">
                    {{-- {{ session('name') }} --}}
                    {{ session('email') }}
                    <div class="header-loginUser-Menu">
                        <div class="header-Home">
                            <form action="{{route('home')}}" method="GET">
                                @csrf
                                <input type="submit" value="ホーム" class="header-Home-botton">
                            </form>
                        </div>
                        <div class="header-Mypage">
                            <form action="{{ route('root') }}/mypage" method="GET">
                                @csrf
                                <input type="submit" value="マイページ" class="header-Mypage-botton">
                            </form>
                        </div>
                        <div class="header-Logout">
                            <form action="{{ route('root') }}/logout" method="GET">
                                @csrf
                                <input type="submit" value="ログアウト" class="header-Logout-botton">
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            <div class="modal login">
                <div class="modal-login-card">
                    {{-- <form action="{{route('root')}}/login" method="POST"> --}}
                        {{-- @csrf --}}
                        <div class="contents">
                            <p>ログイン</p>
                            <div>
                                <p>メールアドレス<p/>
                                <input type="text" name="email" class="email">
                                <div class="error-message-email"></div>
                                {{-- @error('email') <div class="contents-error">{{$message}}</div> @enderror --}}
                            </div>
                            <div>
                                <p>パスワード</p>
                                <input type="password" name="password" class="password">
                                <div class="error-message-password"></div>
                                {{-- @error('password') <div class="contents-error">{{$message}}</div> @enderror --}}
                            </div>
                            <input type="submit" value="ログイン" class="send-btn login">
                            <div class="error-message-loginError"></div>
                        </div>
                    {{-- </form> --}}
                </div>
            </div>
            <form action="loginSuccess" method="POST" style="display: hidden" id="form-loginSuccess">
                @csrf
                <input type="hidden" class="email" name="email">
                <input type="hidden" class="password" name="password">
            </form>
            <div class="modal register">
                <div class="modal-register-card">
                    {{-- <form action="{{route('root')}}/register" method="POST"> --}}
                        {{-- @csrf --}}
                        <div class="contents">
                            <p>登録</p>
                            <div>
                                <p>名前</p>
                                <input type="text" name="name" class="name">
                                <div class="error-message-name"></div>
                                {{-- @error('name') <div class="contents-error">{{$message}}</div> @enderror --}}
                            </div>
                            <div>
                                <p>メールアドレス</p>
                                <input type="text" name="email" class="email">
                                <div class="error-message-email"></div>
                                 {{-- @error('email') <div class="contents-error">{{$message}}</div> @enderror --}}
                            </div>
                            <div>
                                <p>パスワード</p>
                                <input type="password" name="password" class="password">
                                <div class="error-message-password"></div>
                                {{-- @error('password') <div class="contents-error">{{$message}}</div> @enderror --}}
                            </div>
                            <input type="submit" value="登録" class="send-btn register">
                        </div>
                    {{-- </form> --}}
                </div>
            </div>
            <form action="registerSuccess" method="POST" style="display: hidden" id="form-registerSuccess"> {{-- 登録成功時用のフォーム --}}
                @csrf
                <input type="hidden" name="name" class="name">
                <input type="hidden" name="email" class="email">
                <input type="hidden" name="password" class="password">
            </form>
        <div>
    </div>
</header>