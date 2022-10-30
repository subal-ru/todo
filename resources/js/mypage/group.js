const $doc = document;

export function groupSettingFunc() {
    setClickEvent()
    setChangeEvent();
}

// クリックイベントまとめたもの
function setClickEvent() {
    // メンバーリスト関係
    const $mainRight = $doc.getElementsByClassName('mypage-main-right')[0];
    const $member = $mainRight.getElementsByClassName('member')[0];
    const $add = $member.getElementsByClassName('add')[0];
    const $botton = $add.getElementsByClassName('botton')[0];
    const $submit = $member.getElementsByClassName('submit')[0];


    $botton.addEventListener('click', open_addForm );
    $submit.addEventListener('click', (ele) => addMember_ajax(ele));
    
}

function setChangeEvent() {
    // グループセレクター
    const $mainRight = $doc.getElementsByClassName('mypage-main-right')[0];
    const $selector = $mainRight.getElementsByClassName('group-selector')[0];
    let $formSelector;
    if ($selector) {
        $formSelector = $selector.getElementsByClassName('form-selector')[0];
        const $select = $formSelector.getElementsByClassName('select')[0];
        $select.addEventListener('change', (ele) => send_formSelector(ele));
    }

}

// フォームの出現と非表示
function open_addForm() {

    const $addForm = $doc.getElementsByClassName('mypage-main-right')[0].getElementsByClassName('member')[0].getElementsByClassName('add')[0].getElementsByClassName('addForm')[0];

    if ($addForm.classList.contains('active')) {
        $addForm.classList.remove('active');
        $addForm.style = 'pointer-events: none;'
        
    } else {
        $addForm.classList.add('active');
        $addForm.style = 'pointer-events: all;';

    }


}

// ajaxでの非同期通信実装 fetchを次は試す
function addMember_ajax(ele) {

    const $addForm = $doc.getElementsByClassName('mypage-main-right')[0].getElementsByClassName('member')[0].getElementsByClassName('add')[0].getElementsByClassName('addForm')[0];
    const $request = new XMLHttpRequest();
    const $jsondata = {
        'name' : $addForm.getElementsByClassName('name')[0].value,
        'groupid' : $addForm.getElementsByClassName('groupid')[0].value,
    };

    $request.open('POST', location.origin+location.pathname+'/addMemberCheck', true); //GETではうまくデータを送れなかった(別のやり方がある？)
    $request.setRequestHeader('X-CSRF-Token', $doc.getElementsByName('csrf-token').item(0).content); //必須
    $request.setRequestHeader('Content-Type', 'application/json; charset=utf-8'); //必須
    $request.responseType = 'json'; //必須
    $request.send(JSON.stringify($jsondata)); //JSON.stringfyは必須

    $request.onload = function() {
        if ($request.status !== 200) {
            return false;
        }
        const $response = $request.response;
        const $message = {
            'success': $response['success'],
            'error': $response['name'],
        }
        
        // メッセージの表示
        if ($message['success']) {
            $addForm.getElementsByClassName('success-message')[0].innerHTML = $message['success'];
            $addForm.getElementsByClassName('error-message')[0].innerHTML = '';
            $addForm.getElementsByClassName('name')[0].value = '';
        }
        if ($message['error']) {
            $addForm.getElementsByClassName('success-message')[0].innerHTML = '';
            $addForm.getElementsByClassName('error-message')[0].innerHTML = $message['error'];
            $addForm.getElementsByClassName('name')[0].value = '';            
        }
    }
}

function send_formSelector(ele) {
    // ele.target.parentElement.action = location.href + '?groupid=' + ele.target.value;
    ele.target.parentElement.submit();
}