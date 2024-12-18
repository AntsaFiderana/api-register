<?php

use App\Http\Controllers\UtilisateurController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('api/utilisateurs',[UtilisateurController::class,'index']);