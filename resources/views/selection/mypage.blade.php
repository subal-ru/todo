@extends('layouts.todo')

@section('css') {{asset('css/mypage.css')}} @endsection

@section('content')
    <div class="mypage-main">
        <div class="mypage-main-left">
            <div class="mypage-menu">
                <div @if($menu=='info') class="isActive"@endif data-menutag="information"><a href="{{route('mypage').'/info'}}">登録情報</a></div>
                <div @if($menu=='pass') class="isActive"@endif data-menutag="changePass"><a href="{{route('mypage').'/pass'}}">パスワード変更</a></div>
                <div @if($menu=='group') class="isActive"@endif data-menutag="group"><a href="{{route('mypage').'/group'}}">グループ設定</a></div>
            </div>
        </div>
        <div class="mypage-main-right">

            {{-- HTML:informationの呼出 --}}
            <x-mypage.information :menu="$menu"></x-mypage.information>

            {{-- HTML:changePassの呼出 --}}
            <x-mypage.changePass :menu="$menu"></x-mypage.changePass>
            
            {{-- HTML:groupの呼出 --}}
            <x-mypage.group :groups="$groups" :menu="$menu" :select="$select" :groupMember="$groupMember"></x-mypage.group>

        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/mypage.js')}}"></script>
@endsection