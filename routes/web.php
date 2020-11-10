<?php

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
    return view('welcome');
});

// Auth::routes();

Route::get('/checkout', 'AuthController@checkout');
// Route::get('/redirect', 'AuthController@redirect');
Route::get('/callback', 'AuthController@callback');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/mailable', function () {
    
    $ticket     = App\Models\CanalDireto\Ticket::findOrFail("24");

    $categoria  = App\Models\CanalDireto\Categoria::findOrFail("1");

    $setor      = App\Models\CanalDireto\Setor::findOrFail("1");

    $interacao  = App\Models\CanalDireto\InteracaoTicket::findOrFail('1');
    //InteracaoTicket($ticket)

    //var_dump($setor);
    //Mail::to('henrique.lindao10@gmail.com')->send(new InteracaoTicket($ticket));
    
    //$user = App\User::find(1);
    return new App\Mail\InteracaoTicketEmail($ticket, $categoria, $setor, $interacao);

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/mailable2', function () {
    


    $ticket = App\Models\CanalDireto\Ticket::findOrFail("1");

    $categoria = App\Models\CanalDireto\Categoria::findOrFail($ticket->ID_CATEGORIA);

    $setor = App\Models\CanalDireto\Setor::findOrFail($ticket->ID_SETOR);
    //InteracaoTicket($ticket)

    //var_dump($ticket);
    //Mail::to('henrique.lindao10@gmail.com')->send(new InteracaoTicket($ticket));
    
    //$user = App\User::find(1);
    return new App\Mail\TicketEmail($ticket, $categoria, $setor);
});
