<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PairingController;

Route::get('/', function () {
    return view('home');
});


// Player Management
Route::get('/players',[PlayerController::class,'index'])->name('players');
Route::get('/add_player',[PlayerController::class,'add'])->name('add_player');
Route::post('/add_player',[PlayerController::class,'store'])->name('store_player');
Route::get('/edit_player/{id}',[PlayerController::class,'edit'])->name('edit_player');
Route::post('/edit_player/{id}',[PlayerController::class,'update'])->name('update_player');
Route::get('/delete_player/{id}',[PlayerController::class,'delete'])->name('delete_player');


Route::get('/pairing',[PairingController::class,'index'])->name('pairing');
Route::get('/strict_pairing',[PairingController::class,'strict_pairing'])->name('strict_pairing');
Route::get('/pairing_data',[PairingController::class,'pairing_data'])->name('pairing_data');
Route::get('/view_paired_data/{id}',[PairingController::class,'view_pairing_data'])->name('view_paired_data');

