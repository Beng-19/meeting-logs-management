<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeetingLogController;
use App\Http\Controllers\MemberController;

// Meeting routes
Route::get('/meetings', [MeetingLogController::class, 'index']);
Route::get('/meetings/{id}', [MeetingLogController::class, 'show']);
Route::post('/meetings', [MeetingLogController::class, 'store']);
Route::put('/meetings/{id}', [MeetingLogController::class, 'update']);
Route::delete('/meetings/{id}', [MeetingLogController::class, 'destroy']);

// Member routes
Route::get('/members', [MemberController::class, 'index']);
Route::post('/members', [MemberController::class, 'store']);
Route::put('/members/{id}', [MemberController::class, 'update']);
Route::delete('/members/{id}', [MemberController::class, 'destroy']);