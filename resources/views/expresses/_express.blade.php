<div class="list-group-item">
    <a href="{{ route('expresses.show', $express) }}">
        {{ $express->title }}
    </a>
    <p class="mb-0 pb-0">项目数据更新时间: {{ $express->updated_at->diffForHumans() }}</p>
    <p class="mb-0 pb-0">单号: {{ $express->tracking_number }}</p>
    <p class="mb-0 pb-0">签收状态: @switch($express->sign_status)
            @case(1) 在途中 @break
            @case(2) 派件中 @break
            @case(3) 已签收 @break
            @case(4) 派件失败 @break
        @endswitch
    </p>

    <form action="{{ route('expresses.destroy', $express->id) }}" method="post" class="float-right">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button type="submit" class="btn btn-sm btn-danger delete-btn">删除</button>
    </form>
</div>
