{{-- mypage-changePassのhtml --}}

<div class="changePass @if($menu=='pass') display-block"@endif">
    <input type="hidden" name="userid" value="{{session('userid')}}" class="userid">
    <div class="changePass-item">
        <div class="changePass-item-left">現在のパスワード</div>
        <div class="changePass-item-right"><input type="password" name="password" class="password" autocomplete="new-password"></div><div class="error-message-password"></div>
    </div>
    <div class="changePass-item">
        <div class="changePass-item-left">新しいパスワード</div>
        <div class="changePass-item-right"><input type="password" name="newpassword" class="newpassword"></div><div class="error-message-newpassword"></div>
    </div>
    <div class="changePass-item">
        <div class="changePass-item-left">新しいパスワード（確認）</div>
        <div class="changePass-item-right"><input type="password" name="newpassword_confirmation" class="newpassword_confirmation"></div><div class="error-message-newpassword_confirmation"></div>
    </div>
    <input class="submit" type="submit" value="送信"><div class="success-message-submit"></div>
</div>
