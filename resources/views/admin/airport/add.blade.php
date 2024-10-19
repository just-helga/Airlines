@extends('layout.app')
@section('title')
    Добавление аэропорта в городе "{{$city->title}}"
@endsection
@section('content')
    <div class="container" id="AirportAdd">
        <div class="page-form  row  justify-content-center">
            <div class="col-4">
                <div class="title  title-form">
                    <h2 class="title__text  title__text" style="width: 100%;">Новый аэропорт в городе "{{$city->title}}"</h2>
                </div>
                <form class="form"  id="formAirportAdd" @submit.prevent="AirportAdd">
                    <input type="text" class="visually-hidden" name="city_id" value="{{$city->id}}">
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="text" placeholder="название"  name="title" :class="errors.title ? 'is-invalid' : ''">
                        <div :class="errors.title ? 'invalid-feedback' : ''" v-for="error in errors.title">
                            @{{ error }}
                        </div>
                    </div>
                    <button type="submit" class="col-6  btn">Добавить</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        const AirportAdd = {
            data() {
                return {
                    errors: []
                }
            },
            methods: {
                async AirportAdd() {
                    const form = document.querySelector('#formAirportAdd');
                    const formData = new FormData(form);
                    const response = await fetch('{{route('AirportAdd')}}', {
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
            }
        }
        Vue.createApp(AirportAdd).mount('#AirportAdd');
    </script>
@endsection
