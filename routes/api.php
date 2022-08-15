<?php

use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ContributorController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\PortfolioController;
use App\Http\Controllers\Api\TestimonialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('contributors', ContributorController::class)
    ->only(['index', 'show']);

Route::apiResource('portfolios', PortfolioController::class)
    ->only(['index', 'show']);

Route::apiResource('clients', ClientController::class)
    ->only(['index', 'show']);

Route::apiResource('testimonials', TestimonialController::class)
    ->only(['index', 'show']);

Route::apiResource('faqs', FaqController::class)
    ->only(['index']);

Route::apiResource('/abouts', AboutController::class)
    ->only(['index']);
