@extends ('layouts.layout')

@section ('content')

    @include ('partials.header')

    <div class="container">
        <div class="row">
            <div class="col-12">
                @if ($item->preview)
                    <div class="row image-gap">
                        <div class="col-sm-6">
                            <img src="{{ Storage::url($item->preview) }}">
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="row post">
            <div class="col-12">
                {{ $item->created_at }}<br>
                <h2>{{ $item->title }}</h2>
                {{ $item->subtitle }}
            </div>

            <article class="col-12">
                {!! $item->text !!}
            </article>

            <div class="col-12 tags">
                <a href="{{ route('posts.user', $item->user->id) }}">{{ $item->user->name }}</a><br><br>
                @foreach ($tags as $tag)
                    <span class="badge badge-pill badge-info">{{ $tag }}</span>
                @endforeach
            </div>

            <div class="col-12 likes">
                <span class="like-btn" data-id="{{ $item->id }}">Мне нравится (<span class="like-count">{{ $item->countLikes }}</span>)</span> Просмотров ({{ $item->countViews }})
            </div>
        </div>
    </div>

    @if (count($readMore))
        <div class="container">
            <div class="row">
                <div class="col-12 post">
                    <h4>Читайте также</h4>
                    @foreach ($readMore as $item)
                        <a href="{{ route('posts.show', $item->id) }}" class="read-more-title">{{ $item->title }}</a>
                        {{ $item->subtitle }}
                        @if ($item->preview)
                            <div class="row image-gap">
                                <div class="col-sm-6">
                                    <img src="{{ Storage::url($item->preview) }}">
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    
    <script>
        $('.like-btn').click(function(e) {
            el = $(this);
            var id = el.attr('data-id');
            $.post("{{ route('posts.like') }}", {id: id})
            .done(function(data) {
                let count = data.likedCount;
                let liked = data.liked;
                if (liked == 1) {
                    el.addClass('active');
                } else {
                    el.removeClass('active');
                }
                el.find('.like-count').text(count);
            });
        });
    </script>
@endsection