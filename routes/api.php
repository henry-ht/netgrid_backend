<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
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

Route::post("login", [AuthController::class, 'login'])->name('api.login');
Route::post("register", [AuthController::class, 'register'])->name('api.register');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:sanctum']], function (){

    Route::post("logout", [AuthController::class, 'logout']);

    Route::put("profile/{user}", [ProfileController::class, 'update'], ['parameters' => [
        'profile' => 'user',
    ]])->name('api.profile.update');

    Route::apiResource("favorite", FavoriteController::class);

});
