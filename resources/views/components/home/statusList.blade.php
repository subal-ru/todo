{{-- ステータス毎のリストを表示する --}}
<div class={{$statusName}}>
    <div><p>{{$statusText}}</p></div>
    <div class="list">
        @foreach( $items  as $item )
        <div class="item-wrapper">
            <div class="item" data-status="{{$item->status}}" data-id="{{$item->id}}" draggable="true">
                <p class="item-title" data-title={{$item->title}}>{{$item->title}}</p>
                <p class="item-message" data-message={{$item->message}}>{{$item->message}}</p>
                <p class="item-name" data-userid={{$item->userid}}>{{$item->name}}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>