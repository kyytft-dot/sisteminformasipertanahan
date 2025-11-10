<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\PolygonController;
use App\Http\Controllers\PolylineController;
use App\Http\Controllers\MarkerController;

// ============================================================
// File: routes/api.php
// ============================================================

// Penduduk Routes
Route::prefix('penduduk')->group(function () {
Route::get('/penduduk', [\App\Http\Controllers\PendudukController::class, 'index']);
Route::post('/penduduk', [\App\Http\Controllers\PendudukController::class, 'store']);
Route::get('/penduduk/{id}', [\App\Http\Controllers\PendudukController::class, 'show']);
Route::put('/penduduk/{id}', [\App\Http\Controllers\PendudukController::class, 'update']);
Route::delete('/penduduk/{id}', [\App\Http\Controllers\PendudukController::class, 'destroy']);
});

// Polygon Routes
Route::prefix('polygon')->group(function () {
Route::get('/polygon', [\App\Http\Controllers\PolygonController::class, 'index']);
Route::post('/polygon', [\App\Http\Controllers\PolygonController::class, 'store']);
Route::get('/polygon/{id}', [\App\Http\Controllers\PolygonController::class, 'show']);
Route::put('/polygon/{id}', [\App\Http\Controllers\PolygonController::class, 'update']);
Route::delete('/polygon/{id}', [\App\Http\Controllers\PolygonController::class, 'destroy']);
});

// Polyline Routes
Route::prefix('polyline')->group(function () {
Route::get('/polyline', [\App\Http\Controllers\PolylineController::class, 'index']);
Route::post('/polyline', [\App\Http\Controllers\PolylineController::class, 'store']);
Route::get('/polyline/{id}', [\App\Http\Controllers\PolylineController::class, 'show']);
Route::put('/polyline/{id}', [\App\Http\Controllers\PolylineController::class, 'update']);
Route::delete('/polyline/{id}', [\App\Http\Controllers\PolylineController::class, 'destroy']);
});

// Marker Routes
Route::prefix('marker')->group(function () {
Route::get('/marker', [\App\Http\Controllers\MarkerController::class, 'index']);
Route::post('/marker', [\App\Http\Controllers\MarkerController::class, 'store']);
Route::get('/marker/{id}', [\App\Http\Controllers\MarkerController::class, 'show']);
Route::put('/marker/{id}', [\App\Http\Controllers\MarkerController::class, 'update']);
Route::delete('/marker/{id}', [\App\Http\Controllers\MarkerController::class, 'destroy']);
});
