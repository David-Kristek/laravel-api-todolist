<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsController;
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
//divny routy


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user/data',[AuthController::class, 'userData']);

    Route::prefix('posts')->group(function (){
        Route::get('/', [PostController::class, 'index']);
        Route::get('/{id}/edit', [PostController::class, 'edit']);

        Route::post('/', [PostController::class, 'store']);
        Route::put('/{id}', [PostController::class, 'update']);
        Route::delete('/{id}', [PostController::class, 'destroy']);
    });

    Route::prefix('admin')->middleware("Admin")->group(function () {
        Route::get('/',[AdminController::class, 'admin']);
        Route::get('/users', [AdminController::class, 'getUsers']); 
        Route::get('/user/{id}', [AdminController::class, 'userInfo']);

        Route::delete('/removeUser/{id}', [AdminController::class, 'removeUser']); 
        Route::delete('/removeAdmin/{id}', [AdminController::class, 'removeAdmin'])->middleware('mainAdmin'); 
        Route::get('/newAdmin/{id}', [AdminController::class, 'newAdmin'])->middleware('mainAdmin'); 
    });
});
