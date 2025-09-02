<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\PetaWilayahController;
use App\Http\Controllers\StrukturCabangController;
use App\Http\Controllers\SejarahController;
use App\Http\Controllers\PimpinanPersitController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PembinaPersitController;
use App\Http\Controllers\StrukturFotoController;
use App\Http\Controllers\RantingController;

// ===================== RUTE PUBLIK =====================
Route::get('/ranting-publik',[RantingController::class, 'getPublik']);
Route::get('/struktur-organisasi-publik', [StrukturFotoController::class, 'getPublik']);
Route::get('/struktur-cabang-publik', [StrukturCabangController::class, 'getPublic']);
Route::get('/sejarah-publik', [SejarahController::class, 'getPublik']);
Route::get('/profil-publik', [ProfilController::class, 'showPublic']);
Route::get('/berita-kegiatan', [BeritaController::class, 'terbaru']);
Route::get('/galeri-slider', [GaleriController::class, 'slider']);
Route::get('/berita/{id}', [BeritaController::class, 'show']);
Route::get('/sejarah/{id}', [SejarahController::class, 'show']);
Route::get('/peta-wilayah-publik', [PetaWilayahController::class, 'getTitikPublik']);
Route::get('/pimpinan-persit-publik', [PimpinanPersitController::class, 'getPublik']);
Route::get('/pembina-persit-publik',[PembinaPersitController::class, 'getPublik']);
Route::get('/anggota-summary', [AnggotaController::class, 'publicSummary']);

// ===================== RUTE UNTUK ADMIN =====================
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    // Auth
    // Anggota
Route::get('/anggota', [AnggotaController::class, 'index']);
Route::post('/anggota', [AnggotaController::class, 'store']);
Route::put('/anggota', [AnggotaController::class, 'update']);
Route::delete('/anggota', [AnggotaController::class, 'destroy']);
//Auth
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Profil
    Route::get('/profil', [ProfilController::class, 'index']);
    Route::post('/profil', [ProfilController::class, 'store']);
    Route::post('/profil/{id}', [ProfilController::class, 'update']); // _method=PUT
    Route::delete('/profil/{id}', [ProfilController::class, 'destroy']);

    // Struktur Organisasi (admin)
    Route::get('/struktur-foto', [StrukturFotoController::class, 'index']);
    Route::get('/struktur-foto/{id}', [StrukturFotoController::class, 'show']);
    Route::post('/struktur-foto', [StrukturFotoController::class, 'store']);
    Route::put('/struktur-foto/{id}', [StrukturFotoController::class, 'update']);
    Route::delete('/struktur-foto/{id}', [StrukturFotoController::class, 'destroy']);

    
    // Struktur Organisasi (admin)
    Route::get('/ranting', [RantingController::class, 'index']);
    Route::get('/ranting/{id}', [RantingController::class, 'show']);
    Route::post('/ranting', [RantingController::class, 'store']);
    Route::put('/ranting/{id}', [RantingController::class, 'update']);
    Route::delete('/ranting/{id}', [RantingController::class, 'destroy']);
    // Anggota
    Route::get('/anggota', [AnggotaController::class, 'index']);
    Route::post('/anggota', [AnggotaController::class, 'store']);
    Route::put('/anggota/{id}', [AnggotaController::class, 'update']);
    Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy']);

    // Resource lainnya (admin)
    Route::apiResource('/pembina-persit', PembinaPersitController::class);
    Route::apiResource('/pimpinan-persit', PimpinanPersitController::class);
    Route::apiResource('/sejarah', SejarahController::class);
    Route::apiResource('/struktur-cabang', StrukturCabangController::class);
    Route::apiResource('/peta-wilayah', PetaWilayahController::class);
    Route::apiResource('/galeri', GaleriController::class);
    Route::apiResource('/berita', BeritaController::class);
});
