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
				Мне нравится (0) Просмотров ({{ $item->countViews }})
			</div>
		</div>

	</div>
@endsection