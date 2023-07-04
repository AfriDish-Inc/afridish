<?php

Route::post('login', [App\Http\Controllers\API\AuthController::class, 'login']);
Route::post('register', [App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('social-login', [App\Http\Controllers\API\AuthController::class, 'socialLogin']);

