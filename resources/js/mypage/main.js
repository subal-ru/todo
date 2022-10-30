import { list } from "postcss"; //??記載した記憶なし
import {showError} from '../parts/common.js'

const doc = document;

// mypageの関数呼び出し
export function mainSettingFunc() {
    setChangePassEvent();
}

// パスワード変更ボタン押下
function setChangePassEvent() {

    $('.changePass .submit').click(function() {
        $.ajaxSetup( {
            headers : {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), //csrfを入れないと419エラーになる
            }
        })
        $.ajax({
            type: 'post',
            url: 'changePass',
            dataType: 'json',
            data: {
                userid: $('.changePass .userid')[0].value,
                password: $('.changePass .password')[0].value,
                newpassword: $('.changePass .newpassword')[0].value,
                newpassword_confirmation: $('.changePass .newpassword_confirmation')[0].value,
            }
        })

        .done((res) => {
            const error = {
                password: res['password'],
                newpassword: res['newpassword'],
                newpassword_confirmation: res['newpassword_confirmation'],
            }
            const message = {
                success : res['success'],
            }

            // エラーなし
            if(!error['password'] && !error['newpassword'] && !error['newpassword_confirmation']) {
                // 成功メッセージの表示
                $('.success-message-submit')[0].innerHTML = message['success'];
                $('.success-message-submit')[0].classList.add('success-message-type1');

                // エラーメッセージを空白でリセットする
                showError(error, 'changePass', 'password');
                showError(error, 'changePass', 'newpassword');
                showError(error, 'changePass', 'newpassword_confirmation');

                // 入力パラメーターの削除
                $('.changePass .password')[0].value = "";
                $('.changePass .newpassword')[0].value = "";
                $('.changePass .newpassword_confirmation')[0].value = "";
                return true;
            }

            // 空白で成功メッセージを削除する
            $('.success-message-submit')[0].innerHTML = "";
            $('.success-message-submit')[0].classList.add('success-message-type1');
            
            // エラー表示
            showError(error, 'changePass', 'password', '2');
            showError(error, 'changePass', 'newpassword', '2');
            showError(error, 'changePass', 'newpassword_confirmation', '2');

            return true;
        })

        .fail((error) => {
            console.log(error);
        })
    });
}