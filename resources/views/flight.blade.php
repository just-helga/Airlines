@extends('layout.app')
@section('title')
    Рейсы
@endsection
@section('content')
    <div class="container" style="margin-top: 88px;">
        <div class="row  justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-3  filter">
                        <div class="title  col-12" style="display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start">
                            <h5 class="filter__title">Фильтры</h5>
                            <h6 class="filter__text">Город</h6>
                            <div class="form__wrapper">
                                <select class="form__input  form__select  elem-form  form-select" name="from_city" id="from_city" style="color: #D9D9D9" onchange="colorFromCity()">
                                    <option value="all" style="color: #D9D9D9 !important;">города вылета</option>
                                    @foreach($cities as $city)
                                        <option value="{{$city->id}}" style="color: black">{{$city->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form__wrapper">
                                <select class="form__input  form__select  elem-form  form-select" name="to_city" id="to_city" style="color: #D9D9D9" onchange="colorToCity()">
                                    <option value="all" style="color: #D9D9D9 !important;">города вылета</option>
                                    @foreach($cities as $city)
                                        <option value="{{$city->id}}" style="color: black">{{$city->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <h6 class="filter__text">Стоимость</h6>
                            <div class="input__inner">
                                <input class="form__input  elem-form  form-control" type="number" placeholder="от"  name="start">
                                <input class="form__input  elem-form  form-control" type="number" placeholder="до"  name="finish">
                            </div>
                        </div>
                    </div>
                    <div class="col-9  flight">
                        <div class="title  col-12">
                            <h2 class="title__text  title__text">Рейсы</h2>
                            <div class="title__line  title__line"></div>
                        </div>
                        @if(Auth::user() && Auth::user()->role == 'admin')
                            <div class="row  justify-content-center" style="margin-bottom: 60px;">
                                <a class="col-12  btn" href="{{route('FlightsAddPage')}}">Добавить рейс</a>
                            </div>
                        @else
                            <p class="flight__text  col-12">По вашему запросу найдены следующие рейсы</p>
                        @endif
                        @foreach($flights as $flight)
                            <div class="col-12  flight__cart">
                                <div class="col-7" style="border-right: 2px solid #265BE3">
                                    <div class="flight__direction">
                                        <p class="flight__air">{{$flight->air->title}}</p>
                                        @foreach($cities as $city)
                                            <p class="flight__city"> @if($city->id == $flight->from_city_id) {{$city->title}}@endif </p>
                                        @endforeach
                                        <svg class="flight__icone" xmlns="http://www.w3.org/2000/svg" width="20" height="10" viewBox="0 0 20 10" fill="none">
                                            <path d="M12.43 9.04666L18.5 4.99999L12.43 0.953328M1.5 5L18.33 4.99999" stroke="#F4F6F9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        @foreach($cities as $city)
                                            <p class="flight__city"> @if($city->id == $flight->to_city_id) {{$city->title}}@endif </p>
                                        @endforeach
                                    </div>
                                    <div class="flight__wrapper">
                                        <div class="flight__when">
                                            <p class="flight__date"> {{$flight->date_from}} </p>
                                            <p class="flight__time"> {{$flight->time_from}} </p>
                                            @foreach($cities as $city)
                                                <p class="flight__city  flight__city-blue"> @if($city->id == $flight->from_city_id) {{$city->title}}@endif </p>
                                            @endforeach
                                        </div>
                                        <p class="flight__time-way"> {{$flight->time_way}} </p>
                                        <div class="flight__when">
                                            <p class="flight__date"> {{$flight->date_to}} </p>
                                            <p class="flight__time"> {{$flight->time_to}} </p>
                                            @foreach($cities as $city)
                                                <p class="flight__city  flight__city-blue"> @if($city->id == $flight->to_city_id) {{$city->title}}@endif </p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5  flight__wrapper-info">
                                    <div class="flight__info">
                                        <div class="flight__item">
                                            <p>Цена места:</p>
                                            <p> {{round(($flight->air->price / $flight->air->count_seat), 0, PHP_ROUND_HALF_UP)}} ₽</p>
                                        </div>
                                        <div class="flight__item">
                                            <p>Количество свободных:</p>
                                            <?php $count = 0 ?>
                                            @foreach($tickets as $ticket)
                                                @if($ticket->flight_id == $flight->id)
                                                    @if($ticket->user_id == NULL)
                                                        <?php $count += 1 ?>
                                                    @endif
                                                @endif
                                            @endforeach
                                            <p>{{$count}} мест</p>
                                        </div>
                                        <div class="flight__item">
                                            <p>Взимаемый процент:</p>
                                            <p> {{$flight->percent_price}} </p>
                                        </div>
                                    </div>
                                    <div class="flight__inner">
                                        <p class="flight__price">Стоимость <span> {{round((($flight->air->price / $flight->air->count_seat) +(($flight->air->price / $flight->air->count_seat) / 100 * $flight->percent_price)), 0, PHP_ROUND_HALF_UP)}} ₽</span></p>
                                        @auth()
                                            @if(Auth::user() && Auth::user()->role == 'user')
                                                <a href="{{route('ChoosePlacePage', ['flight'=>$flight])}}" class="col-6  btn">выбрать место</a>
                                            @endif
                                            @if(Auth::user() && Auth::user()->role == 'admin')
                                                <div class="col-12" style="display: flex; align-items: center; justify-content: space-between">
                                                    <a href="#" class="col-6  btn">изменить статус</a>
                                                    <form class="col-6" action="{{route('FlightDelete', ['flight'=>$flight])}}" method="post" style="width: 45%">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="col-12  btn  btn-danger">удалить</button>
                                                    </form>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function colorFromCity() {
            let from_city = document.querySelector("select[name='from_city']");
            if (from_city.value !== 'all') {
                from_city.classList.add('elem-form--black');
            } else {
                from_city.classList.remove('elem-form--black');
            }
        }
        function colorToCity() {
            let to_city = document.querySelector("select[name='to_city']");
            if (to_city.value !== 'all') {
                to_city.classList.add('elem-form--black');
            } else {
                to_city.classList.remove('elem-form--black');
            }
        }
    </script>
    <style>
        .form__wrapper::before {
            background: url('{{asset('public/img/Vector.png')}}') no-repeat;
        }
    </style>
@endsection
