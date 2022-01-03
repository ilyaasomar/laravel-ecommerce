<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;

use Facade\FlareClient\Http\Response;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum','isAPIAdmin'])->group(function(){
    Route::get("/checkingAuthonticated", function(){
        return response()->json(['message' => 'You are in', 'status' => 200], 200);
    });
    Route::get('view-category',[CategoryController::class,'index']);
    Route::post('store-category',[CategoryController::class,'store']);
    Route::get('edit-category/{id}',[CategoryController::class,'edit']);
    Route::put('update-category/{id}',[CategoryController::class,'update']);
    Route::delete('delete-category/{id}',[CategoryController::class,'destroy']);

  
});
Route::middleware(['auth:sanctum'])->group(function(){
   
    Route::post('logout', [AuthController::class, 'logout']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
