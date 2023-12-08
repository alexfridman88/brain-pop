<?php

use App\Http\Controllers\PeriodController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;


Route::post('students', [StudentController::class, 'store']);
Route::post('teachers', [TeacherController::class, 'store']);

Route::post('students/login', [StudentController::class, 'login']);
Route::post('teachers/login', [TeacherController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::resource('students', StudentController::class)->except(['store']);
    Route::resource('teachers', TeacherController::class)->except(['store']);
    Route::resource('periods', PeriodController::class);

    Route::post('periods/attach/{period}', [PeriodController::class, 'attachStudents']);
    Route::post('periods/detach/{period}', [PeriodController::class, 'detachStudents']);
});
