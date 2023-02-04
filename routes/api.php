<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/production', \App\Http\Controllers\ProductionController::class);
