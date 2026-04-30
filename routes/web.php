<?php

use App\Livewire\SpinPage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/spin', SpinPage::class)
    ->middleware('throttle:30,1')
    ->name('spin');
