<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\JogadorController;
use App\Http\Controllers\CadastroController;




Route::get('/bateu', function () {
    return response()->json(['message' => 'Bateu']);
});

Route::post('/cadastro', [CadastroController::class, 'store']);


Route::get('/times', [TimeController::class, 'index']);  
Route::post('/times', [TimeController::class, 'store']);  
Route::get('/times/{id}', [TimeController::class, 'show']);  
Route::put('/times/{id}', [TimeController::class, 'update']);  
Route::delete('/times/{id}', [TimeController::class, 'destroy']);  

Route::get('/times/{id}/jogadores', [TimeController::class, 'jogadores']);

Route::get('/jogadores', [JogadorController::class, 'index']); 
Route::post('/jogadores', [JogadorController::class, 'store']);  
Route::get('/jogadores/{id}', [JogadorController::class, 'show']);  
Route::put('/jogadores/{id}', [JogadorController::class, 'update']);  
Route::delete('/jogadores/{id}', [JogadorController::class, 'destroy']);  
