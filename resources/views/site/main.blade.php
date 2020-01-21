@extends ('layouts.layout')

@section ('content')
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
				@endauth
			</nav>
		</div>
	</div>

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
	</div>
@endsection