<?php

namespace App\Http\Controllers;

use App\Models\Air;
use App\Models\Airport;
use App\Models\City;
use App\Models\Flight;
use App\Models\Ticket;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //---ОБЩИЕ СТРАНИЦЫ
    public function MainPage() {
//        $info =[];
//        $helpArr = [];
//        $popular = [];
//        $flights = Flight::all();
//        if (count($flights) >= 4) {
//            foreach ($flights as $flight) {
//                $count = 0;
//                $tickets = Ticket::query()->where('flight_id', $flight->id)->where('user_id', null)->count();
//                $helpArr = [
//                    'flight' => $flights,
//                    'count' => $tickets
//                ];
//                array_push($info, $helpArr);
//            }
//            for ($i = 0; $i < 4; $i++) {
//                $max = max($info);
//                array_push($helpArr, $max);
//                if (($key = array_search($max, $info)) !== false) {
//                    unset($info[$key]);
//                }
//            }
//        }

        $flights = Flight::all();
        $cities = City::all();
        return view('welcome', ['flights'=>$flights, 'cities'=>$cities]);
    }

    public function AuthorizationPage() {
        return view('guest.authorization');
    }
    public function RegistrationPage() {
        return view('guest.registration');
    }

    public function FlightsPage() {
        $flights = Flight::all();
        $cities = City::all();
        $tickets = Ticket::all();
        return view('flight', ['flights'=>$flights, 'cities'=>$cities, 'tickets'=>$tickets]);
    }

    public function ChoosePlacePage(Flight $flight) {
        $cities = City::all();
        $tickets = Ticket::query()
            ->where('flight_id', $flight->id)
            ->get();
        return view('ticket', ['flight'=>$flight, 'cities'=>$cities, 'tickets'=>$tickets]);
    }




    //---СТРАНИЦЫ АДМИНА
    public function CitiesPage() {
        $cities = City::all();
        return view('admin.city.main', ['cities'=>$cities]);
    }
    public function CityAddPage() {
        return view('admin.city.add');
    }
    public function CityEditPage(City $city) {
        return view('admin.city.edit', ['city'=>$city]);
    }


    public function AirportAddPage(City $city) {
        return view('admin.airport.add', ['city'=>$city]);
    }
    public function AirportEditPage(Airport $airport) {
        return view('admin.airport.edit', ['airport'=>$airport]);
    }


    public function AirsPage() {
        $airs = Air::all();
        return view('admin.air.main', ['airs'=>$airs]);
    }
    public function AirAddPage() {
        return view('admin.air.add');
    }
    public function AirEditPage(Air $air) {
        return view('admin.air.edit', ['air'=>$air]);
    }


    public function FlightsAddPage() {
        $cities = City::all();
        $airports = Airport::all();
        $airs = Air::all();
        return view('admin.flight.add', ['airports'=>$airports, 'cities'=>$cities, 'airs'=>$airs]);
    }
}
