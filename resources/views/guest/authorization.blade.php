@extends('layout.app')
@section('title')
    Авторизация
@endsection
@section('content')
    <div class="container" id="Authorization">
        <div class="page-form  row  justify-content-center">
            <div class="col-4">
                <div class="title  title-form">
                    <h2 class="title__text  title__text">Авторизация</h2>
                    <div class="title__line  title__line"></div>
                </div>
                <div class="row  justify-content-center">
                    <div :class="message ? 'message' : ''">@{{ message }}</div>
                </div>
                <form class="form"  id="formAuthorization" @submit.prevent="Authorization">
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="text" placeholder="логин"  name="login" :class="errors.login ? 'is-invalid' : ''">
                        <div :class="errors.login ? 'invalid-feedback' : ''" v-for="error in errors.login">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="password" placeholder="пароль"  name="password" :class="errors.password ? 'is-invalid' : ''">
                        <div :class="errors.password ? 'invalid-feedback' : ''" v-for="error in errors.password">
                            @{{ error }}
                        </div>
                    </div>
                    <button type="submit" class="col-6  btn">вход</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        const Authorization = {
            data() {
                return {
                    errors: [],
                    message: ''
                }
            },
            methods: {
                async Authorization() {
                    const form = document.querySelector('#formAuthorization');
                    const formData = new FormData(form);
                    const response = await fetch('{{route('Authorization')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        body: formData
                    });
                    if (response.status === 400) {
                        this.errors = await response.json();
                        setTimeout(()=>{this.errors = []}, 20000);
                    };
                    if (response.status === 403) {
                        this.message = await response.json();
                        setTimeout(()=>{this.message = null}, 20000)
                    }
                    if (response.status === 200) {
                        window.location = response.url;
                    }
                }
            }
        }
        Vue.createApp(Authorization).mount('#Authorization');
    </script>
@endsection
