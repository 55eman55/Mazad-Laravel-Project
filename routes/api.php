<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\NewPasswordController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\LikeController;
use App\Http\Controllers\API\ReactController;
use App\Http\Controllers\API\searchController;
use Facade\FlareClient\Api;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('registerRout', [AuthController::class, 'register']);
Route::post('loginRout', [AuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {

    Route::post('updateprofile', [AuthController::class, 'update']);
    Route::post('forget', [NewPasswordController::class, 'forgotPassword']);
    Route::post('resetpassword', [NewPasswordController::class, 'passwordReset']);
    Route::post('showuser', [AuthController::class, 'show']);
    Route::post('updateprofileInfo', [AuthController::class, 'updateprofileInfo']);
    Route::post('searchuser', [AuthController::class, 'searchuser']);

});




/////////////////////////////////product\\\\\\\\\\\\\\\\\\\\\\\
Route::middleware('auth:api')->group(function () {

    Route::get('indexproduct', [ProductController::class, 'index']);
    Route::post('storeproduct', [ProductController::class, 'store']);
    Route::post('deleteproduct', [ProductController::class, 'destroy']);
    Route::post('getProducts', [ProductController::class, 'getProducts']);
    Route::post('showproduct', [ProductController::class, 'show']);
    Route::post('searchproduct', [ProductController::class, 'search']);
    Route::post('updateproduct', [ProductController::class, 'updateproduct']);
    ////////////////////////////like///////////////////////////////////////
    Route::post('getMyFavorite', [LikeController::class, 'getMyFavorite']);
    Route::post('makelike', [LikeController::class, 'makeLike']);
    Route::post('makeDislike', [LikeController::class, 'makeDislike']);
    /////////////////////////comment////////////////////////////
    Route::post('makecomment', [ReactController::class, 'comment']);

Route::post('deleteComments', [ReactController::class, 'destroy']);
});
Route::post('showComments', [ReactController::class, 'showComments']);





/////////////////////////////////category\\\\\\\\\\\\\\\\\\\\\\\\\\\\


Route::get('indexcatergory', [CategoryController::class, 'index']);
Route::post('storecategory', [CategoryController::class, 'store']);
Route::post('updatecategory', [CategoryController::class, 'update']);
Route::post('deletecategory', [CategoryController::class, 'destroy']);
Route::post('showcategory', [CategoryController::class, 'show']);
Route::post('searchcategory', [CategoryController::class, 'searchcategory']);
Route::post('/upload-image', [Controller::class, 'uploadImage']);
Route::post('changePassword', [AuthController::class, 'changePassword']);
Route::post('search', [searchController::class, 'search']);





Route::middleware(['api'])->group(function ($router) {
});


