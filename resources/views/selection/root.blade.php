@extends('layouts.todo')

@section('css')
    {{asset('css/root.css')}}
@endsection

@section('content')
<div>
    <h1 class="root-message">利用するにはログインしてください</h1>
</div>
@endsection

@section('script')
    <script src="{{asset('js/root.js')}}"></script>
@endsection