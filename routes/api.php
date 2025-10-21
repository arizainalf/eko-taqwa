<?php

use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\EkoAyatHadistController;
use App\Http\Controllers\Api\EkoCpController;
use App\Http\Controllers\Api\EkoKaidahController;
use App\Http\Controllers\Api\EkoMediaController;
use App\Http\Controllers\Api\EkoRefleksiController;
use App\Http\Controllers\Api\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/home', [HomeController::class, 'index']);

Route::post('/device/create', [DeviceController::class, 'create']);
Route::get('/device/{id}', [DeviceController::class, 'show']);

//Eko CP

Route::get('/fase', [EkoCpController::class, 'fase']);
Route::get('/fase/{faseId}/mapel', [EkoCpController::class, 'mapel']);
Route::get('/fase/{faseId}/mapel/{mapelId}/metode', [EkoCpController::class, 'metodePembelajaran']);
Route::get('/fase/{faseId}/mapel/{mapelId}/metode/{metode}', [EkoCpController::class, 'cpByFaseMapelMP']);
Route::get('/cp', [EkoCpController::class, 'allCp']);
Route::get('/cp/{id}', [EkoCpController::class, 'showCp']);

//Eko Media

Route::get('/jenis_tema', [EkoMediaController::class, 'jenisTema']);
Route::get('/jenis_tema/{jenisTemaId}/tema', [EkoMediaController::class, 'tema']);
Route::get('/tema/{temaId}/media', [EkoMediaController::class, 'media']);
Route::get('/media/{id}', [EkoMediaController::class, 'showMedia']);

//Eko Kaidah

Route::get('/jenis_tema/{temaId}/kaidah', [EkoKaidahController::class, 'tema']);
Route::get('/tema/{temaId}/kaidah', [EkoKaidahController::class, 'kaidah']);

//EKo Ayat Hadist

Route::get('/jenis_tema/{temaId}/ayat_hadist', [EkoAyatHadistController::class, 'tema']);
Route::get('/tema/{temaId}/ayat_hadist', [EkoAyatHadistController::class, 'ayatHadist']);
Route::get('/ayat_hadist/{id}', [EkoAyatHadistController::class, 'showAyatHadist']);
Route::get('/ayat_hadist/search/{query}', [EkoAyatHadistController::class, 'searchAyatHadist']);

//Eko Refleksi

Route::get('/refleksi', [EkoRefleksiController::class, 'index']);

//kuis

Route::get('/kuis', [EkoRefleksiController::class, 'kuis']);
Route::get('/kuis/{id}/device/{deviceId}', [EkoRefleksiController::class, 'kuisDetail']);
Route::get('/kuis/{id}/pertanyaan', [EkoRefleksiController::class, 'pertanyaan']);
Route::post('/kuis', [EkoRefleksiController::class, 'simpanHasil']);

//refleksi harian

Route::get('/refleksi_harian', [EkoRefleksiController::class, 'refleksiHarian']);
Route::get('/refleksi_harian/{id}', [EkoRefleksiController::class, 'showRefleksiHarian']);
Route::post('/refleksi_harian', [EkoRefleksiController::class, 'storeRefleksi']);

//tanya jawab

Route::get('/tanya_jawab/{deviceId}', [EkoRefleksiController::class, 'chat']);
Route::post('/tanya_jawab/send', [EkoRefleksiController::class, 'sendMessage']);
