@extends('layout.app')
@section('title')
    Добавление рейса
@endsection
@section('content')
    <div class="container" id="FlightAdd">
        <div class="page-form  row  justify-content-center">
            <div class="col-4">
                <div class="title  title-form">
                    <h2 class="title__text  title__text" style="width: 100%;">Добавление рейса</h2>
                </div>
                <form class="form"  id="formFlightAdd" @submit.prevent="FlightAdd">
                    <label for="" class="form__label">Откуда</label>
                    <div class="form__inner">
                        <div class="form__wrapper" style="width: 48%;">
                            <select class="form__input  form__select  elem-form  form-select" name="from_city_id" id="from_city_id" v-model="from_city_id" @change="GetAirportsFrom">
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}" style="color: black">{{$city->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form__wrapper" style="width: 48%;">
                            <select class="form__input  form__select  elem-form  form-select" name="from_airport_id" id="from_airport_id">
                                <option v-for="airport in airports_from" :key="airport" :value="airport.id" style="color: black">@{{airport.title}}</option>
                            </select>
                        </div>
                    </div>
                    <label for="" class="form__label">Куда</label>
                    <div class="form__inner">
                        <div class="form__wrapper" style="width: 48%;">
                            <select class="form__input  form__select  elem-form  form-select" name="to_city_id" id="to_city_id" v-model="to_city_id" @change="GetAirportsTo">
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}" style="color: black">{{$city->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form__wrapper" style="width: 48%;">
                            <select class="form__input  form__select  elem-form  form-select" name="to_airport_id" id="to_airport_id">
                                <option v-for="airport in airports_to" :key="airport" :value="airport.id" style="color: black">@{{airport.title}}</option>
                            </select>
                        </div>
                    </div>
                    <label for="" class="form__label">Дата и время вылета</label>
                    <div class="form__inner">
                        <div class="input-wrapper" style="width: 48%;">
                            <input class="form__input  elem-form  form-control" type="date" placeholder="дата вылета"  name="date_from" :class="errors.date_from ? 'is-invalid' : ''" style="color: #D9D9D9"  oninput="colorVal()">
                            <div :class="errors.date_from ? 'invalid-feedback' : ''" v-for="error in errors.date_from">
                                @{{ error }}
                            </div>
                        </div>
                        <div class="input-wrapper" style="width: 48%;">
                            <input class="form__input  elem-form  form-control" type="time" placeholder="время вылета"  name="time_from" :class="errors.time_from ? 'is-invalid' : ''" style="color: #D9D9D9"  oninput="colorVal()">
                            <div :class="errors.time_from ? 'invalid-feedback' : ''" v-for="error in errors.time_from">
                                @{{ error }}
                            </div>
                        </div>
                    </div>
                    <label for="" class="form__label">Дата и время прилета</label>
                    <div class="form__inner">
                        <div class="input-wrapper" style="width: 48%;">
                            <input class="form__input  elem-form  form-control" type="date" placeholder="дата прилета"  name="date_to" :class="errors.date_to ? 'is-invalid' : ''" style="color: #D9D9D9"  oninput="colorVal()">
                            <div :class="errors.date_to ? 'invalid-feedback' : ''" v-for="error in errors.date_to">
                                @{{ error }}
                            </div>
                        </div>
                        <div class="input-wrapper" style="width: 48%;">
                            <input class="form__input  elem-form  form-control" type="time" placeholder="время прилета"  name="time_to" :class="errors.time_to ? 'is-invalid' : ''" style="color: #D9D9D9"  oninput="colorVal()">
                            <div :class="errors.time_to ? 'invalid-feedback' : ''" v-for="error in errors.time_to">
                                @{{ error }}
                            </div>
                        </div>
                    </div>
                    <label for="" class="form__label">Самолет</label>
                    <div class="form__wrapper">
                        <select class="form__input  form__select  elem-form  form-select" name="air_id" id="air_id">
                            @foreach($airs as $air)
                                <option value="{{$air->id}}" style="color: black">{{$air->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="number" placeholder="взимаемый процент"  name="percent_price" :class="errors.percent_price ? 'is-invalid' : ''">
                        <div :class="errors.percent_price ? 'invalid-feedback' : ''" v-for="error in errors.percent_price">
                            @{{ error }}
                        </div>
                    </div>
                    <button type="submit" class="col-6  btn">Добавить</button>
                </form>
            </div>
        </div>
    </div>
    <style>
        .form__inner {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-direction: row;
        }
        .form__label {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 19px;
            color: #265BE3;
            margin-bottom: 10px;
        }
    </style>
    <script>
        function colorVal() {
            let birthday = document.querySelector('.elem-form[type=date]');
            if (birthday.value !== '') {
                birthday.classList.add('elem-form--black');
            } else {
                birthday.classList.remove('elem-form--black');
            }
        }
    </script>
    <script>
        const FlightAdd = {
            data() {
                return {
                    errors: [],
                    airports: [],
                    airports_from: [],
                    airports_to: [],
                    from_city_id: ''
                }
            },
            methods: {
                async GetAirports() {
                    const response = await fetch('{{route('GetAirports')}}');
                    const data = await response.json();
                    this.airports = data.airports_all;
                    console.log(this.airports);
                },
                async GetAirportsFrom() {
                    this.airports_from = [];
                    for (let i = 0; i < this.airports.length; i++) {
                        if(this.airports[i]['city_id'] == this.from_city_id) {
                            this.airports_from.push(this.airports[i]);
                        }
                    }
                },
                async GetAirportsTo() {
                    this.airports_to = [];
                    for (let i = 0; i < this.airports.length; i++) {
                        if(this.airports[i]['city_id'] == this.to_city_id) {
                            this.airports_to.push(this.airports[i]);
                        }
                    }
                },
                async FlightAdd() {
                    const form = document.querySelector('#formFlightAdd');
                    const formData = new FormData(form);
                    const response = await fetch('{{route('FlightAdd')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        body: formData
                    });
                    if (response.status === 400) {
                        this.errors = await response.json();
                        setTimeout(()=>{this.errors = []}, 20000);
                    }
                    if (response.status === 200) {
                        window.location = response.url;
                    }
                }
            },
            mounted() {
                this.GetAirports();
            }

        }
        Vue.createApp(FlightAdd).mount('#FlightAdd');
    </script>
@endsection
