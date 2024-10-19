<?php

use App\Http\Controllers\AirController;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



//---СТРАНИЦЫ
Route::get('/', [PageController::class, 'MainPage'])->name('MainPage');

Route::get('/authorization', [PageController::class, 'AuthorizationPage'])->name('login');
Route::get('/registration', [PageController::class, 'RegistrationPage'])->name('RegistrationPage');

Route::get('/flights', [PageController::class, 'FlightsPage'])->name('FlightsPage');




//---ФУНКЦИИ
Route::post('/registration/save', [UserController::class, 'Registration'])->name('Registration');
Route::post('/authorization/entry', [UserController::class, 'Authorization'])->name('Authorization');
Route::get('/exit', [UserController::class, 'Exit'])->name('Exit');

Route::get('/flights/get', [FlightController::class, 'index'])->name('GetAirports');
Route::get('/flight/choose/{flight}', [PageController::class, 'ChoosePlacePage'])->name('ChoosePlacePage');

Route::post('/ticket/registration', [TicketController::class, 'edit'])->name('RegistrationPlace');




//---АДМИНКА
Route::group(['middleware'=>['auth', 'admin'], 'prefix'=>'xxxxxx/admin'], function () {
    //---города
    Route::get('/cities', [PageController::class, 'CitiesPage'])->name('CitiesPage');
    Route::get('/city/add', [PageController::class, 'CityAddPage'])->name('CityAddPage');
    Route::get('/city/edit/{city}', [PageController::class, 'CityEditPage'])->name('CityEditPage');

    Route::post('/city/add/save', [CityController::class, 'create'])->name('CityAdd');
    Route::post('/city/edit/save', [CityController::class, 'update'])->name('CityEdit');
    Route::delete('/city/delete/{city}', [CityController::class, 'destroy'])->name('CityDelete');


    //---аэропорты
    Route::get('/airport/add/{city}', [PageController::class, 'AirportAddPage'])->name('AirportAddPage');
    Route::get('/airport/edit/{airport}', [PageController::class, 'AirportEditPage'])->name('AirportEditPage');

    Route::post('/airport/add/save', [AirportController::class, 'create'])->name('AirportAdd');
    Route::post('/airport/edit/save', [AirportController::class, 'update'])->name('AirportEdit');
    Route::delete('/airport/delete/{airport}', [AirportController::class, 'destroy'])->name('AirportDelete');


    //---самолеты
    Route::get('/airs', [PageController::class, 'AirsPage'])->name('AirsPage');
    Route::get('/air/add', [PageController::class, 'AirAddPage'])->name('AirAddPage');
    Route::get('/air/edit/{air}', [PageController::class, 'AirEditPage'])->name('AirEditPage');

    Route::post('/air/add/save', [AirController::class, 'create'])->name('AirAdd');
    Route::post('/air/edit/save', [AirController::class, 'update'])->name('AirEdit');
    Route::delete('/air/delete/{air}', [AirController::class, 'destroy'])->name('AirDelete');


    //---рейсы
    Route::get('/flight/add', [PageController::class, 'FlightsAddPage'])->name('FlightsAddPage');
//    Route::get('/flight/edit/{flight}', [PageController::class, 'FlightsEditPage'])->name('FlightsEditPage');
//
    Route::post('/flight/add/save', [FlightController::class, 'create'])->name('FlightAdd');
//    Route::post('/flight/edit/save', [FlightController::class, 'update'])->name('FlightsEdit');
    Route::delete('/flight/delete/{flight}', [FlightController::class, 'destroy'])->name('FlightDelete');
});
