@extends('layouts.todo')

@section('css')
    {{asset('css/home.css')}}
@endsection

@section('content')
    <div class="main-wrapper">
        <div class='main'>
            <div class="add">
                <div class="add-btn">add</div>
            </div>
            <div class="modal add">
                <div class="add-modal-card">
                    <form action="{{route('home')}}/addItem" method="POST">
                        @csrf
                        <div class="modal-contents">
                            <p>作業の追加</p>
                            <div><p>ステータス</p><div>
                                <input type="hidden" name="userid" value="{{session('userid')}}">
                                <select name="status" required>
                                    <option value="">ステータスを選んでください</option>
                                    <option value="0">未着手</option>
                                    <option value="1">作業中</option>
                                    <option value="2">完了</option>
                                </select>
                                </div>
                            </div>
                            <div><p>タイトル</p><div><input type="text" name="title"></div></div>
                            <div><p>グループ設定</p><div>
                                <select name="groupid">
                                    <option value="0">グループなし</option>
                                    @foreach($groupList as $group)
                                        <option value="{{$group['id']}}">{{$group['name']}}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div><p>内容</p><div><textarea rows="4" cols="35" name="message"></textarea></div></div>
                            <input class="add-send-btn" type="submit" value="決定">
                        </div>
                    </form>
                </div>
            </div>
            <x-home.group class="group" :groupList="$groupList"></x-home.group>
            <div class="detail">
                {{-- 7.0以前の記載では変数をコンポーネントに渡すのに、工夫が必要？ --}}
                {{-- @component('components.statusList')
                    @slot('status')
                        status-yet
                    @endslot
                    @slot('statusText')
                        未着手
                    @endslot
                    @slot('items')　
                        $yetItem
                    @endslot
                @endcomponent --}}
                {{-- アイテムを表示 --}}
                <x-home.statusList statusName="status-yet" statusText="未着手" :items="$yetItems"></x-home.statusList>
                <x-home.statusList statusName="status-current" statusText="作業中" :items="$currentItems"></x-home.statusList>
                <x-home.statusList statusName="status-finish" statusText="完了" :items="$finishItems"></x-home.statusList>
                {{-- アイテムの詳細編集をモーダルで作成 --}}
            </div>
            <div class="item-detail modal">
                <div class="item-modal-card">
                    <form action="{{route('home')}}/changeItem" method="POST">
                        @csrf
                        <div class="contents">
                            <p>作業の編集</p>
                            <div><p>ステータス</p><div>
                                <input type="hidden" name="id">
                                <select name="status" required class="modal-status">
                                    <option value=""></option>
                                    <option value="0">未着手</option>
                                    <option value="1">作業中</option>
                                    <option value="2">完了</option>
                                </select>
                                </div>
                            </div>
                            <div><p>タイトル</p><div><input type="text" name="title" class="modal-title"></div></div>
                            <div><p>内容</p><div><textarea rows="4" cols="35" name="message" class="modal-message"></textarea></div></div>
                            <input class="add-send-btn" type="submit" value="変更">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/home.js') }}"></script>
@endsection