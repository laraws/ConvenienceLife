<div class="list-group-item">
    <a href="{{ route('weathers.show', $weatherInfo) }}">
        {{ $weatherInfo->title }}
    </a>
    <p class="mb-0 pb-0">项目数据更新时间: {{ $weatherInfo->updated_at->diffForHumans() }}</p>
    <p class="mb-0 pb-0">天气数据更新时间: {{ json_decode($weatherInfo->content, true)['reporttime'] }}</p>

    <form action="{{ route('weathers.destroy', $weatherInfo->id) }}" method="post" class="float-right">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button type="submit" class="btn btn-sm btn-danger delete-btn">删除</button>
    </form>
</div>
