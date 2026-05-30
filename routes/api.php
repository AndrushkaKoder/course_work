<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\Redis;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/metrics', function () {
    $adapter = new Redis([
        'host' => config('database.redis.default.host', 'redis'),
        'port' => (int) config('database.redis.default.port', 6379),
        'password' => config('database.redis.default.password', null),
        'timeout' => 0.1, // в секундах
        'read_timeout' => 10,
        'persistent_connections' => false
    ]);

    $registry = new CollectorRegistry($adapter);

    $renderer = new RenderTextFormat();
    $result = $renderer->render($registry->getMetricFamilySamples());

    return response($result, 200)
        ->header('Content-Type', RenderTextFormat::MIME_TYPE);
});
