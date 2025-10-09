<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AyatController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\CpController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\FaseController;
use App\Http\Controllers\Api\HadistController;
use App\Http\Controllers\Api\HasilKuisController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\JenisTemaController;
use App\Http\Controllers\Api\KaidahController;
use App\Http\Controllers\Api\KuisController;
use App\Http\Controllers\Api\MapelController;
use App\Http\Controllers\Api\PertanyaanController;
use App\Http\Controllers\Api\RefleksiController;
use App\Http\Controllers\Api\TemaController;
use Illuminate\Support\Facades\Route;

Route::get('/hello', function () {
    return response()->json([
        'message' => 'Hello, World!',
    ]);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});

Route::post('/chat/sendMessage', [ChatController::class, 'sendMessage']);

Route::get('/home', [HomeController::class, 'index']);

Route::post('/device/create', [DeviceController::class, 'create']);

Route::get('/device/{id}', [DeviceController::class, 'show']);

Route::resource('/fase', FaseController::class);
Route::resource('/tema', TemaController::class);
Route::resource('/refleksi', RefleksiController::class);
Route::resource('/cp', CpController::class);
Route::resource('/mapel', MapelController::class);
Route::resource('/jenis-tema', JenisTemaController::class);
Route::resource('/kaidah', KaidahController::class);
Route::resource('/hadist', HadistController::class);
Route::resource('/ayat', AyatController::class);
Route::resource('/kuis', KuisController::class);
Route::resource('/pertanyaan', PertanyaanController::class);
Route::resource('/hasil-kuis', HasilKuisController::class);
