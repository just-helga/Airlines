@extends('layout.app')
@section('title')
    Регистрация
@endsection
@section('content')
    <div class="container" id="Registration">
        <div class="page-form  row  justify-content-center">
            <div class="col-4">
                <div class="title  title-form">
                    <h2 class="title__text  title__text">Регистрация</h2>
                    <div class="title__line  title__line"></div>
                </div>
                <form class="form" id="formRegistration" @submit.prevent="Registration">
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="text" placeholder="фио"  name="fio" :class="errors.fio ? 'is-invalid' : ''">
                        <div :class="errors.fio ? 'invalid-feedback' : ''" v-for="error in errors.fio">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="date" placeholder="дата рождения"  name="birthday" :class="errors.birthday ? 'is-invalid' : ''" style="color: #D9D9D9"  oninput="colorVal()">
                        <div :class="errors.birthday ? 'invalid-feedback' : ''" v-for="error in errors.birthday">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="text" placeholder="серия и номер паспорта"  name="passport" :class="errors.passport ? 'is-invalid' : ''" maxlength="10" onkeyup="this.value = this.value.replace(/[^\d]/g,'');">
                        <div :class="errors.passport ? 'invalid-feedback' : ''" v-for="error in errors.passport">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="text" placeholder="логин"  name="login" :class="errors.login ? 'is-invalid' : ''">
                        <div :class="errors.login ? 'invalid-feedback' : ''" v-for="error in errors.login">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="number" placeholder="телефон"  name="phone" :class="errors.phone ? 'is-invalid' : ''">
                        <div :class="errors.phone ? 'invalid-feedback' : ''" v-for="error in errors.phone">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="email" placeholder="email"  name="email" :class="errors.email ? 'is-invalid' : ''">
                        <div :class="errors.email ? 'invalid-feedback' : ''" v-for="error in errors.email">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="password" placeholder="пароль"  name="password" :class="errors.password ? 'is-invalid' : ''">
                        <div :class="errors.password ? 'invalid-feedback' : ''" v-for="error in errors.password">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="input-wrapper">
                        <input class="form__input  elem-form  form-control" type="password" placeholder="повторите пароль"  name="password_confirmation" :class="errors.phone ? 'is-invalid' : ''">
                        <div :class="errors.password ? 'invalid-feedback' : ''" v-for="error in errors.password">
                            <template  v-if="error == 'Пароли не совпадают'">
                                @{{ error }}
                            </template>
                        </div>
                    </div>
                    <div class="check">
                        <div class="check-wrapper">
                            <input class="check__input  form-check-input" type="checkbox" id="rules" name="rules" :class="errors.rules ? 'is-invalid' : ''">
                            <label class="check__label" for="rules">Согласие на обработку персональных данных</label>
                        </div>
                        <div :class="errors.rules ? 'invalid-feedback' : ''" v-for="error in errors.rules">
                            @{{ error }}
                        </div>
                    </div>
                    <button type="submit" class="col-6  btn" style="margin-top: 20px;">Зарегистрироватся</button>
                </form>
            </div>
        </div>
    </div>
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
        const Registration = {
            data() {
                return {
                    errors: [],
                }
            },
            methods:{
                async Registration() {
                    const form = document.querySelector('#formRegistration');
                    const formData = new FormData(form);
                    const response = await fetch('{{route('Registration')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN' : '{{csrf_token()}}',
                        },
                        body: formData
                    });
                    if(response.status === 400) {
                        this.errors = await response.json();
                        setTimeout(()=>{this.errors = []}, 20000);
                    }
                    if (response.status === 200) {
                        window.location = response.url;
                    }
                }
            }
        }
        Vue.createApp(Registration).mount('#Registration')
    </script>
@endsection
