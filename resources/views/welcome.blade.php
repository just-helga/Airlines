@extends('layout.app')
@section('title')
    Главная
@endsection
@section('content')
    <div class="main-block">
        <div class="container">
            <h1 class="main-block__title">Поиск авиабилетов</h1>
            <form class="main-block__form">
                <div class="main-block__wrapper">
                    <label for="" class="main-block__label">откуда</label>
                    <input type="text" class="main-block__input">
                </div>
                <div class="main-block__wrapper">
                    <label for="" class="main-block__label">куда</label>
                    <input type="text" class="main-block__input">
                </div>
                <div class="main-block__wrapper">
                    <label for="" class="main-block__label">когда</label>
                    <input type="text" class="main-block__input">
                </div>
                <a href="{{route('FlightsPage')}}" class="main-block__button  button" style="display: flex; align-items: center; justify-content: center; text-decoration: none">найти</a>
            </form>
        </div>
    </div>
    <section class="popular">
        <div class="container">
            <div class="title">
                <h2 class="title__text">Популярные направления</h2>
                <div class="title__line"></div>
            </div>
            <div class="popular__wrapper  row">
                <a href="#" class="popular__card" style="background: linear-gradient(rgba(0,0,0,0.27), rgba(0,0,0,0.27)), url('{{asset('public/img/москва.jpg')}}') center/cover no-repeat">Москва</a>
                <a href="#" class="popular__card" style="background: linear-gradient(rgba(0,0,0,0.27), rgba(0,0,0,0.27)), url('{{asset('public/img/стамбул.jpg')}}') center/cover no-repeat">Стамбул</a>
                <a href="#" class="popular__card" style="background: linear-gradient(rgba(0,0,0,0.27), rgba(0,0,0,0.27)), url('{{asset('public/img/токио.jpg')}}') center/cover no-repeat">Токио</a>
                <a href="#" class="popular__card" style="background: linear-gradient(rgba(0,0,0,0.27), rgba(0,0,0,0.27)), url('{{asset('public/img/торонто.jpg')}}') center/cover no-repeat">Торонто</a>
            </div>
        </div>
    </section>
    <section class="all">
        <div class="container">
            <div class="title">
                <h2 class="title__text">Все рейсы</h2>
                <div class="title__line"></div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">откуда</th>
                    <th scope="col">куда</th>
                    <th scope="col">дата и время вылета</th>
                    <th scope="col">цена билета</th>
                </tr>
                </thead>
                <tbody>
                @foreach($flights as $flight)
                <tr>
                    <td>@foreach($cities as $city) @if($city->id == $flight->from_city_id) {{$city->title}} @endif @endforeach</td>
                    <td>@foreach($cities as $city) @if($city->id == $flight->to_city_id) {{$city->title}}@endif @endforeach</td>
                    <td>{{$flight->date_from}} {{$flight->time_from}}</td>
                    <td>15000 руб</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

{{--    <script>--}}
{{--        function equalHeight(group) {--}}
{{--            var tallest = 0;--}}
{{--            group.each(function() {--}}
{{--                thisHeight = $(this).height();--}}
{{--                if(thisHeight > tallest) {--}}
{{--                    tallest = thisHeight;--}}
{{--                }--}}
{{--            });--}}
{{--            group.height(tallest);--}}
{{--        }--}}
{{--        $(document).ready(function(){--}}
{{--            equalHeight($(".popular__card"));--}}
{{--        });--}}
{{--    </script>--}}
@endsection
