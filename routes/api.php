<?php

use App\Http\Controllers\MessagesController;
use Illuminate\Support\Facades\Route;

Route::post('/messages', [MessagesController::class, 'create']);
