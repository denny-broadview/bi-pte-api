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

// $router->group(['prefix' => 'api/'], function () use ($router){
	// $router->post('demo-test',  ['uses' => 'UsersController@demoTest']);
	Route::post('login', ['uses' => 'UsersController@login']);
	Route::post('forget-password',  ['uses'=>'UsersController@forgetPassword']);
// });
$router->group(['middleware'=>'auth'], function () use ($router){
	Route::post('certificates', ['uses' => 'CertificatesController@getCertificate']);

	Route::post('getTest', ['uses' => 'TestsController@getTest']);
	Route::post('getCompletedPendingTest', ['uses' => 'TestsController@getCompletedPendingTest']);

	Route::post('testResults', ['uses' => 'TestResultsController@getTestResult']);

	Route::post('sections', ['uses' => 'SectionsController@getSection']);
	Route::post('sectionsDesign', ['uses' => 'SectionsController@sectionWiseDesign']);

	Route::post('video', ['uses' => 'VideosController@getVideo']);

	Route::post('predictionfiles', ['uses' => 'PredictionFilesController@getPrediction']);
});