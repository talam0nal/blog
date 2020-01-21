@extends ('layouts.layout')

@section ('content')
    <div class="container register-block">
        <div class="row">

            @include ('partials.menu')

            <div class="col-sm-9">
                @if ($item)
                    <form class="create-edit" method="POST" action="{{ route('posts.update', $item->id) }}" enctype="multipart/form-data">
                        @method('PUT')
                    @else
                    <form class="create-edit" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="form-group">
                        <label for="title">
                            Заголовок
                        </label>
                        <input value="@if ($item){{ $item->title }}@endif" name="title" placeholder="Введите заголовок" type="text" class="form-control" id="title" required>
                    </div>

                    <div class="form-group">
                        <label for="subtitle">
                            Подзаголовок
                        </label>
                        <input value="@if ($item){{ $item->subtitle }}@endif" name="subtitle" placeholder="Введите подзаголовок" type="text" class="form-control" id="subtitle">
                    </div>

                    <div class="form-group">
                        <label for="preview">
                            Изображение
                        </label>
                        <input type="file" name="preview" class="form-control-file" id="preview" accept="image/*">

                        @if ($item)
                            @if ($item->preview)
                                <div class="row image-gap">
                                    <div class="col-sm-6">
                                        <img src="{{ Storage::url($item->preview) }}">
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="text">Текст публикации</label>
                        <textarea id="text" name="text" class="form-control" id="text" rows="3">@if ($item){{ $item->text }}@endif</textarea>
                    </div>

                    @if (count($categories))
                        <label for="category">Категория:</label>
                        <select class="form-control" name="category_id">
                            <option value="">Без категории</option>
                            @foreach ($categories as $category)
                                <option @if ($item) @if ($item->category_id == $category->id) selected @endif @endif value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    @endif

                    <div class="form-group">
                        <label for="tags">
                            Теги:
                        </label>
                        <input value="@if ($item){{ $item->tags }}@endif" name="tags" type="text" class="form-control" id="tags">
                    </div>

                    <button type="submit" class="btn btn-success">Сохранить</button>
                </form>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="/assets/css/trumbowyg.min.css">
    <link rel="stylesheet" href="/assets/css/jquery.tagsinput-revisited.min.css">
    <script src="/assets/js/trumbowyg/trumbowyg.min.js"></script>
    <script src="/assets/js/trumbowyg/trumbowyg.upload.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.20.0/langs/ru.js"></script>
    <script src="/assets/js/jquery.tagsinput-revisited.min.js"></script>
    <script>

        $(function() {
            $('#tags').tagsInput({
                unique:true,
            });

            $('textarea').trumbowyg({

                btnsDef: {
                    image: {
                        dropdown: ['insertImage', 'upload', 'noembed'],
                        ico: 'insertImage'
                    }
                },

                btns: [
                    ['viewHTML'],
                    ['undo', 'redo'],
                    ['formatting'],
                    ['strong', 'em', 'del'],
                    ['superscript', 'subscript'],
                    ['link'],
                    ['image','noembed'],
                    ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                    ['unorderedList', 'orderedList'],
                    ['horizontalRule'],
                    ['removeformat'],
                    ['fullscreen']
                ],

                plugins: {
                    upload: {
                        serverPath: '{{ route("image.editor") }}',
                        fileFieldName: 'image',
                        urlPropertyName: 'data.link'
                    }
                },   

                lang: 'ru',
                removeformatPasted: true,
                autogrow: true,
            });
        });
    </script>
@endsection