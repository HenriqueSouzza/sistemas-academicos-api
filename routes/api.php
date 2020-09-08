<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resources([
    '/canal-direto/ticket'              => 'Api\CanalDireto\TicketController',
    '/canal-direto/interacao-ticket'    => 'Api\CanalDireto\InteracaoTicketController',
    '/canal-direto/papeis'              => 'Api\CanalDireto\PapeisController',
    '/canal-direto/setor'               => 'Api\CanalDireto\SetorController',
    '/canal-direto/categoria'           => 'Api\CanalDireto\CategoriaController',
    '/canal-direto/formularios'         => 'Api\CanalDireto\FormulariosController',
    '/canal-direto/campos'              => 'Api\CanalDireto\CamposFormsController',
    '/canal-direto/campos-formularios'  => 'Api\CanalDireto\CamposFormulariosController',
    '/canal-direto/status-ticket'       => 'Api\CanalDireto\StatusTicketController',
]);