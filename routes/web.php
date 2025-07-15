<?php

use App\Livewire\AttendanceForm;
use Illuminate\Support\Facades\Route;
//
//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('attendance/',App\Livewire\AttendanceForm::class, )->name('attendance.form');


