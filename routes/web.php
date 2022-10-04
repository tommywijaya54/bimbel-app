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
    ];

    foreach ($routeList as $model => $controller) {
        Route::get('/' . $model, [$controller, 'index'])->middleware('can:list-' . $model);

        Route::get('/' . $model . '/create', [$controller, 'create'])->middleware('can:create-' . $model);
        Route::post('/' . $model, [$controller, 'store'])->middleware('can:create-' . $model);

        Route::get('/' . $model . '/{id}', [$controller, 'show'])->middleware('can:show-' . $model);

        Route::get('/' . $model . '/{id}/edit', [$controller, 'edit'])->middleware('can:edit-' . $model);
        Route::put('/' . $model . '/{id}', [$controller, 'update'])->middleware('can:edit-' . $model);
    };
});

Route::middleware(['auth', 'verified'])->group(function () {
});


require __DIR__ . '/auth.php';
