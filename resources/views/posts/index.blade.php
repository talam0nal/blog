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
                                        {{ $item->category->title }}
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
                                        <a href="#">
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
@endsection
