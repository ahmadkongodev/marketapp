<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomersController;
use App\Http\Controllers\GoodsController;
use App\Http\Controllers\SalesController;
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

Route::group(['middleware'=>['auth:sanctum']], function (){
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/user',[AuthController::class,'user']);
    Route::post('/user/update',[AuthController::class,'update']);
    

//get all customers
Route::get('customers',[CustomersController::class,"index"]);
/*
store customer
{
    "customer_firstname":"clien",
	"customer_lastname":"clien",
	"customer_phone":"1256544"
}
*/
Route::post('customers/store',[CustomersController::class,"store"]);
/*
update customer
{
    "customer_firstname":"clienUpdate",
	"customer_lastname":"clien",
	"customer_phone":"1256544",
    "id":1
}
*/

Route::put('customers/update/{id}',[CustomersController::class,"update"]);
Route::delete('customers/delete/{id}',[CustomersController::class,"destroy"]);
Route::get("/customers/search/{name}",[CustomersController::class,"search"]);
Route::get("/customers/show/{id}",[CustomersController::class,"show"]);


//get all goods
Route::get('goods',[GoodsController::class,"index"]);
Route::get('goods/show/{id}',[GoodsController::class,"show"]);

Route::post('goods/store',[GoodsController::class,"store"]);
Route::post('goods/uploadImage',[GoodsController::class,"uploadImage"]);

Route::put('goods/update/{id}',[GoodsController::class,"update"]);

Route::delete('goods/delete/{id}',[GoodsController::class,"destroy"]);
Route::get('goods/search/{name}',[GoodsController::class,"search"]);


Route::get('sales',[SalesController::class,"index"]);
Route::post('sales/store',[SalesController::class,"store"]);
Route::put('sales/update/{id}',[SalesController::class,"update"]);
Route::delete('sales/delete/{id}',[SalesController::class,"destroy"]);
Route::get('sales/search/{good_id}',[SalesController::class,"search"]);
Route::get('sales/show/{id}',[SalesController::class,"show"]);
});

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

