@extends('layout.app')
@section('title')
    Добавление самолета
@endsection
@section('content')
    <div class="container" id="AirAdd">
        <div class="page-form  row  justify-content-center">
            <div class="col-4">
                <div class="title  title-form">
                    <h2 class="title__text  title__text" style="width: 100%;">Добавление самолета</h2>
                </div>
                <form class="form"  id="formAirAdd" @submit.prevent="AirAdd">
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="text" placeholder="название"  name="title" :class="errors.title ? 'is-invalid' : ''">
                        <div :class="errors.title ? 'invalid-feedback' : ''" v-for="error in errors.title">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="number" placeholder="кол-во мест"  name="count_seat" :class="errors.count_seat ? 'is-invalid' : ''">
                        <div :class="errors.count_seat ? 'invalid-feedback' : ''" v-for="error in errors.count_seat">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="number" placeholder="цена"  name="price" :class="errors.price ? 'is-invalid' : ''">
                        <div :class="errors.price ? 'invalid-feedback' : ''" v-for="error in errors.price">
                            @{{ error }}
                        </div>
                    </div>
                    <button type="submit" class="col-6  btn">Добавить</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        const AirAdd = {
            data() {
                return {
                    errors: []
                }
            },
            methods: {
                async AirAdd() {
                    const form = document.querySelector('#formAirAdd');
                    const formData = new FormData(form);
                    const response = await fetch('{{route('AirAdd')}}', {
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
        Vue.createApp(AirAdd).mount('#AirAdd');
    </script>
@endsection
