<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return [
        'success' => true,
        'message' => 'Hello World',
        'url' => [
            'auth' => 'api/auth/{any}',
            'general' => 'api/v1/{any}'
        ]
    ];
});
