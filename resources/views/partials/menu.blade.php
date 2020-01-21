<aside class="col-sm-3">
    <div class="list-group">
        <a href="{{ route('posts.index') }}" class="list-group-item list-group-item-action @if (module() == 'posts') active @endif">
            Публикации
        </a>
        <a href="#" class="list-group-item list-group-item-action @if (module() == 'comments') active @endif">
            Комментарии
        </a>
        <a href="{{ route('categories.index') }}" class="list-group-item list-group-item-action @if (module() == 'categories') active @endif">
            Категории
        </a>
        <a href="/" class="list-group-item list-group-item-action">
            Вернуться на сайт
        </a>
        <a href="#" class="list-group-item list-group-item-action logout">
            Выйти
        </a>
    </div>
</aside>

<script>
    $(function() {

        $('.logout').click(function(e) {
            event.preventDefault();
            $.ajax({
                url: '{{ route('logout') }}',
                type: 'POST',
                success: function(result) {
                    window.location.href = '/';
                }
            });
        });

    });
</script>