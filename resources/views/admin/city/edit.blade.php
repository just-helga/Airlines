@extends('layout.app')
@section('title')
    Изменение города "{{$city->title}}"
@endsection
@section('content')
    <div class="container" id="CityEdit">
        <div class="page-form  row  justify-content-center">
            <div class="col-4">
                <div class="title  title-form">
                    <h2 class="title__text  title__text" style="width: 100%;">Изменение города "{{$city->title}}"</h2>
                </div>
                <form class="form" id="formCityEdit" @submit.prevent="CityEdit" enctype="multipart/form-data">
                    <input type="text" class="visually-hidden" name="id" value="{{$city->id}}">
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="text" placeholder="название"  name="title" :class="errors.title ? 'is-invalid' : ''" value="{{$city->title}}">
                        <div :class="errors.title ? 'invalid-feedback' : ''" v-for="error in errors.title">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="file" placeholder="фото"  name="img" :class="errors.img ? 'is-invalid' : ''">
                        <div :class="errors.img ? 'invalid-feedback' : ''" v-for="error in errors.img">
                            @{{ error }}
                        </div>
                    </div>
                    <button type="submit" class="col-6  btn">Изменить</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        const CityEdit = {
            data() {
                return {
                    errors: []
                }
            },
            methods: {
                async CityEdit() {
                    const form = document.querySelector('#formCityEdit');
                    const formData = new FormData(form);
                    const response = await fetch('{{route('CityEdit')}}', {
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
        Vue.createApp(CityEdit).mount('#CityEdit');
    </script>
@endsection
