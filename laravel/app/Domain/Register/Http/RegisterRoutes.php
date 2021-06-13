<?php

use App\Domain\Register\Http\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('/users', [RegisterController::class, 'registerUser']);
