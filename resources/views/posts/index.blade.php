@extends('layouts.layout')

@section('content')
    <div class="container register-block">
        <div class="row">

            @include ('partials.menu')

            <div class="col-sm-9">
                <a href="{{ route('posts.create') }}" class="btn btn-success">
                    Создать новый пост
                </a>

                @if (count($items))
                    <table class="table">  
                        <thead>
                            <tr>
                                <th>
                                    Заголовок
                                </th>
                                <th>
                                    Категория
                                </th>
                                <th>
                                    Дата
                                </th>
                                <th>
                                    Лайки
                                </th>
                                <th>
                                    Просмотры
                                </th>
                                <th>
                                    Статус
                                </th>
                                <th>
                                    Управление
                                </th>
                            </tr>
                            @foreach ($items as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('posts.show', $item->id) }}" target="_blank">
                                            {{ $item->title }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($item->category)
                                            {{ $item->category->title }}
                                            @else
                                            Без категории
                                        @endif
                                    </td>
                                    <td>
                                        {{ $item->created_at }}
                                    </td>
                                    <td>
                                        L
                                    </td>
                                    <td>
                                        V
                                    </td>
                                    <td>
                                        S
                                    </td>
                                    <td>
                                        <a href="{{ route('posts.edit', $item->id) }}">
                                            Редактировать
                                        </a>
                                        @if ($item->active)
                                            <a href="#" data-id="{{ $item->id }}" class="switch-publish">
                                                Снять с публикации
                                            </a>
                                            @else
                                            <a href="#" data-id="{{ $item->id }}" class="switch-publish">
                                                Опубликовать
                                            </a>
                                        @endif
                                        <a href="#" class="remove-post" data-id="{{ $item->id }}">
                                            Удалить
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </thead>
                    </table>
                @endif
            </div>

        </div>

        <script>
            $(function() {

                $('.remove-post').click(function(e) {
                    event.preventDefault();
                    el = $(this);
                    id = el.attr('data-id');
                    $.ajax({
                        url: '/posts/'+id,
                        type: 'DELETE',
                        success: function(result) {
                            el.parents('tr').remove();
                        }
                    });
                });

                $('.switch-publish').click(function(e) {
                    e.preventDefault();
                    el = $(this);
                    var id = el.attr('data-id');
                    $.post("{{ route('posts.switch') }}", { id: id})
                    .done(function(data) {
                        console.log(data);
                        if (data.active == 0) {
                            el.text('Опубликовать');
                        } else {
                            el.text('Снять с публикации');
                        }
                    });
                });

            });
        </script>    
@endsection
