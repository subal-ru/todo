import { list } from "postcss";

const doc = document;

// mypageの関数呼び出し
export function MypageSettingFunc() {
    setClickEventToMypageMenu();
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