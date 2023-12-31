<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GymController;
use App\Http\Controllers\GymOwnerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SubscriptionPlaneController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['LogRoutesRequested'])->group(function () {


    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('mail',[ContactController::class,'contact_mail_send']);
    Route::post('verify', [AuthController::class, 'verify']);

    //gym routes
    Route::get('/gym/{id?}', [GymController::class, 'get']);

    //Subscription plane routes
    Route::get('/subscription-plane/{id?}', [SubscriptionPlaneController::class, 'get']);

    //get nearest gyms location
    Route::post('/getNearestGymsLoaction', [LocationController::class, 'getNearestGymsLocation']);

    Route::middleware(['auth:sanctum'])->group(function () {
        // here normale use routes


        //GymOwnerRoutes
        Route::post('/gymOwner/{id}', [GymOwnerController::class, 'setUserAsGymOwner']);
        Route::delete('/gymOwner/{id}', [GymOwnerController::class, 'delete']);



        //Subscription routes
        Route::post('/subscription/subscribe', [SubscriptionController::class, 'subscribe']);
        Route::post('/subscription/unsubscribe/{id}', [SubscriptionController::class, 'unSubscribe']);
        Route::get('/subscription/{id?}', [SubscriptionController::class, 'get']);


        Route::middleware(['gymOwner'])->group(function () {
            //Gym Routes
            Route::post('/gym', [GymController::class, 'post']);
            Route::delete('/gym/{id}', [GymController::class, 'delete']);
            Route::put('/gym/{id}', [GymController::class, 'update']);


            //Upload Gym Imgs
            Route::post('/gym/img/{id}', [FileController::class, 'uploadGymImgs']);

            //Subscription plane routes
            Route::put('/subscription-plane/{id}', [SubscriptionPlaneController::class, 'update']);
            Route::post('/subscription-plane/{id}', [SubscriptionPlaneController::class, 'post']);
            Route::delete('/subscription-plane/{id}', [SubscriptionPlaneController::class, 'delete']);

            //product routes
            Route::post('/product', [ProductController::class, 'post']);
            Route::get('/product/{id?}', [ProductController::class, 'get']);
            Route::put('/product/{id}', [ProductController::class, 'update']);
            Route::delete('/product/{id}', [ProductController::class, 'delete']);

            //Upload product Imgs
            Route::post('/product/img/{id}', [FileController::class, 'uploadProductImgs']);
        });

        Route::middleware(['admin'])->group(function () {
            //here admin routes

            //get users
            Route::get('/user/{id?}', [AuthController::class, 'get']);

            //gym owner routes
            Route::get('/gymOwner/{id?}', [GymOwnerController::class, 'get']);
        });
    });
});
