<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\CustomersController;
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
Route::prefix('items')->group(function ()
{
    Route::post('/',[ItemsController::class,'store']);
    Route::get('/{item_id?}',[ItemsController::class,'index']);
    Route::post('update/{item_id}',[ItemsController::class,'update']);
    Route::post('delete/{item_id}',[ItemsController::class,'delete']);

    Route::prefix('image')->group(function ()
    {
        Route::post('upload/{item_id?}',[ItemsController::class,'upload_image']);
        Route::post('remove/{item_id?}',[ItemsController::class,'remove_image']);
    });
});

Route::prefix('customers')->group(function ()
{
    Route::post('/',[CustomersController::class,'store']);
    Route::get('/{item_id?}',[CustomersController::class,'index']);

    Route::prefix('image')->group(function ()
    {
        Route::post('upload/{item_id?}',[CustomersController::class,'upload_image']);
        Route::post('remove/{item_id?}',[CustomersController::class,'remove_image']);
    });
});

