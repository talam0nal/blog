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
                                    Автор
                                </th>
                                <th>
                                    Дата
                                </th>
                                <th>
                                    Содержание
                                </th>
                                <th>
                                    Управление
                                </th>
                            </tr>
                            @foreach ($items as $item)
                                <tr>
                                    <td>
                                        {{ $item->user->name }}
                                    </td>
                                    <td>
                                        {{ $item->created_at }}
                                    </td>
                                    <td>
                                        {!! $item->text !!}
                                    </td>
                                    <td>
                                        @if (!$item->active)
                                            <a href="#" class="switch-comment" data-id="{{ $item->id }}">Опубликовать</a><br>
                                        @else
                                            <a href="#" class="switch-comment" data-id="{{ $item->id }}">Снять с публикации</a><br>
                                        @endif
                                        
                                        <a href="#" class="delete-comment" data-id="{{ $item->id }}">Удалить</a>
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

                $('.delete-comment').click(function(e) {
                    event.preventDefault();
                    el = $(this);
                    id = el.attr('data-id');
                    $.ajax({
                        url: '/admin/comments/'+id,
                        type: 'DELETE',
                        success: function(result) {
                            el.parents('tr').remove();
                        }
                    });
                });

                $('.switch-comment').click(function(e) {
                    e.preventDefault();
                    el = $(this);
                    var id = el.attr('data-id');
                    $.post("{{ route('comments.switch') }}", {id: id})
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
