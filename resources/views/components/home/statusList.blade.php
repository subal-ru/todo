{{-- ステータス毎のリストを表示する --}}
<div class={{$statusName}}>
    <div><p>{{$statusText}}</p></div>
    <div class="list">
        @foreach( $items  as $item )
        <div class="item-wrapper">
            <div class="item" data-status="{{$item->status}}" data-id="{{$item->id}}" data-groupid="{{$item->group_id}}" data-groupname="{{$item->group_name}}" draggable="true" style="background-color:{{$item->color}};">
                <p class="item-title" data-title={{$item->title}} style="color:{{$item->color}};">{{$item->title}}</p>
                <p class="item-message" data-message={{$item->message}} style="color:{{$item->color}};">{{$item->message}}</p>
                <div class="item-name" style="background-color: {{$item->color}};"><p data-userid={{$item->userid}} style="color:{{$item->color}}">{{$item->name}}</p></div>
            </div>
        </div>
        @endforeach
    </div>
</div>