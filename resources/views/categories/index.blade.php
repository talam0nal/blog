@extends('layouts.layout')

@section('content')
    <div class="container register-block">
        <div class="row">

            @include ('partials.menu')


            <div class="col-sm-9">
                <a href="{{ route('categories.create') }}" class="btn btn-success">
                    Создать новую категорию
                </a>

                @if (count($items))
                    <table class="table">  
                        <thead>
                            <tr>
                                <th>
                                    Заголовок
                                </th>
                                <th>
                                    Количество публикаций
                                </th>
                                <th>
                                    Управление
                                </th>
                            </tr>
                            @foreach ($items as $item)
                                <tr>
                                    <td>
                                        {{ $item->title }}
                                    </td>
                                    <td>
                                        {{ $item->publicationsCount }}
                                    </td>
                                    <td>
                                        <a href="{{ route('categories.edit', $item->id) }}">
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
