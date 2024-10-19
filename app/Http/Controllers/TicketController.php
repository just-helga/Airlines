<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket, Request $request)
    {
        $validate = Validator::make($request->all(),[
            'fio'=>['required', 'regex:/[А-Яа-яЁё-]/u'],
            'birthday'=>['required', 'date'],
            'passport'=>['required', 'numeric', 'min:10'],
            'password'=>['required'],
            'rules'=> ['required']
        ],[
            'fio.required' => 'Обязательное поле',
            'fio.regex' => 'Может содержать только кириллицу, пробел и тире',
            'birthday.required' => 'Обязательное поле',
            'birthday.date' => 'Тип данных - дата',
            'passport.required' => 'Обязательное поле',
            'passport.numeric' => 'Тип данных - числовой',
            'passport.min' => 'Должно содержать серию и номер паспорта',
            'password.required'=>'Обязательное поле',
            'rules.required'=>'Поставьте галочку для согласие обработки персональных данных',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $user = User::query()->where('id', Auth::id())->first();

        if ($user->password === md5($request->password)) {
            $ticket = Ticket::query()->where('seat', $request->seat)->where('flight_id', $request->flight_id)->first();
            $ticket->user_id = $user->id;
            $ticket->fio = $request->fio;
            $ticket->birthday = $request->birthday;
            $ticket->passport = $request->passport;

            if ($request->certificate !== '') {
                $ticket->certificate = $request->certificate;
            }

            $ticket->update();
            return redirect()->route('MainPage');
        } else {
            return response()->json('Пароль неверный', 403);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
