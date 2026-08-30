<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/payment',[PaymentController::class,'index']);

Route::get('/afrizal', function (){
    return "Hello Afrizal";
});
Route::redirect('/youtube','/afrizal');

Route::view('/hello','hello',['name'=>'Afrizal']);

Route::get('/hello-again',function(){
    return view('hello',['name'=>'Afrizal Lagi']);
});

Route::view('/hello-world','hello.world',['name'=>'dunia']);

Route::get('/testParameter/{productId}',function ($productId){
    return "Product ID: $productId";
});

Route::get('/parameter/{id1}/paramater2/{id2}',function($id1,$id2){
    return "Parameter 1: $id1" . "Parameter 2: $id2";
});

Route::get('parameter/{id}',function ($id){
    return "Parameter: $id";
})->where('id', '[0-9]+');

Route::get('parameterOptional/{$id?}',function($id="404 Not Found"){
    return "Parameter: $id";
});

Route::get('product/{id}',function($id){
$link = route('product.detail',['id'=>$id]);
return "Link: $link";

});