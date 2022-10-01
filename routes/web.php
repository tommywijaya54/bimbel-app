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
    // User
    Route::get('/user', [UserController::class, 'index'])->middleware('can:list-user');
    Route::get('/user/create', [UserController::class, 'create'])->middleware('can:create-user');
    Route::get('/user/{id}', [UserController::class, 'show'])->middleware('can:show-user');
    Route::post('/user', [UserController::class, 'store'])->middleware('can:create-user');

    // Role & Permission
    Route::get('/role-and-permission', [PermissionController::class, 'index'])->middleware('can:list-role and permission');
    Route::get('/role/{id}', [PermissionController::class, 'show'])->middleware('can:show-role');

    $routeList = [
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


/*
    // Branch
    Route::get('/branch', [BranchController::class, 'index'])->middleware('can:list-branch');

    Route::get('/branch/create', [BranchController::class, 'create'])->middleware('can:create-branch');
    Route::post('/branch', [BranchController::class, 'store'])->middleware('can:create-branch');

    Route::get('/branch/{id}', [BranchController::class, 'show'])->middleware('can:show-branch');

    Route::get('/branch/{id}/edit', [BranchController::class, 'edit'])->middleware('can:edit-branch');
    Route::put('/branch/{id}', [BranchController::class, 'update'])->middleware('can:edit-branch');

    // Employee
    Route::get('/employee', [EmployeeController::class, 'index'])->middleware('can:list-employee');

    Route::get('/employee/create', [EmployeeController::class, 'create'])->middleware('can:create-employee');
    Route::post('/employee', [EmployeeController::class, 'store'])->middleware('can:create-employee');

    Route::get('/employee/{id}', [EmployeeController::class, 'show'])->middleware('can:show-employee');

    Route::get('/employee/{id}/edit', [EmployeeController::class, 'edit'])->middleware('can:edit-employee');
    Route::put('/employee/{id}', [EmployeeController::class, 'update'])->middleware('can:edit-employee');

    // Student
    Route::get('/student', [StudentController::class, 'index'])->middleware('can:list-student');

    Route::get('/student/create', [StudentController::class, 'create'])->middleware('can:create-student');
    Route::post('/student', [StudentController::class, 'store'])->middleware('can:create-student');

    Route::get('/student/{id}', [StudentController::class, 'show'])->middleware('can:show-student');

    Route::get('/student/{id}/edit', [StudentController::class, 'edit'])->middleware('can:edit-student');
    Route::put('/student/{id}', [StudentController::class, 'update'])->middleware('can:edit-student');

    // Parent
    Route::get('/parent', [CparentController::class, 'index'])->middleware('can:list-parent');

    Route::get('/parent/create', [CparentController::class, 'create'])->middleware('can:create-parent');
    Route::post('/parent', [CparentController::class, 'store'])->middleware('can:create-parent');

    Route::get('/parent/{id}', [CparentController::class, 'show'])->middleware('can:show-parent');

    Route::get('/parent/{id}/edit', [CparentController::class, 'edit'])->middleware('can:edit-parent');
    Route::put('/parent/{id}', [CparentController::class, 'update'])->middleware('can:edit-parent');

    // School
    Route::get('/school', [SchoolController::class, 'index'])->middleware('can:list-school');

    Route::get('/school/create', [SchoolController::class, 'create'])->middleware('can:create-school');
    Route::post('/school', [SchoolController::class, 'store'])->middleware('can:create-school');

    Route::get('/school/{id}', [SchoolController::class, 'show'])->middleware('can:show-school');

    Route::get('/school/{id}/edit', [SchoolController::class, 'edit'])->middleware('can:edit-school');
    Route::put('/school/{id}', [SchoolController::class, 'update'])->middleware('can:edit-school');

    // Registration
    
    Route::get('/registration', [RegistrationController::class, 'index'])->middleware('can:list-registration');

    Route::get('/registration/create', [RegistrationController::class, 'create'])->middleware('can:create-registration');
    Route::post('/registration', [RegistrationController::class, 'store'])->middleware('can:create-registration');

    Route::get('/registration/{id}', [RegistrationController::class, 'show'])->middleware('can:show-registration');

    Route::get('/registration/{id}/edit', [RegistrationController::class, 'edit'])->middleware('can:edit-registration');
    Route::put('/registration/{id}', [RegistrationController::class, 'update'])->middleware('can:edit-registration');
    */

Route::middleware(['auth', 'verified'])->group(function () {

    /* 
    Route::resource('user', UserController::class, [
        'only' => ['index', 'show', 'create', 'store', 'edit', 'update', 'delete']
    ]);
    */

    /*
    Route::resource('employee', EmployeeController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('manager', ManagerController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('branch', BranchController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('expense', ExpenseController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('rental', RentalController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('asset', AssetController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('cparent', CparentController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('student', StudentController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('school', SchoolController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('pricelist', PricelistController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('promolist', PromolistController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('registration', RegistrationController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('registrationitem', RegistrationitemController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('salary', SalaryController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('advisor', AdvisorController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('teacher', TeacherController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('subject', SubjectController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('employeerole', EmployeeroleController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('roletype', RoletypeController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('actionhistory', ActionhistoryController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('schedule', ScheduleController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);
    */

    // Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
});


require __DIR__ . '/auth.php';
