<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'kepala_sekolah' => \App\Http\Middleware\KepalaSekolahMiddleware::class,
            'kesiswaan' => \App\Http\Middleware\KesiswaanMiddleware::class,
            'bimbingan_konseling' => \App\Http\Middleware\BimbinganKonselingMiddleware::class,
            'guru' => \App\Http\Middleware\GuruMiddleware::class,
            'orang_tua' => \App\Http\Middleware\OrangTuaMiddleware::class,
            'siswa' => \App\Http\Middleware\SiswaMiddleware::class,
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
