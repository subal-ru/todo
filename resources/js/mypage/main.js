import { list } from "postcss"; //??記載した記憶なし
import {showError} from '../parts/common.js'

const doc = document;

// mypageの関数呼び出し
export function MypageSettingFunc() {
    setClickEventToMypageMenu();
    setChangePassEvent();
}

// clickEventの追加
function setClickEventToMypageMenu() {

    const menuList = doc.getElementsByClassName('mypage-menu');
    const menus = menuList[0].children;
    
    for(let i=0; i < menus.length; i++) {
        menus[i].addEventListener('click', (ele) => changeDisplay(ele));
    }
}

// クリックされた項目に対する、表示すべき右側の切り替え
function changeDisplay(ele) {

    // クリックした項目を選択状態にすると共に他を非選択状態にする
    const leftList = doc.getElementsByClassName('mypage-main-left')[0];
    for(let i = 0; i < leftList.children[0].children.length; i++){
        leftList.children[0].children[i].classList.remove('isActive');
    }
    ele.target.classList.add('isActive');

    // 全ての右項目の非表示
    const rightList = doc.getElementsByClassName('mypage-main-right')[0];
    for(let i=0; i<rightList.children.length; i++){
        rightList.children[i].style.display = 'none';
    }
    // 対応する右項目の取得と表示
    const target = doc.getElementsByClassName(ele.target.dataset.menutag)[0];
    target.style.display = 'block';
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