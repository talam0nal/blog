@extends ('layouts.layout')

@section ('content')
    @include ('partials.header')

    <div class="container content">
        <div class="row">
            <div class="col-3">
                <div class="list-group">
                    <a href="{{ route('category.site.index') }}" class="list-group-item list-group-item-action @if (!request()->segment(2)) active @endif">
                        Все категории
                    </a>
                    @foreach ($categories as $item)
                        <a href="{{ route('category.site.show', $item->id) }}" class="list-group-item list-group-item-action @if (request()->segment(2) == $item->id) active @endif">
                            {{ $item->title }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-9">
                @foreach ($posts as $post)
                    <div class="post">
                        <a href="{{ route('posts.show', $post->id) }}" class="title">{{ $post->title }}</a>
                        @if ($post->preview)
                            <div class="row image-gap">
                                <div class="col-sm-6">
                                    <img src="{{ Storage::url($post->preview) }}">
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-12">
                                Мне нравится ({{ $post->countLikes }}) Просмотров ({{ $post->countViews }})
                                <br>
                                {{ $post->created_at }}
                                <br>
                                @if ($post->category)
                                    {{ $post->category->title }}
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection