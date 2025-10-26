<?php

use App\Http\Controllers\Api\V1\ChatController;
use App\Http\Controllers\Api\V1\DeviceController;
use App\Http\Controllers\Api\V1\EkoAyatHadistController;
use App\Http\Controllers\Api\V1\EkoCpController;
use App\Http\Controllers\Api\V1\EkoKaidahController;
use App\Http\Controllers\Api\V1\EkoMediaController;
use App\Http\Controllers\Api\V1\EkoRefleksiController;
use App\Http\Controllers\Api\V1\HomeController;
use Illuminate\Support\Facades\Route;

// Public API Routes (tanpa auth)
Route::prefix('v1')->group(function () {
    // Home
    Route::get('/home', [HomeController::class, 'index']);

    // Device
    Route::prefix('device')->group(function () {
        Route::post('/create', [DeviceController::class, 'create']);
        Route::get('/{id}', [DeviceController::class, 'show']);
    });

    // Eko CP
    Route::prefix('cp')->group(function () {
        Route::get('/', [EkoCpController::class, 'allCp']);
        Route::get('/{id}', [EkoCpController::class, 'showCp']);
        Route::get('/{faseId}/mapel/{mapelId}/metode/{metode}/chat/{deviceId}', [ChatController::class, 'chatCp']);
        Route::get('/{faseId}/mapel/{mapelId}/metode/{metode}/send-message/{deviceId}', [ChatController::class, 'sendMessageCp']);
    });

    Route::prefix('fase')->group(function () {
        Route::get('/', [EkoCpController::class, 'fase']);
        Route::get('/{faseId}/mapel', [EkoCpController::class, 'mapel']);
        Route::get('/{faseId}/mapel/{mapelId}/metode', [EkoCpController::class, 'metodePembelajaran']);
        Route::get('/{faseId}/mapel/{mapelId}/metode/{metode}', [EkoCpController::class, 'cpByFaseMapelMP']);
    });

    Route::get('/jenis_tema', [EkoMediaController::class, 'jenisTema']);

    // Eko Media
    Route::prefix('media')->group(function () {
        Route::get('/jenis_tema/{jenisTemaId}', [EkoMediaController::class, 'tema']);
        Route::get('/tema/{temaId}', [EkoMediaController::class, 'media']);
        Route::get('/{id}', [EkoMediaController::class, 'showMedia']);
    });

    // Eko Kaidah
    Route::prefix('kaidah')->group(function () {
        Route::get('/jenis_tema/{temaId}', [EkoKaidahController::class, 'tema']);
        Route::get('/tema/{temaId}', [EkoKaidahController::class, 'kaidah']);
        Route::get('/tema/{temaId}/chat/{deviceId}', [ChatController::class, 'chatKaidah']);
        Route::get('/tema/{temaId}/chat/{deviceId}/send-message/{jenis}', [ChatController::class, 'SendMessageKaidah']);
    });

    // Eko Ayat Hadist
    Route::prefix('ayat_hadist')->group(function () {
        Route::get('/jenis_tema/{temaId}', [EkoAyatHadistController::class, 'tema']);
        Route::get('/tema/{temaId}', [EkoAyatHadistController::class, 'ayatHadist']);
        Route::get('/{id}', [EkoAyatHadistController::class, 'showAyatHadist']);
        Route::get('/search/{query}', [EkoAyatHadistController::class, 'searchAyatHadist']);
        Route::get('/tema/{temaId}/chat/{deviceId}', [ChatController::class, 'chatDalil']);
        Route::get('/tema/{temaId}/chat/{deviceId}/send-message/{jenis}', [ChatController::class, 'SendMessageDalil']);
    });

    // Eko Refleksi
    Route::prefix('refleksi')->group(function () {
        Route::get('/', [EkoRefleksiController::class, 'index']);

        // Kuis
        Route::prefix('kuis')->group(function () {
            Route::get('/', [EkoRefleksiController::class, 'kuis']);
            Route::get('/{id}/device/{deviceId}', [EkoRefleksiController::class, 'kuisDetail']);
            Route::get('/{id}/pertanyaan', [EkoRefleksiController::class, 'pertanyaan']);
            Route::post('/', [EkoRefleksiController::class, 'simpanHasil']);
        });

        // Refleksi Harian
        Route::prefix('harian')->group(function () {
            Route::get('/', [EkoRefleksiController::class, 'refleksiHarian']);
            Route::get('/{id}', [EkoRefleksiController::class, 'showRefleksiHarian']);
            Route::post('/', [EkoRefleksiController::class, 'storeRefleksi']);
            Route::put('/{id}', [EkoRefleksiController::class, 'updateRefleksiHarian']);
            Route::patch('/{id}', [EkoRefleksiController::class, 'updateRefleksiHarian']);
            Route::delete('/{id}', [EkoRefleksiController::class, 'deleteRefleksiHarian']);
        });

        // Tanya Jawab (Chat)
        Route::prefix('chat')->group(function () {
            Route::get('/{deviceId}', [EkoRefleksiController::class, 'chat']);
            Route::post('/send', [EkoRefleksiController::class, 'sendMessage']);
        });
    });
});
