@extends('layout.app')
@section('title')
    Изменение аэропорта "{{$airport->title}}"
@endsection
@section('content')
    <div class="container" id="AirportEdit">
        <div class="page-form  row  justify-content-center">
            <div class="col-4">
                <div class="title  title-form">
                    <h2 class="title__text  title__text" style="width: 100%;">Изменение аэропорта "{{$airport->title}}"</h2>
                </div>
                <form class="form"  id="formAirportEdit" @submit.prevent="AirportEdit">
                    <input type="text" class="visually-hidden" name="id" value="{{$airport->id}}">
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="text" placeholder="название"  name="title" :class="errors.title ? 'is-invalid' : ''" value="{{$airport->title}}">
                        <div :class="errors.title ? 'invalid-feedback' : ''" v-for="error in errors.title">
                            @{{ error }}
                        </div>
                    </div>
                    <button type="submit" class="col-6  btn">Изменить</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        const AirportEdit = {
            data() {
                return {
                    errors: []
                }
            },
            methods: {
                async AirportEdit() {
                    const form = document.querySelector('#formAirportEdit');
                    const formData = new FormData(form);
                    const response = await fetch('{{route('AirportEdit')}}', {
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
        Vue.createApp(AirportEdit).mount('#AirportEdit');
    </script>
@endsection
