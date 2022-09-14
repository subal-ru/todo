@extends('layouts.todo')

@section('css') {{asset('css/mypage.css')}} @endsection

@section('content')
    <div class="mypage-main">
        <div class="mypage-main-left">
            <div class="mypage-menu">
                <div class="isActive" data-menutag="information">登録情報</div>
                <div data-menutag="changePass">パスワード変更</div>
                <div data-menutag="group">グループ設定</div>
                <div data-menutag="kari">仮</div>
            </div>
        </div>
        <div class="mypage-main-right">

            {{-- HTML:informationの呼出 --}}
            <x-mypage.information></x-mypage.information>

            {{-- HTML:changePassの呼出 --}}
            <x-mypage.changePass></x-mypage.changePass>
            
            {{-- HTML:groupの呼出 --}}
            <x-mypage.group></x-mypage.group>

        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/mypage.js')}}"></script>
@endsection