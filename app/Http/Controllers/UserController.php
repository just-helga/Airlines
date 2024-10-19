<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function Registration(Request $request) {
        $validate = Validator::make($request->all(), [
            'fio' => ['required', 'regex:/[А-Яа-яЁё-]/u'],
            'birthday' => ['required', 'date'],
            'passport' => ['required', 'numeric', 'min:10'],
            'login' => ['required', 'regex:/[A-Za-z0-9-]/u', 'unique:users'],
            'phone' => ['required', 'regex:/[0-9]{10,11}/u',  'numeric'],
            'email' => ['required', 'email:frs', 'unique:users'],
            'password' => ['required', 'min:6', 'max:20', 'confirmed'],
            'rules'=> ['required']
        ],[
            'fio.required' => 'Обязательное поле',
            'fio.regex' => 'Может содержать только кириллицу, пробел и тире',
            'birthday.required' => 'Обязательное поле',
            'birthday.date' => 'Тип данных - дата',
            'passport.required' => 'Обязательное поле',
            'passport.numeric' => 'Тип данных - числовой',
            'passport.min' => 'Должно содержать серию и номер паспорта',
            'login.required' => 'Обязательное поле',
            'login.regex' => 'Может содержать только латиницу, цифры и тире',
            'login.unique'=>'Пользователь с указанным логином уже зарегистрирован',
            'phone.required' => 'Обязательное поле',
            'phone.numeric' => 'Тип данных - числовой',
            'phone.regex' => 'Разрешенный формат: 7(8)1234567890, 1234567890',
            'email.required'=>'Обязательное поле',
            'email.email'=>'Поле должно содержать адрес электронной почты',
            'email.unique'=>'Пользователь с указанным адресом электронной почты уже зарегистрирован',
            'password.required'=>'Обязательное поле',
            'password.min'=>'Минимальная длина пароля 6 симоволов',
            'password.max'=>'Максимальная длина пароля 20 символов',
            'password.confirmed'=>'Пароли не совпадают',
            'rule.required'=>'Поставьте галочку для согласие обработки персональных данных',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $user = new User();
        $user->fio = $request->fio;
        $user->birthday = $request->birthday;
        $user->passport = $request->passport;
        $user->login = $request->login;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = md5($request->password);

        $user->save();
        return redirect()->route('login');
    }



    public function Authorization(Request $request) {
        $validate = Validator::make($request->all(), [
            'login'=>['required'],
            'password'=>['required']
        ],[
            'login.required'=>'Обязательное поле',
            'password.required'=>'Обязательное поле'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $user = User::query()
            ->where('login', $request->login)
            ->where('password', md5($request->password))
            ->first();

        if ($user) {
            Auth::login($user);
            return redirect()->route('MainPage');
        } else {
            return response()->json('Неверный логин или пароль', 403);
        }
    }



    public function Exit() {
        Auth::logout();
        return redirect()->route('login');
    }
}
