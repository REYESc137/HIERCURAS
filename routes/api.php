<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

use App\Http\Controllers\Api\DescubridoresController;
use App\Http\Controllers\Api\EspRelacController;
use App\Http\Controllers\Api\FamiliaController;
use App\Http\Controllers\Api\PlantasController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Api\RecetasController;

// Rutas para Descubridores
Route::get('/descubridores', [DescubridoresController::class, 'index']);
Route::post('/descubridores', [DescubridoresController::class, 'create']);
Route::patch('/descubridores/{id}', [DescubridoresController::class, 'update']);
Route::delete('/descubridores/{id}', [DescubridoresController::class, 'delete']);

// Rutas para EspRelac
Route::get('/esp-relac', [EspRelacController::class, 'index']);
Route::post('/esp-relac', [EspRelacController::class, 'create']);
Route::patch('/esp-relac/{id}', [EspRelacController::class, 'update']);
Route::delete('/esp-relac/{id}', [EspRelacController::class, 'delete']);

// Rutas para Familia
Route::get('/familia', [FamiliaController::class, 'index']);
Route::post('/familia', [FamiliaController::class, 'create']);
Route::patch('/familia/{id}', [FamiliaController::class, 'update']);
Route::delete('/familia/{id}', [FamiliaController::class, 'delete']);

// Rutas para Plantas
Route::get('/plantas', [PlantasController::class, 'index']);
Route::post('/plantas', [PlantasController::class, 'create']);
Route::patch('/plantas/{id}', [PlantasController::class, 'update']);
Route::delete('/plantas/{id}', [PlantasController::class, 'delete']);

Route::get('/recetas', [RecetasController::class, 'index']);
Route::post('/recetas', [RecetasController::class, 'create']);
Route::patch('/recetas/{id}', [RecetasController::class, 'update']);
Route::delete('/recetas/{id}', [RecetasController::class, 'delete']);


