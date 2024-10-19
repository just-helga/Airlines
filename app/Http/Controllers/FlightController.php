<?php

namespace App\Http\Controllers;

use App\Models\Air;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $airports_all = Airport::all();
        return response()->json([
            'airports_all' => $airports_all,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'from_city_id' => ['required'],
            'from_airport_id' => ['required'],
            'to_city_id' => ['required'],
            'to_airport_id' => ['required'],
            'date_from' => ['required', 'date'],
            'time_from' => ['required'],
            'date_to' => ['required', 'date'],
            'time_to'=> ['required'],
            'air_id' => ['required'],
            'percent_price' => ['required', 'numeric', 'between:1,100']
        ],[
            'from_city_id.required' => 'Обязательное поле',
            'from_airport_id.required' => 'Обязательное поле',
            'to_city_id.required' => 'Обязательное поле',
            'to_airport_id.required' => 'Обязательное поле',
            'date_from.required' => 'Обязательное поле',
            'date_from.date' => 'Тип данных - дата',
            'time_from.required' => 'Обязательное поле',
            'date_to.required' => 'Обязательное поле',
            'date_to.date' => 'Тип данных - дата',
            'time_to.required' => 'Обязательное поле',
            'air_id.required' => 'Обязательное поле',
            'percent_price.required' => 'Обязательное поле',
            'percent_price.numeric' => 'Тип данных - числовой',
            'percent_price.between' => 'Разрешенный диапазон цены от 1 до 100',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $date_from = $request->date_from . ' ' . $request->time_from;
        $date_to = $request->date_to . ' ' . $request->time_to;
        $time_way = strtotime($date_to) - strtotime($date_from);
        $hours = floor($time_way / 3600);
        $minutes = floor(($time_way / 60) % 60);

        $flight = new Flight();
        $flight->from_city_id = $request->from_city_id;
        $flight->from_airport_id = $request->from_airport_id;
        $flight->to_city_id = $request->to_city_id;
        $flight->to_airport_id = $request->to_airport_id;
        $flight->date_from = $request->date_from;
        $flight->time_from = $request->time_from;
        $flight->date_to = $request->date_to;
        $flight->time_to = $request->time_to;
        $flight->air_id = $request->air_id;
        $flight->percent_price = $request->percent_price;
        $flight->status = 'новый';
        $flight->time_way = $hours . 'ч ' . $minutes . 'мин';
        $flight->save();

        for ($i = 1; $i<=$flight->air->count_seat; $i++) {
            $ticket = new Ticket();
            $ticket->flight_id = $flight->id;
            $ticket->seat = $i;
            $price = $flight->air->price / $flight->air->count_seat;
            $ticket->price = round(($price + ($price / 100) + $flight->percent_price), 0, PHP_ROUND_HALF_UP);
            $ticket->save();
        }

        return redirect()->route('FlightsPage');
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
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function show(Flight $flight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function edit(Flight $flight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flight $flight)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flight $flight)
    {
        $flight->delete();
        return redirect()->route('FlightsPage');
    }
}
