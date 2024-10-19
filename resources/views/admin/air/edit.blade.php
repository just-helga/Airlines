@extends('layout.app')
@section('title')
    Изменение самолета "{{$air->title}}"
@endsection
@section('content')
    <div class="container" id="AirEdit">
        <div class="page-form  row  justify-content-center">
            <div class="col-4">
                <div class="title  title-form">
                    <h2 class="title__text  title__text" style="width: 100%;">Изменение самолета "{{$air->title}}"</h2>
                </div>
                <form class="form"  id="formAirEdit" @submit.prevent="AirEdit">
                    <input type="text" class="visually-hidden" name="id" value="{{$air->id}}">
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="text" placeholder="название"  name="title" :class="errors.title ? 'is-invalid' : ''" value="{{$air->title}}">
                        <div :class="errors.title ? 'invalid-feedback' : ''" v-for="error in errors.title">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="number" placeholder="название"  name="count_seat" :class="errors.count_seat ? 'is-invalid' : ''" value="{{$air->count_seat}}">
                        <div :class="errors.count_seat ? 'invalid-feedback' : ''" v-for="error in errors.count_seat">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="number" placeholder="название"  name="price" :class="errors.price ? 'is-invalid' : ''" value="{{$air->price}}">
                        <div :class="errors.price ? 'invalid-feedback' : ''" v-for="error in errors.price">
                            @{{ error }}
                        </div>
                    </div>
                    <button type="submit" class="col-6  btn">Изменить</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        const AirEdit = {
            data() {
                return {
                    errors: []
                }
            },
            methods: {
                async AirEdit() {
                    const form = document.querySelector('#formAirEdit');
                    const formData = new FormData(form);
                    const response = await fetch('{{route('AirEdit')}}', {
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
        Vue.createApp(AirEdit).mount('#AirEdit');
    </script>
@endsection
