<div class="container main-menu">
    <div class="row">
        <nav class="col-sm-12">
            <a href="/" class="logo">Blog</a>
            <a href="#">Категории</a>
            <form class="form-inline search-input">
                <input class="form-control mr-sm-2" type="search" placeholder="Поиск по сайту">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Найти</button>
            </form>
            @auth
                <a href="{{ route('posts.create') }}" class="btn btn-success">Написать статью</a>
                @else
                <a href="{{ route('login') }}">Войти</a>
                <a href="{{ route('register') }}">Зарегистрироваться</a>
            @endauth
        </nav>
    </div>
</div>