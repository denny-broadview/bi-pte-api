<?php
use Illuminate\Support\Facades\Route;
/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });
Route::get('/', function () use ($router) {
    return $router->app->version();
});
// Route::get('/', function () {
//     // return view('page_not_found');
//     return "hiii";
//     //return view('welcome');
// });

// $router->post('demo-test',  ['uses' => 'UsersController@demoTest']);
Route::get('video', ['uses' => 'VideosController@index']);
Route::get('predictionfiles', ['uses' => 'PredictionFilesController@index']);