<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CadeauController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\MedecinController;
use App\Http\Controllers\Api\VisiteController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'active'])->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);

    Route::get('/medecins', [MedecinController::class, 'index']);
    Route::get('/medecins/{medecin}', [MedecinController::class, 'show']);
    Route::post('/medecins', [MedecinController::class, 'store']);
    Route::put('/medecins/{medecin}', [MedecinController::class, 'update'])->middleware('role:admin');

    Route::get('/cadeaux', [CadeauController::class, 'index']);
    Route::post('/cadeaux', [CadeauController::class, 'store'])->middleware('role:admin');
    Route::put('/cadeaux/{cadeau}', [CadeauController::class, 'update'])->middleware('role:admin');
    Route::post('/cadeaux/{cadeau}/stock', [CadeauController::class, 'stock'])->middleware('role:admin,gestionnaire');

    Route::get('/etablissements', [CatalogController::class, 'etablissements']);
    Route::post('/etablissements', [CatalogController::class, 'storeEtablissement'])->middleware('role:admin');

    Route::get('/users', [CatalogController::class, 'users'])->middleware('role:admin');
    Route::post('/users', [CatalogController::class, 'storeUser'])->middleware('role:admin');
    Route::put('/users/{user}', [CatalogController::class, 'updateUser'])->middleware('role:admin');

    Route::get('/visites/me/today', [VisiteController::class, 'today'])->middleware('role:delegue');
    Route::get('/visites/me', [VisiteController::class, 'mine'])->middleware('role:delegue');
    Route::get('/visites/me/{visite}', [VisiteController::class, 'show'])->middleware('role:delegue');
    Route::post('/visites', [VisiteController::class, 'store'])->middleware('role:delegue');
    Route::get('/visites', [CatalogController::class, 'visites'])->middleware('role:admin,statistiques');
    Route::get('/visites/{visite}', [CatalogController::class, 'showVisite'])->middleware('role:admin,statistiques');

    Route::get('/dashboard/stats', [CatalogController::class, 'stats'])->middleware('role:admin,statistiques,gestionnaire');
});
