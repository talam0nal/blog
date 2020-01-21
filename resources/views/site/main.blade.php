@extends ('layouts.layout')

@section ('content')
    @include ('partials.header')

    <div class="container content">
        <div class="row">
            <div class="col-12">
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
                                Мне нравится (0) Просмотров (0)
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