<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginUserController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\NoteController;


Route::middleware('auth:api')->group(function () {
  Route::post('/logout', [LoginUserController::class, 'destroy']);
  Route::apiResource('/user', UserController::class);
});

Route::middleware('guest:api')->group(function () {
  Route::post('/register', [RegisterUserController::class, 'store']);
  Route::post('/login', [LoginUserController::class, 'store']);
});

Route::get('notes', [NoteController::class, 'index']);
Route::get('note/{note}', [NoteController::class, 'show']);

Route::middleware('auth:api')->group(
  function () {
    Route::post('note/store', [NoteController::class, 'store']);
    Route::patch('note/{note}', [NoteController::class, 'update']);
    Route::delete('note/{note}', [NoteController::class, 'destroy']);
  }
);

Route::fallback(function () {
  return response()->json(['message' => 'you are lost']);
});
