@extends('layout.app')
@section('title')
    Выбор места
@endsection
@section('content')
    <div class="container" id="RegistrationPlace" style="margin-top: 88px;">
        <div class="title  col-12" style="margin-bottom: 40px;">
            <h2 class="title__text  title__text">Выбор места</h2>
            <div class="title__line  title__line"></div>
        </div>
        <div class="row  justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-5  flight">
                        <div class="col-12  flight__cart">
                            <div class="col-12" style="border-right: 2px solid #265BE3">
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
                                <p class="flight__price" style="padding-right: 25px;">Стоимость <span> {{round((($flight->air->price / $flight->air->count_seat) +(($flight->air->price / $flight->air->count_seat) / 100 * $flight->percent_price)), 0, PHP_ROUND_HALF_UP)}} ₽</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-7  place">
                        <p class="place__text">Выберите одно из предлагаемых мест.</p>
                        <p class="place__text  place__text-italic">Выход из самолёта находится в левой части расположения мест:</p>
                        <div class="place__scheme">
                            @foreach($tickets as $ticket)
                                <button class="place__btn @if($ticket->user_id !== NULL) place__btn-employed @endif" name="{{$ticket->seat}}" @click="ChoosePlace(<?php echo $ticket->seat ?>)">{{$ticket->seat}}</button>
                            @endforeach
                        </div>
                        <div class="marker">
                            <div class="marker__item">
                                <span class="marker__square" style="background: #265BE3"></span>
                                <p class="marker__text">свободно</p>
                            </div>
                            <div class="marker__item">
                                <span class="marker__square" style="background: black"></span>
                                <p class="marker__text">занято</p>
                            </div>
                            <div class="marker__item">
                                <span class="marker__square" style="background: #F4C82C"></span>
                                <p class="marker__text">выбрано вами</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="title  col-12" style="margin-bottom: 40px; margin-top: 44px;">
            <h2 class="title__text  title__text">Регистрация на рейс</h2>
            <div class="title__line  title__line"></div>
        </div>
        <div class="col-12  registration">
            <p class="registration__text">Заполните личные данные для покупки и оформления билета</p>
            <p class="registration__text"><span class="registration__text-bold">ВНИМАНИЕ!</span> Если вы покупаете билет не для себя, введите данные человека, на которого оформляете билет</p>
            <form class="registration__form" id="formRegistrationPlace" @submit.prevent="RegistrationPlace">
                <div class="registration__wrapper  col-4" style="padding-right: 24px;">
                    <input class="form__input  elem-form  form-control" type="text" placeholder="фио"  name="fio" :class="errors.fio ? 'is-invalid' : ''">
                    <div :class="errors.fio ? 'invalid-feedback' : ''" v-for="error in errors.fio">
                        @{{ error }}
                    </div>
                </div>
                <div class="registration__wrapper  col-4" style="padding-right: 24px;">
                    <input class="form__input  elem-form  form-control" type="date" placeholder="дата рождения"  name="birthday" :class="errors.birthday ? 'is-invalid' : ''">
                    <div :class="errors.birthday ? 'invalid-feedback' : ''" v-for="error in errors.birthday">
                        @{{ error }}
                    </div>
                </div>
                <div class="registration__wrapper  col-4">
                    <input class="form__input  elem-form  form-control" type="text" placeholder="серия и номер паспорта"  name="passport" :class="errors.passport ? 'is-invalid' : ''"  maxlength="10" onkeyup="this.value = this.value.replace(/[^\d]/g,'');">
                    <div :class="errors.passport ? 'invalid-feedback' : ''" v-for="error in errors.passport">
                        @{{ error }}
                    </div>
                </div>
                <div class="registration__wrapper  col-4" style="padding-right: 24px;">
                    <input class="form__input  elem-form  form-control" type="text" placeholder="номер свидетельства о рождении"  name="certificate" :class="errors.certificate ? 'is-invalid' : ''"  maxlength="10">
                    <div :class="errors.certificate ? 'invalid-feedback' : ''" v-for="error in errors.certificate">
                        @{{ error }}
                    </div>
                </div>
                <div class="registration__wrapper  col-2" style="padding-right: 24px;">
                    <input class="form__input  elem-form  form-control" type="number" placeholder="номер места"  name="seat" readonly>
                </div>
                <div class="registration__wrapper  col-2" style="padding-right: 24px;">
                    <input class="form__input  elem-form  form-control" type="number" placeholder="номер рейса" name="flight_id" value="{{$flight->id}}" readonly>
                </div>
                <div class="registration__wrapper  col-4">
                    <input class="form__input  elem-form  form-control" type="password" placeholder="введите пароль"  name="password" :class="errors.password ? 'is-invalid' : ''">
                    <div :class="errors.password ? 'invalid-feedback' : ''" v-for="error in errors.password">
                        @{{ error }}
                    </div>
                    <div :class="message !== '' ? 'alert  alert-danger' : ''">
                        @{{ message }}

                    </div>
                </div>
                <div class="check  col-12">
                    <div class="check-wrapper">
                        <input class="check__input  form-check-input" type="checkbox" id="rules" name="rules" :class="errors.rules ? 'is-invalid' : ''">
                        <label class="check__label" for="rules" :style="errors.rules ? 'color: #dc3545' : ''">Я знаком с политикой конфиденциальности и даю свое согласие на обработку персональных данных.</label>
                    </div>
                </div>
                <button type="submit" class="col-2  btn" style="margin-top: 20px;">Оформить</button>
            </form>
        </div>
    </div>
    <style>
        .form__wrapper::before {
            background: url('{{asset('public/img/Vector.png')}}') no-repeat;
        }
        .place {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
        }
        .place__text {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 400;
            font-size: 20px;
            line-height: 24px;
            color: #000000;
        }
        .place__text-italic {
            font-style: italic;
        }
        .place__scheme {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            width: 100%;
        }
        .place__btn {
            width: 44px;
            height: 44px;
            border-radius: 5px;
            border: none;
            margin: 8px;
            background: #265BE3;

            font-family: 'Inter';
            font-style: normal;
            font-weight: 400;
            font-size: 20px;
            line-height: 24px;
            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            transition: .3s;
        }
        .place__btn:hover,
        .place__btn-focus  {
            background: #F4C82C;
        }
        .place__btn-employed {
            background: black;
        }
        .marker {
            margin-top: 70px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-start;
            flex-wrap: nowrap;
        }
        .marker__item {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-start;
            flex-wrap: nowrap;
            margin-right: 100px;
        }
        .marker__square {
            width: 20px;
            height: 20px;
            border-radius: 5px;
            margin-right: 30px;
        }
        .marker__text {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 300;
            font-size: 16px;
            line-height: 19px;
            color: #000000;
            margin: 0;
        }
        .registration {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
        }
        .registration__text {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 400;
            font-size: 20px;
            line-height: 24px;
            color: #000000;
            margin: 0;
        }
        .registration__text-bold {
            text-transform: uppercase;
            font-weight: bold;
        }
        .registration__form {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .registration__wrapper {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
            margin-bottom: 20px;
        }
    </style>
    <script>
        const RegistrationPlace = {
            data() {
                return {
                    errors: [],
                    buttons: [],
                    message: ''
                }
            },
            methods: {
                async ChoosePlace(seat) {
                    for (let btn of this.buttons) {
                        btn.classList.remove('place__btn-focus');
                    }

                    let input = document.querySelector("input[name='seat']")
                    input.value = seat;

                    let buttons = document.getElementsByName(seat);

                    for (let button of buttons) {
                        button.classList.toggle('place__btn-focus');
                    }
                },
                async RegistrationPlace() {
                    console.log('привет');
                    const form = document.querySelector('#formRegistrationPlace');
                    const formData = new FormData(form);
                    const response = await fetch('{{route('RegistrationPlace')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                        body: formData
                    });
                    if (response.status === 200) {
                        window.location = response.url;
                    }
                    if (response.status === 400) {
                        this.errors = await response.json();
                        // setTimeout(()=>{this.errors = []}, 20000);
                    }
                    if (response.status === 403) {
                        this.message = await response.json();
                        // setTimeout(()=>{this.message = [];this.errors = []}, 20000);
                    }
                },
            },
            mounted() {
                this.buttons = document.querySelectorAll('.place__btn');
            },
        }
        Vue.createApp(RegistrationPlace).mount('#RegistrationPlace');
    </script>
@endsection
