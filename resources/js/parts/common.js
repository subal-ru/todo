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

/*****************************************************************************************************
*   関数
*****************************************************************************************************/
// モーダルの表示
export function showModal($classNames) {
    const $modalElement = document.getElementsByClassName($classNames)[0];
    $modalElement.classList.add('display-block');
}

// クリックされたアイテムのデータをモーダルに設定
export function setStatusData($ele, $classNames) {
    const $itemElement = $ele.target;
    const $title = $itemElement.querySelector('[data-title]');
    const $message = $itemElement.querySelector('[data-message]');
    const $modal = $doc.getElementsByClassName($classNames)[0];
    $modal.getElementsByClassName('modal-title')[0].value = $title.innerHTML;
    $modal.getElementsByClassName('modal-message')[0].value = $message.innerHTML;
    $modal.getElementsByClassName('modal-status')[0].value = $itemElement.dataset.status;
    $modal.getElementsByClassName('modal-group')[0].value = $itemElement.dataset.groupid;
    $modal.getElementsByTagName('input')['id'].value = $itemElement.dataset.id;
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

// モーダルに自信を閉じるクリックイベントを追加
function closeModal($ele) {
    // 念の為モーダルクラスを調べる
    if($ele.target.classList.contains('modal')) {
        $ele.target.classList.remove('display-block');
    }
}
