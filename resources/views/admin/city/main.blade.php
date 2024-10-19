@extends('layout.app')
@section('title')
    Города
@endsection
@section('content')
    <div class="container" id="Authorization">
        <div class="page-form  row  justify-content-center">
            <div class="col-12">
                <div class="title">
                    <h2 class="title__text  title__text">Города</h2>
                    <div class="title__line  title__line"></div>
                </div>
                <div class="row  justify-content-center" style="margin-bottom: 60px;">
                    <a class="col-12  btn" href="{{route('CityAddPage')}}">Добавить город</a>
                </div>
                <div class="popular__wrapper  row">
                    @foreach($cities as $city)
                        <div class="popular__card" style="background: linear-gradient(rgba(0,0,0,0.27), rgba(0,0,0,0.27)), url('{{$city->img}}') center/cover no-repeat">
                            {{$city->title}}
                            <div class="popular__card-hover">
                                <a href="{{route('CityEditPage', ['city'=>$city])}}" class="btn" style="width: 80%; margin-bottom: 10px;">Изменить</a>
                                    <form action="{{route('CityDelete', ['city'=>$city])}}" method="post" style="width: 80%; margin-bottom: 10px;">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger" style="width: 100%;">Удалить</button>
                                    </form>
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#airports{{$city->id}}" style="width: 80%; background-color: #265BE3">Аэропорты</button>
                            </div>
                        </div>
                        <div class="modal fade" id="airports{{$city->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel" style="font-size: 18px !important;">Аэропорты города "{{$city->title}}"</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col" style="font-size: 15px !important;">id</th>
                                                <th scope="col" style="font-size: 15px !important;">название</th>
                                                <th scope="col" style="font-size: 15px !important;">действие</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($city->airports as $airport)
                                            <tr>
                                                <td style="font-size: 12px !important;">{{$airport->id}}</td>
                                                <td style="font-size: 12px !important;">{{$airport->title}}</td>
                                                <td style="display: flex; flex-direction: row; align-items: center; justify-content: flex-end; flex-wrap: nowrap">
                                                    <a href="{{route('AirportEditPage', ['airport'=>$airport])}}" class="btn" style="width: 45%; font-size: 12px; margin-right: 10px;">Изменить</a>
                                                    <form action="{{route('AirportDelete', ['airport'=>$airport])}}" method="post" style="width: 45%">
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
                                    <div class="modal-footer">
                                        <a href="{{route('AirportAddPage', ['city'=>$city])}}" class="btn" style="font-size: 15px">Добавить аэропорт</a>
                                        <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: #265BE3; font-size: 15px">Закрыть</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        function equalHeight(group) {
            var tallest = 0;
            group.each(function() {
                thisHeight = $(this).height();
                if(thisHeight > tallest) {
                    tallest = thisHeight;
                }
            });
            group.height(tallest);
        }
        $(document).ready(function(){
            equalHeight($(".popular__card"));
        });
    </script>
@endsection
