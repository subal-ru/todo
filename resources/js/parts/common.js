import { defaultsDeep } from "lodash";

// グローバル定数
const $doc = document;

/*****************************************************************************************************
*   関数
*****************************************************************************************************/

// 各モーダルへクリックイベントを追加
export function setModalCloseEvent() {
    const $modals = $doc.getElementsByClassName('modal');
    for(let $i = 0; $i < $modals.length; $i++) {
        $modals[$i].addEventListener('click', ($clickElement) => closeModal($clickElement));
    }
}

// モーダルの表示
export function showModal($classNames) {
    const $modalElement = document.getElementsByClassName($classNames)[0];
    $modalElement.classList.add('display-block');
}

// エラーメッセージの表示
export function showError(error, $Mainpro, $name, $showType) {

    if (error[$name]) {
        $("." + $Mainpro + " .error-message-" + $name)[0].innerHTML     = error[$name];
        $("." + $Mainpro + " .error-message-" + $name)[0].classList.add('error-message-type' + $showType);
    }
    else {
        $("." + $Mainpro + " .error-message-" + $name)[0].innerHTML = '';
        $("." + $Mainpro + " .error-message-" + $name)[0].classList.remove('error-message-type' + $showType);
    }
}

// モーダルに自身を閉じるクリックイベントを追加
function closeModal($ele) {
    // 念の為モーダルクラスを調べる
    if($ele.target.classList.contains('modal')) {
        $ele.target.classList.remove('display-block');
    }
}

// パスワードの表示切り替え・アイコンも合わせて切り替え
export function setClickEvent_togglePassword() {
    const $eye = $doc.getElementsByClassName('icon-eye');
    
    for(let i=0; i < $eye.length; i++) {
        const $on = $eye[i].getElementsByClassName('on');
        const $off = $eye[i].getElementsByClassName('off');
        $on[0].addEventListener('click', (ele) => togglePassword(ele));
        $off[0].addEventListener('click', (ele) => togglePassword(ele));
    }
}
// setClickEvent_togglePasswordのメイン部分-アイコンの切り替えとパスワードの表示と黒丸切り替え
function togglePassword(ele) {
    // テキストを表示・非表示
    if (ele.target.parentElement.previousElementSibling.getAttribute('type') == 'password') {
        ele.target.parentElement.previousElementSibling.setAttribute('type', 'text');
    } else {
        ele.target.parentElement.previousElementSibling.setAttribute('type', 'password');
    }
    // 目ん玉アイコンの切り替え
    for(let i=0; i < ele.target.parentElement.children.length; i++) {
        ele.target.parentElement.children[i].classList.toggle('display-block');
    }
}