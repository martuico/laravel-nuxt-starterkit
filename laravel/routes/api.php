<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/** @var \Dingo\Api\Routing\Router $api */
$api = app('Dingo\Api\Routing\Router');
$api
    ->version('v2', function ($api) {
        $api->group([
            'middleware' => 'auth:api',
        ], function ($api) {
            $api->resource('users', \App\BunkerMaestro\UserManagement\Controllers\UserController::class, ['only' => ['index', 'store', 'show']]);
        });
    });
