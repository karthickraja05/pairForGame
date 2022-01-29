<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PlayerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/players',[PlayerController::class,'index']);
Route::get('/add_player',[PlayerController::class,'add'])->name('add_player');
Route::post('/add_player',[PlayerController::class,'store'])->name('store_player');
Route::get('/edit_player/{id}',[PlayerController::class,'edit'])->name('edit_player');
Route::post('/edit_player/{id}',[PlayerController::class,'update'])->name('update_player');


Route::get('/delete_player/{id}',[PlayerController::class,'delete'])->name('delete_player');
