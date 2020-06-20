<div class="list-group-item">
    <a href="{{ route('weathers.show', $weatherInfo) }}">
        {{ $weatherInfo->title }}
    </a>
    <p class="mb-0 pb-0">项目数据更新时间: {{ $weatherInfo->updated_at->diffForHumans() }}</p>
    <p class="mb-0 pb-0">天气数据更新时间: {{ json_decode($weatherInfo->content, true)['reporttime'] }}</p>


    <a href="{{route('weathers.edit', $weatherInfo->id)}}" class="btn btn-secondary btn-sm" role="button">编辑</a>

    <form action="{{ route('weathers.subscribe', $weatherInfo->id) }}" method="post" class="float-left">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <button type="submit" class="btn btn-sm btn-secondary">@if ($weatherInfo->has_subscribed == 1)已订阅 @else
                点击订阅 @endif</button>
    </form>

    <form action="{{ route('weathers.update', [$weatherInfo->id, 'type' => 'data']) }}" method="post" class="float-left">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <button type="submit" class="btn btn-sm btn-secondary">更新</button>
    </form>

    <form action="{{ route('weathers.destroy', $weatherInfo->id) }}" method="post" class="float-right">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button type="submit" class="btn btn-sm btn-danger delete-btn">删除</button>
    </form>
</div>
