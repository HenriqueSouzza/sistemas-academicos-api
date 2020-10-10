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

Route::group(['middleware' => ['auth:api', 'check.user.acl']], function() {
    
    Route::resources([
        '/canal-direto/ticket'                  => 'Api\CanalDireto\TicketController',
        '/canal-direto/interacao-ticket'        => 'Api\CanalDireto\InteracaoTicketController',
        '/canal-direto/setor'                   => 'Api\CanalDireto\SetorController',
        '/canal-direto/categoria'               => 'Api\CanalDireto\CategoriaController',
        '/canal-direto/formularios'             => 'Api\CanalDireto\FormulariosController',
        '/canal-direto/campos'                  => 'Api\CanalDireto\CamposFormsController',
        '/canal-direto/campos-formularios'      => 'Api\CanalDireto\CamposFormulariosController',
        '/canal-direto/status-ticket'           => 'Api\CanalDireto\StatusTicketController',
        '/canal-direto/categoria-papeis'        => 'Api\CanalDireto\CategoriaPapeisController',
        '/canal-direto/menus'                   => 'Api\CanalDireto\MenuController',
        '/canal-direto/submenus'                => 'Api\CanalDireto\SubMenuController',
        '/usuarios'                             => 'Api\UserController',
        '/papeis'                               => 'Api\PapeisController',
        '/permissoes'                           => 'Api\PermissoesController',
        '/sistemas'                             => 'Api\SistemasController',
    ]);

    Route::get('/permissoes/update/all', 'Api\PermissoesController@updateAllPermissions');
        
});

Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@register');
// Route::post('callback', 'Api\UserController@callback');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('logout', 'Api\UserController@logout');
    Route::get('user', 'Api\UserController@user');
});