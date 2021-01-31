<?php

use Illuminate\Support\Facades\Route;
use AvtoDev\JsonRpc\RpcRouter;

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

RpcRouter::on('weather.getHistory', 'App\\Http\\Controllers\\WeatherHistoryRpcController@getHistory');
RpcRouter::on('weather.getByDate', 'App\\Http\\Controllers\\WeatherHistoryRpcController@getByDate');
RpcRouter::on('weather.getById', 'App\\Http\\Controllers\\WeatherHistoryRpcController@show');

Route::middleware('api')->post(
    '/rpc',
    'App\\Http\\Controllers\\WeatherHistoryRpcController'
);

