<?php

use App\Http\Controllers\UserCtrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('utilisateurs',UserCtrl::class);
Route::get('validationinscription/{token}',[UserCtrl::class,'validateEmail'])->name('confirmEmail');