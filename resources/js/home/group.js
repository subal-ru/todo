import {showError} from '../parts/common.js';

export function groupSettingFunc(){
    setAddGroupEvent();
    setGroupSwitch();
}

// グループ作成ボタンのクリック
function setAddGroupEvent(){
    $('.group-add .group-add-send').click(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        })
        $.ajax({
            url: 'home/addGroup',
            type: 'post',
            dataType: 'json',
            data: {
                userid: $('.group-add  .modal-contents .userid')[0].value,
                name: $('.group-add .modal-contents .name')[0].value,
                color: $('.group-add .modal-contents .color')[0].value,
            }
        })

        .done((res) => {
            const error = {
                userid: res['userid'],
                name: res['name'],
                color: res['color'],
            }
            // エラーなし
            if(!error['userid'] && !error['name'] && !error['color']) {
                
                $('.group .successForm .userid')[0].value = $('.group-add .modal-contents .userid')[0].value;
                $('.group .successForm .name')[0].value = $('.group-add .modal-contents .name')[0].value;
                $('.group .successForm .color')[0].value = $('.group-add .modal-contents .color')[0].value;
                $('.group .successForm')[0].submit();
            }

            // エラ〜表示
            showError(error, 'group', 'name', '');

            return true;
        })

        .fail((err) => {
            console.log(err);
        })
    });
}

// グループの表示切り替え　//ajax実装をやめる
// function setGroupSwitch() {
//     $('.group-item').click((ele) => {
//         $.ajaxSetup({
//             headers: { 'X-CSRF-TOLEN' :  $('meta[name="csrf-token"]').attr('content') }
//         })
//         $.ajax({
//             url: 'home/groupToggle',
//             type: 'get',
//             dataType: 'json',
//             data : {
//                 groupid: ele.target.dataset.groupid,
//                 isVisible: ele.target.classList.contains('toggle-off'),
//             }
//         })
        
//         .done((res) => {

//         })
//         .fail((err) => {
//             console.log(err);
//         })
//     })
// }

function setGroupSwitch() {
    $(".group-item").click((ele) => {
        $(".group-List .groupid")[0].value = ele.target.dataset.groupid;
        $(".group-List .isVisible")[0].value = ele.target.classList.contains('toggle-off');
        $(".group-list form")[0].submit();
    })
}