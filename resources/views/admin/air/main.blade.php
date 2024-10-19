@extends('layout.app')
@section('title')
    Самолеты
@endsection
@section('content')
    <div class="container" id="Authorization">
        <div class="page-form  row  justify-content-center">
            <div class="col-12">
                <div class="title">
                    <h2 class="title__text  title__text">Самолеты</h2>
                    <div class="title__line  title__line"></div>
                </div>
                <div class="row  justify-content-center" style="margin-bottom: 60px;">
                    <a class="col-12  btn" href="{{route('AirAddPage')}}">Добавить самолет</a>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">название</th>
                        <th scope="col">кол-во мест</th>
                        <th scope="col">цена</th>
                        <th scope="col">действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($airs as $air)
                    <tr>
                        <td> {{$air->id}} </td>
                        <td> {{$air->title}} </td>
                        <td> {{$air->count_seat}} </td>
                        <td> {{$air->price}} ₽ </td>
                        <td style="display: flex; flex-direction: row; align-items: center; justify-content: flex-end">
                            <a href="{{route('AirEditPage', ['air'=>$air])}}" class="btn" style="width: 45%; font-size: 12px; margin-right: 10px;">Изменить</a>
                            <form action="{{route('AirDelete', ['air'=>$air])}}" method="post" style="width: 45%">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger" style="width: 100%; font-size: 12px">Удалить</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
