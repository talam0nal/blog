@extends ('layouts.layout')

@section ('content')
    <div class="container register-block">
        <div class="row">

            <aside class="col-sm-3">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active">
                        Публикации
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        Комментарии
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        Категории
                    </a>
                </div>
            </aside>

            <div class="col-sm-9">
                <form class="create-edit">
                    <div class="form-group">
                        <label for="title">
                            Заголовок
                        </label>
                        <input name="title" placeholder="Введите заголовок" type="text" class="form-control" id="title" required>
                    </div>

                    <div class="form-group">
                        <label for="subtitle">
                            Подзаголовок
                        </label>
                        <input name="subtitle" placeholder="Введите подзаголовок" type="text" class="form-control" id="subtitle">
                    </div>

                    <div class="form-group">
                        <label for="preview">
                            Изображение
                        </label>
                        <input type="file" name="preview" class="form-control-file" id="preview">
                    </div>

                    <div class="form-group">
                        <label for="text">Текст публикации</label>
                        <textarea id="text" name="text" class="form-control" id="text" rows="3"></textarea>
                    </div>

                    <label for="category">Категория:</label>
                    <select class="form-control" name="category_id">
                      <option>Default select</option>
                    </select>

                    <div class="form-group">
                        <label for="tags">
                            Теги:
                        </label>
                        <input name="tags" type="text" class="form-control" id="tags">
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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