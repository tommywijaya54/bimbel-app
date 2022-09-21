<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::group([
    'middleware' => ['auth'],
], function () {

    Route::get('/', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('admin-dashboard');

    /*
    Route::resource('user', UserController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);
    */

    Route::resource('permission', PermissionController::class, [
        'only' => ['index', 'show', 'create', 'store', 'edit', 'update', 'delete']
    ]);
});
