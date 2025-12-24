<?php

use App\Http\Controllers\Api\SisemarController;
use Illuminate\Support\Facades\Route;

Route::post('/sisemar-webhook', [SisemarController::class, 'storeFromSpreadsheet']);