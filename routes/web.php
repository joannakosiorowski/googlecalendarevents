<?php
use Spatie\GoogleCalendar\Event;
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

Route::get('/', function () {
    return view('auth/login');
});



Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');



Route::group(['middleware'=>['auth']],function(){
    Route::post('/holiday', 'HolidayController@addDate')->name('adddate');
    Route::get('/holiday', 'HolidayController@show')->name('showdate');
    Route::get('/showHolidays', 'HolidayController@setDate')->name('setdate');
    Route::post('/deleteholiday/{id}', 'HolidayController@destroy')->name('destroy.holidaydate');
    Route::post('/destoryjackpot/{id}', 'EventController@destroyjackpot')->name('destroy.holidayjackpot');
    Route::get('/test', 'HolidayController@sendErrorMsg')->name('errmessage');
    Route::get('/holidayjackpot', 'EventController@showHolidayJacpot')->name('holidayjackpot');
    Route::get('/workhours','EventController@index')->name('workhours');
    Route::match(['GET', 'POST'], trans('report'),'EventController@getAll')->name('report'); 
    Route::get('/manageholidays', 'HolidayController@manageHolidays')->name('manageholidays');
    Route::post('/confirm/{id}','HolidayController@confirm')->name('confirm');
    Route::get('/sickleave', 'SickleaveController@store')->name('sickleave');
    
    });