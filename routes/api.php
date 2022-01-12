<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\FrontendController;
use App\Http\Controllers\API\CartController;

use Facade\FlareClient\Http\Response;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// frontend routes
Route::get('getCategory',[FrontendController::class,'category']);
Route::get('fetchproducts/{slug}',[FrontendController::class,'product']);
Route::get('viewproductdetail/{category_slug}/{product_slug}',[FrontendController::class,'viewproductdetail']);
Route::post('add-to-cart',[CartController::class,'addtocart']);
Route::get('cart',[CartController::class,'viewcart']);
Route::put('cart-updatequantity/{cart_id}/{scope}',[CartController::class,'updatequantity']);
Route::delete('deleteCartItem/{cart_id}',[CartController::class,'deleteCart']);





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
    //product routes
    Route::get('view-product',[ProductController::class,'index']);
    Route::get('all-category',[CategoryController::class,'allCategory']);
    Route::post('store-product',[ProductController::class,'store']);
    Route::get('edit-product/{id}',[ProductController::class,'edit']);
    Route::post('update-product/{id}',[ProductController::class,'update']);


  
});
Route::middleware(['auth:sanctum'])->group(function(){
   
    Route::get('logout', [AuthController::class, 'logout']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
