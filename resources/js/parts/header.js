import {showModal} from './common.js';
import {showError} from './common.js';
// 定数
const $doc = document;

export function headerSettingFunc() {
    setLoginBottonEvent();
    setRegisterBottonEvent();
    setLoginUserBottonEvent();

    // ajax
    setLoginSendBottonEvent();
    setRegisterSendBottonEvent();
}

// loginボタンのクリックイベントを追加
function setLoginBottonEvent() {
    const $login = $doc.getElementsByClassName('login')[0];
    if ($login) {
        $login.addEventListener('click', () => showModal('modal login'));
        return true;
    }
    return false;
}

// 登録ボタンのクリックイベントを追加
function setRegisterBottonEvent() {
    const $register = $doc.getElementsByClassName('register')[0];
    if ($register) {
        $register.addEventListener('click', () => showModal('modal register'));
        return true;
    }
    return false;
}

// へっだー部分 マイメニュー表示用
function setLoginUserBottonEvent() {
    const $loginUser = $doc.getElementsByClassName('header-loginUser')[0];
    if($loginUser) {
        $loginUser.addEventListener('click', (ele) => {showLoginUserMenu(ele)});
        return true;
    }
    return false;
}

function showLoginUserMenu(ele) {
    const $menu = ele.target.children[0];
    // if($menu.style.display == 'none' || $menu.style.display == '') {
        // $menu.classList.add('active');
        // $menu.style.display = 'block';
    // } else {
        // $menu.classList.remove('active');
        // $menu.style.display = 'none';
    // }
    ele.target.children[0].classList.toggle('active');
}

// ログインボタン押下後の処理
function setLoginSendBottonEvent() {
    $('.send-btn.login').click(function() {

        $.ajaxSetup({
            headers : {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), //csrfを入れないと419エラーになる
            },
        })
        $.ajax({
            type: 'post',
            url: 'loginCheck',
            dataType: 'json',
            data: {
                email: $('.modal.login .email')[0].value,
                password: $('.modal.login .password')[0].value,
            }
        })
        
        // 通信成功時、controllerのreturnの値がresに返る
        .done((res) => {

            // 何を取得したかわかるようにオブジェクトにしておく
            const error = {
                email: res['email'],
                password: res['password'],
                loginError: res['loginError'],
            }

            // エラーがなければログイン処理を行う
            if(!error['email'] && !error['password'] && !error['loginError']) {
                loginSuccess();
                return true;
            }
            // email,passwordのエラーメッセージの表示
            showError(error, 'login', 'email', '1');
            showError(error, "login", "password", '1');
            showError(error, 'login', 'loginError', '1');
            
            return true;
            
        })
        
        .fail((error) => {
            console.log(error);
        })
    })
}

function loginSuccess() {

    $("#form-loginSuccess .email").val($('.modal.login .email')[0].value);
    $("#form-loginSuccess .password").val($('.modal.login .password')[0].value);

    $("#form-loginSuccess").submit();
    return true;
}

// 登録ボタン押下後の処理
function setRegisterSendBottonEvent() {

    $('.send-btn.register').click(function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), //csrfを入れないと419エラーになる
            },
        })

        $.ajax({
            type: 'post',
            url: 'registerCheck', //laravelではパスの末尾に/をつけてはいけない405エラーになる（routeエラー？）
            dataType: 'json',
            data: {
                name: $('.modal.register .name')[0].value,
                email: $('.modal.register .email')[0].value,
                password: $('.modal.register .password')[0].value,
            }
        })

        // 通信成功時、controllerのreturnの値がresに返る
        .done((res) => {
            // 何を取得したのかわかるようにオブジェクトにしておく
            const error = {
                name : res['name'],
                email : res['email'],
                password : res['password'],
            }

            // エラーがないならアカウント登録へ
            if(!error['name'] && !error['email'] && !error['password']) {
                registerSuccess();
                return true;
            }

            // name,email,passwordのエラーメッセージの表示
            showError(error, 'register', 'name', '1');
            showError(error, 'register', 'email', '1');
            showError(error, 'register', 'password', '1');

            return true;
        })

        .fail((error) => {
            console.log(error);
        })
    })
}

// アカウント登録をポストする
function registerSuccess()  {

    // window.location.href = 'registerSuccess'; //GET処理なのでNG,他の方法考える
    
    // 事前用意したフォームにデータを格納しサブミット
    $("#form-registerSuccess .name").val($('.modal.register .name')[0].value);
    $("#form-registerSuccess .email").val($('.modal.register .email')[0].value);
    $("#form-registerSuccess .password").val($('.modal.register .password')[0].value);
    
    $("#form-registerSuccess").submit();
    return true;
}