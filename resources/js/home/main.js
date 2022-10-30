// (()=>{
    import {showModal} from '../parts/common.js';

    export function mainSettingFunc() {
        setAddBottonEvent();
        setItemBottonEvent();
        setAddGroupBottonEvent();
    }

    const $doc = document;

    // addボタンにイベントを追加
    function setAddBottonEvent() {
        const $addElement = $doc.getElementsByClassName('add')[0];
        $addElement.addEventListener('click', () => showModal('modal add'));
    }

    // todoリストのアイテムへクリックイベントを追加
    function setItemBottonEvent() {
        const $items = $doc.getElementsByClassName('item');
        for(let $i = 0; $i < $items.length; $i++) {
            $items[$i].addEventListener('click', ($clickElement) => {showModal('item-detail modal'); setStatusData($clickElement, 'item-detail modal')});
        }
    }

    // group追加ボタン
    function setAddGroupBottonEvent() {
        $('.add-group-btn').click(function() {
            showModal('modal group-add');
        })
    }

    // クリックされたアイテムのデータをモーダルに設定
    function setStatusData($ele, $classNames) {
        const $itemElement = $ele.target;
        const $title = $itemElement.querySelector('[data-title]');
        const $message = $itemElement.querySelector('[data-message]');
        const $modal = $doc.getElementsByClassName($classNames)[0];
        $modal.getElementsByClassName('modal-title')[0].value = $title.innerHTML;
        $modal.getElementsByClassName('modal-message')[0].value = $message.innerHTML;
        $modal.getElementsByClassName('modal-status')[0].value = $itemElement.dataset.status;
        $modal.getElementsByClassName('modal-group')[0].value = $itemElement.dataset.groupid;
        $modal.getElementsByTagName('input')['id'].value = $itemElement.dataset.id;
        
        // 自分以外のアイテムなら送信ボタンを非表示にする
        $modal.getElementsByClassName('add-send-btn')[0].style.display = 'block';
        if ($itemElement.dataset.userid !== $itemElement.dataset.myid) {
            $modal.getElementsByClassName('add-send-btn')[0].style.display = 'none';
        }
    }
// })();