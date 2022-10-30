{{-- mypage-groupのhtml --}}

<div class="group @if($menu=='group') display-block"@endif>
    <div class="group-selector">
        <div>グループ：</div>
        <div>
            <form action="{{route('mypage')}}/group" class="form-selector" method="GET">
                <select name="select" class="select">
                    @foreach($groups as $group)
                        @if($group->id == NULL)
                            <?php $groupid = 0 ?>
                            <?php $groupName = '未設定' ?>
                        @else
                            <?php $groupid = $group->id ?>
                            <?php $groupName = $group->name ?>
                        @endif
                        <option value="{{$groupid}}" @if ($select==$groupid) selected @endif>{{$groupName}}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    <div class="group-view">
        <div class="member-wrapper">
            <div class="member">
                <p class="title">メンバー</p>
                @if ($select == 0)
                    <p>グループを選択してください</p>
                @else
                {{-- テーブルにする --}}
                    <table>
                    <thead style="background-color: #d9d9d9;"><th>名前</th><th>権限</th></thead>
                    <tbody>
                    @foreach($groupMember as $number => $Member)
                        <tr>
                            <td>{{$Member->name}}</td>
                            @if($Member->authority == 1)
                                <td>管理者</td>
                            @else
                                <td>メンバー</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                    </table>
                @endif
                <div class="add" @if($select == 0) style="display: none;"@endif>
                    <div class="botton">メンバーを追加</div>
                    <div class="addForm">
                        <p>ユーザー名</p>
                        <input type="text" name="name" class="name">
                        <input type="hidden" name="groupid" class="groupid" value="{{$select}}">
                        <input type="submit" value="追加" class ="submit">
                        <div class="error-message error-message-type3"></div>
                        <div class="success-message success-message-type2"></div>
                    </div>
                </div> 
            </div>
        </div>
        <div class="option-wrapper">
            <div class="option">
                <p class="title">グループ設定</p>
            </div>
        </div>
    </div>
</div>