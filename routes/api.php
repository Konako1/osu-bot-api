<?php

use Illuminate\Support\Facades\Route;


Route::get('performance/{beatmap_id}', 'CalculatorController@performance');
