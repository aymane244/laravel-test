<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

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


Route::get('/clear-cache', function() {
    Artisan::call('config:clear');
    // Artisan::call('cache:clear');
    // Artisan::call('view:clear');
    // Artisan::call('config:cache');
    
    
     // Artisan::call('route:cache');
    return "cleared";
});

Route::get('/', function () {
     Artisan::call('config:clear');
    return view('index');
});

Route::get('/notifications', 'EntrepriseController@notifications')->name('notifications')->middleware('auth.CheckAuthIsUser');
Route::get('/notify', 'EntrepriseController@notify')->name('notify')->middleware('auth.CheckAuthIsUser');

// contact us
Route::post('contact', 'EntrepriseController@contact')->name('contact_us');

// Auth::routes();
Auth::routes(['verify'=> true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/lang/{lang}', 'EntrepriseController@lang')->name('lang');


Route::get('/calendar', 'EntrepriseController@calendar')->name('calender')->middleware('auth.CheckAuthIsUser');
Route::resource('events','EventsController')->middleware('auth.CheckAuthIsUser');
Route::resource('recommandation','RecommandationController')->middleware('auth.CheckAuthIsUser');
Route::resource('entreprises','EntrepriseController')->middleware('auth.CheckAuthIsUser');

Route::resource('dashboard','DashboardController')->middleware('auth.CheckAuthIsAdmin');;
Route::get('/admin/dashboard', 'DashboardController@index')->name('dashboard.index')->middleware('auth.CheckAuthIsAdmin');;
Route::get('/admin/List/contacts', 'DashboardController@contacts')->name('dashboard.contacts')->middleware('auth.CheckAuthIsAdmin');
Route::post('/admin/List/contacts/destroy', 'DashboardController@destroy_contacts')->name('dashboard.destroy_contacts')->middleware('auth.CheckAuthIsAdmin');
Route::get('/admin/Profile/Admin', 'DashboardController@profile')->name('dashboard.profile')->middleware('auth.CheckAuthIsAdmin');
Route::get('/admin', function () {
    return view('dashboard.login');
});

// chat one to one
Route::get('/chat', 'ChatController@index')->name('chat')->middleware('auth.CheckAuthIsUser');
Route::get('/chat/{id}', 'ChatController@getMessage')->name('chat_messsage')->middleware('auth.CheckAuthIsUser');
Route::post('chat', 'ChatController@sendMessage')->middleware('auth.CheckAuthIsUser');

// Chat Groupe

Route::get('/chat_groupe', 'ChatGroupController@index')->name('chat_groupe')->middleware('auth.CheckAuthIsUser');

Route::post('chat_groupe', 'ChatGroupController@sendMessage')->middleware('auth.CheckAuthIsUser');  //
Route::get('/message/{id}', 'ChatGroupController@getMessage')->name('message')->middleware('auth.CheckAuthIsUser');
Route::get('/ShowMassage/{id}', 'ChatGroupController@ShowMassage')->middleware('auth.CheckAuthIsUser');
Route::get('/messag/{id}', 'ChatGroupController@getMessag')->name('message')->middleware('auth.CheckAuthIsUser');
Route::get('/subscribe', 'ChatGroupController@subscribe')->middleware('auth.CheckAuthIsUser');
Route::post('/unFollow', 'ChatGroupController@remove_user')->middleware('auth.CheckAuthIsUser');
/////////////////////
Route::get('/group/create', 'GroupController@create_form')->middleware('auth.CheckAuthIsUser');
Route::post('/group/create', 'GroupController@create')->middleware('auth.CheckAuthIsUser');
Route::get('/group/join', 'GroupController@join_form')->middleware('auth.CheckAuthIsUser');
Route::post('/group/join', 'GroupController@join')->middleware('auth.CheckAuthIsUser');

Route::get('/confirmer_demande', 'GroupController@confirmer_demande')->middleware('auth.CheckAuthIsUser');
Route::post('/join/valider', 'GroupController@valider_demande')->middleware('auth.CheckAuthIsUser');
Route::post('/join/delete', 'GroupController@supprimer_demande')->middleware('auth.CheckAuthIsUser');

Route::get('/group/edit/{id}', 'GroupController@edit')->middleware('auth.CheckAuthIsUser');

Route::post('/group/update/{id}', 'GroupController@update')->middleware('auth.CheckAuthIsUser');

Route::post('/group/delete', 'GroupController@deleteGroup')->middleware('auth.CheckAuthIsUser');

Route::get('/group/members_list/{id}', 'GroupController@members_list')->middleware('auth.CheckAuthIsUser');

Route::post('/remove_user/{id}', 'GroupController@remove_user')->middleware('auth.CheckAuthIsUser');
