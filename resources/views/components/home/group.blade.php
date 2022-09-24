<div class="group-outer">
    <div class="group">
        <div class="add-group-btn"><p>+</p></div> 
        <div class="modal group-add">
            <div class="group-modal-card">
                <div class="modal-contents">
                    <p class="modal-title">グループ作成</p>
                    <input type="hidden" name="userid" value="{{session('userid')}}" class="userid">
                    <div class="modal-item"><p>グループ名</p><input type="text" name="name" class="name" placeholder="gloup名"></div>
                    <div class="error-message-name"></div>
                    <div class="modal-item"><p>グループカラー</p><input type="color" name="color" class="color" value="#999999"></div>
                    <input class="group-add-send" type="submit" value="グループを追加">
                </div>
            </div>
            <form action="home/addGroupSuccess" method="POST" style="display: hidden;" class="successForm">
                @csrf
                <input type="hidden" name="userid" class="userid">
                <input type="hidden" name="name" class="name">
                <input type="hidden" name="color" class="color">
            </form>
        </div>
        <div class="group-list">
            @foreach($groupList as $group)
                <div class="group-item @if($group['visible']!== 1) toggle-off @endif" data-groupid="{{$group['id']}}" style="background-color: {{$group['color']}}"><p style="color: {{$group['color']}}">{{$group['name']}}</p></div>
            @endforeach 
            <form action="home/groupToggle" method="Get" style="display: none;" class="form">
                @csrf
                <input type="hidden" name="groupid" class="groupid">
                <input type="hidden" name="isVisible" class="isVisible">
            </form>
        </div>
    </div>
</div>