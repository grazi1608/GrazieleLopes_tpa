<?php

use App\Http\Controllers\EventoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventoController::class, 'index'])
    ->name('eventos.index');

Route::get('/eventos/criar', [EventoController::class, 'create'])
    ->name('eventos.create')
    ->middleware('auth');

Route::post('/eventos', [EventoController::class, 'store'])
    ->name('eventos.store')
    ->middleware('auth');

Route::get('/eventos/{evento}', [EventoController::class, 'show'])
    ->name('eventos.show');

Route::post('/eventos/{evento}/perguntas', [EventoController::class, 'storePergunta'])
    ->name('eventos.perguntas.store');

Route::delete('/perguntas/{pergunta}', [EventoController::class, 'destroyPergunta'])
    ->name('perguntas.destroy');

Route::post('/perguntas/{pergunta}/votar', [App\Http\Controllers\EventoController::class, 'votar'])
    ->name('perguntas.votar')
    ->middleware('auth'); 

