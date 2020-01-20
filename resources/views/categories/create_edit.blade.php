@extends ('layouts.layout')

@section ('content')
    <div class="container register-block">
        <div class="row">

            @include ('partials.menu')

            <div class="col-sm-9">
                @if ($item)
                    <form class="create-edit" method="POST" action="{{ route('categories.update', $item->id) }}" enctype="multipart/form-data">
                        @method('PUT')
                    @else
                    <form class="create-edit" method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="form-group">
                        <label for="title">
                            Название
                        </label>
                        <input value="@if ($item){{ $item->title }}@endif" name="title" placeholder="Введите название" type="text" class="form-control" id="title" required>
                    </div>
                    <button type="submit" class="btn btn-success">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
@endsection