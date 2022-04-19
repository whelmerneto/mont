<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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


Route::get('/',[ 'as' => 'login.form', 'uses' => 'AcessoController@login_form' ]);

// Route::any("login",function(Request $request){
//     $request->session()->put('authenticated', time());
//     $request->session()->put('dados', [
//         "dd"=>1
//     ]);

//     return redirect("teste");
// });

Route::any("login",[ 'as' => 'login.post', 'uses' => 'AcessoController@auth_login' ]);

Route::group(['middleware' => ['web', 'custom_auth']], function () {

    #   Rota de recebimento das credenciais e exibição das montagens
    Route::get('/index',[ 'as' => 'login.post', 'uses' => 'AcessoController@index' ]);
    #   Rota de recebimento das montagens a serem Agendadas e agendamento de montagens
    Route::any('/agendamento', ['as' => 'agendamento', 'uses' => 'AcessoController@agendamento']);
    #   Rota de recebimento das datas para o Agendamento(s) e exibição da tela de exibição
    Route::any('/confirmacao', ['as' => 'confirmacao', 'uses' => 'AcessoController@confirmar']);
    #   Rota de acompanhamento de montagem ja agendada 
    Route::get('/acompanhar/{id}', ['as' => 'acompanhar', 'uses' => 'AcessoController@acompanhar']);
    #   Rota teste
    Route::get('/reagendamento', ['as' => 'reagendamento', 'uses' => 'AcessoController@reagendamento']);

    Route::post('/reagendar', ['as' => 'reagendar', 'uses' => 'AcessoController@reagendar']);

    Route::get('/confirmado', ['as' => 'confirmado', 'uses' => 'AcessoController@confirmado']);
});

Route::get('erro',function(){
    return view('landing_page.error', ['slt_favorecido' => "Eudes"]);
});

