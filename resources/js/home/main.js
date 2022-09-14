// (()=>{
    import {showModal} from '../parts/common.js';
    import {setStatusData} from '../parts/common.js';

    // グローバル定数...?（あまり良くはないけど見た目をスッキリさせる為）
    const $doc = document;

    // addボタンにイベントを追加
    export function setAddBottonEvent() {
        const $addElement = $doc.getElementsByClassName('add')[0];
        $addElement.addEventListener('click', () => showModal('modal add'));
    }

    // todoリストのアイテムへクリックイベントを追加
    export function setItemBottonEvent() {
        const $items = $doc.getElementsByClassName('item');
        for(let $i = 0; $i < $items.length; $i++) {
            $items[$i].addEventListener('click', ($clickElement) => {showModal('item-detail modal'); setStatusData($clickElement, 'item-detail modal')});
        }
    }
// })();