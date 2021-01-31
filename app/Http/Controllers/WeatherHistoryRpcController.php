<?php

namespace App\Http\Controllers;

use App\Models\WeatherForecast;
use AvtoDev\JsonRpc\Errors\InvalidParamsError;
use AvtoDev\JsonRpc\Http\Controllers\RpcController;
use AvtoDev\JsonRpc\Requests\RequestInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class WeatherHistoryRpcController extends RpcController
{
    /**
     * Get weather of date.
     *
     * @param RequestInterface $request
     *
     * @return int
     */
    public function getByDate(RequestInterface $request)
    {
        $validator = Validator::make(
            json_decode(json_encode($request->getParams()), true),
            [
                'date' => 'required|date-format:Y-m-d'
            ]
        );
        if ($validator->fails()) {
            throw  new InvalidParamsError($validator->errors());
        }
        $date = $request->getParams()->date;
        return Cache::remember(
            "getByDateCache$date",
            0,
            function () use ($request, $date) {
                return WeatherForecast::where('date_at', $date)->first();
            }
        );
    }

    /**
     * Get info from request.
     *
     * @param RequestInterface \$request
     *
     * @return mixed[]
     */
    public function getHistory(RequestInterface $request): array
    {
        $validator = Validator::make(
            json_decode(json_encode($request->getParams()), true),
            [
                'lastDays' => 'required|integer'
            ]
        );
        if ($validator->fails()) {
            throw  new InvalidParamsError($validator->errors());
        }
        $lastDays = $request->getParams()->lastDays;
        $today = date('Y-d-m');
        return Cache::remember(
            "getHistoryCache$lastDays$today",
            3600,
            function () use ($request) {
                return WeatherForecast::query()->
                select('temp', 'date_at')->
                orderBy('date_at')->
                limit($request->getParams()->lastDays)->
                get()->all();
            }
        );
    }
}
