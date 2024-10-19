<?php

namespace App\Http\Controllers;

use App\Models\Air;
use App\Models\Airport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AirController extends Controller
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
    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title'=>['required'],
            'count_seat'=>['required', 'numeric', 'between:12,48'],
            'price' => ['required', 'numeric', 'between:1,999999'],
        ],[
            'title.required'=>'Обязательное поле',
            'count_seat.required'=>'Обязательное поле',
            'count_seat.numeric' => 'Тип данных - числовой',
            'count_seat.between' => 'Разрешенный диапазон кол-ва мест от 12 до 48',
            'price.required'=>'Обязательное поле',
            'price.numeric' => 'Тип данных - числовой',
            'price.between' => 'Разрешенный диапазон цены от 1 до 999999',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $air = new Air();
        $air->title = $request->title;
        $air->count_seat = $request->count_seat;
        $air->price = $request->price;
        $air->save();

        return redirect()->route('AirsPage');
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
     * @param  \App\Models\Air  $air
     * @return \Illuminate\Http\Response
     */
    public function show(Air $air)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Air  $air
     * @return \Illuminate\Http\Response
     */
    public function edit(Air $air)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Air  $air
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Air $air)
    {
        $validate = Validator::make($request->all(), [
            'title'=>['required'],
            'count_seat'=>['required', 'numeric', 'between:12,48'],
            'price' => ['required', 'numeric', 'between:1,999999'],
        ],[
            'title.required'=>'Обязательное поле',
            'count_seat.required'=>'Обязательное поле',
            'count_seat.numeric' => 'Тип данных - числовой',
            'count_seat.between' => 'Разрешенный диапазон кол-ва мест от 12 до 48',
            'price.required'=>'Обязательное поле',
            'price.numeric' => 'Тип данных - числовой',
            'price.between' => 'Разрешенный диапазон цены от 1 до 999999',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $air = Air::query()->where('id', $request->id)->first();
        $air->title = $request->title;
        $air->count_seat = $request->count_seat;
        $air->price = $request->price;
        $air->update();

        return redirect()->route('AirsPage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Air  $air
     * @return \Illuminate\Http\Response
     */
    public function destroy(Air $air)
    {
        $air->delete();
        return redirect()->back();
    }
}
