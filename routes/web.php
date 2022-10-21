<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\EmployeeroleController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\AdvisorController;
use App\Http\Controllers\TeacherController;

use App\Http\Controllers\CparentController;
use App\Http\Controllers\StudentController;

use App\Http\Controllers\SchoolController;

use App\Http\Controllers\BranchController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\AssetController;

use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RegistrationitemController;
use App\Http\Controllers\PricelistController;
use App\Http\Controllers\PromolistController;

use App\Http\Controllers\SubjectController;
use App\Http\Controllers\RoletypeController;

use App\Http\Controllers\ActionhistoryController;
use App\Http\Controllers\BranchRentalController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScheduleController;

use App\Models\Permission;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified'])->group(function () {
    // Role & Permission
    /*
    Route::get('/role', [RoleController::class, 'index'])->middleware('can:list-role');
    Route::get('/role/create', [RoleController::class, 'create'])->middleware('can:create-);
        
    Route::get('/role/{id}', [RoleController::class, 'show'])->middleware('can:show-role');
    Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->middleware('can:edit-role');
    */

    $routeList = [
        'role' => RoleController::class,
        'user' => UserController::class,
        'registration' => RegistrationController::class,
        'promolist' => PromolistController::class,
        'pricelist' => PricelistController::class,
        'branch' => BranchController::class,
        'school' => SchoolController::class,
        'parent' => CparentController::class,
        'student' => StudentController::class,
        'employee' => EmployeeController::class,
        'schedule' => ScheduleController::class
    ];

    foreach ($routeList as $model => $controller) {
        Route::get('/' . $model, [$controller, 'index'])->middleware('can:list-' . $model);

        Route::get('/' . $model . '/create', [$controller, 'create'])->middleware('can:create-' . $model);
        Route::post('/' . $model, [$controller, 'store'])->middleware('can:create-' . $model);

        Route::get('/' . $model . '/{id}', [$controller, 'show'])->middleware('can:show-' . $model)->name($model . '.show');

        Route::get('/' . $model . '/{id}/edit', [$controller, 'edit'])->middleware('can:edit-' . $model);
        Route::put('/' . $model . '/{id}', [$controller, 'update'])->middleware('can:edit-' . $model);
    };

    Route::group([
        'prefix' => 'employee'
    ], function () {
        Route::post('/{id}/salary', [EmployeeController::class, 'add_salary'])->name('add.employee.salary');
        Route::delete('/{id}/salary/{salary_id}', [EmployeeController::class, 'delete_salary'])->name('delete.employee.salary');
    });

    Route::group([
        'prefix' => 'branch'
    ], function () {
        Route::get('/{id}/details', [BranchController::class, 'details']);
        Route::post('/{id}/expense', [BranchController::class, 'add_expense']);

        Route::group([
            'prefix' => '/{branch_id}/rental'
        ], function () {
            Route::get('/create', [BranchRentalController::class, 'create_rental']);
            Route::post('', [BranchRentalController::class, 'store_rental']);

            Route::get('/{rental_id}', [BranchRentalController::class, 'show_rental']);

            Route::get('/{rental_id}/edit', [BranchRentalController::class, 'edit_rental']);
            Route::put('/{rental_id}', [BranchRentalController::class, 'update_rental']);
        });

        Route::post('/{id}/asset', [BranchController::class, 'add_asset']);

        Route::delete('/{id}/expense/{item_id}', [BranchController::class, 'delete_expense']);
        Route::delete('/{id}/rental/{item_id}', [BranchController::class, 'delete_rental']);
        Route::delete('/{id}/asset/{item_id}', [BranchController::class, 'delete_asset']);
    });
});

Route::middleware(['auth', 'verified'])->group(function () {
});


require __DIR__ . '/auth.php';

/*
Route::get('/{branch_id}/rental/create', [BranchRentalController::class, 'create']);
        // Route::post('', [BranchRentalController::class, 'add_rental']);

        Route::get('/{branch_id}/rental/{rental_id}', [BranchRentalController::class, 'show']);

        Route::get('/{branch_id}/rental/{rental_id}/edit', [BranchRentalController::class, 'edit']);
        Route::put('/{branch_id}/rental/{rental_id}', [BranchRentalController::class, 'update']);
        */