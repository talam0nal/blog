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

    <div class="container comments-block">
        <div class="row">
            <div class="col-12">

                @if (count($comments))
                    <div class="comments-list">
                        <h3>Комментарии</h3>
                        @foreach ($comments as $comment)
                            <div class="comment">
                                {{ $comment->created_at }}, {{ $comment->user->name }}<br>
                                {!! $comment->text !!}
                            </div>
                        @endforeach
                    </div>
                @endif

                @auth
                    <div class="alert alert-primary" role="alert">
                        Комментарий станет доступен после модерации
                    </div>

                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="postId" value="{{ $item->id }}">
                        <div class="form-group">
                            <label for="text">Текст комментария:</label>
                            <textarea class="form-control" id="text" rows="3" name="text" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Комментировать</button>
                    </form>
                    @else
                        <div class="alert alert-primary" role="alert">
                            Только авторизованнные пользователи могут оставлять комментарии
                        </div>
                @endauth
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
                        <br>
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