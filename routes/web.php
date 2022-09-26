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
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\ScheduleController;

use App\Models\Admin\Permission;
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
    Route::get('/user', [UserController::class, 'index'])->middleware('can:list-user');
    Route::get('/user/{id}', [UserController::class, 'show'])->middleware('can:show-user');

    Route::get('/role-and-permission', [PermissionController::class, 'index'])->middleware('can:list-role and permission');
    Route::get('/role/{id}', [PermissionController::class, 'show'])->middleware('can:show-role');

    Route::get('/branch', [BranchController::class, 'index'])->middleware('can:list-branch');
    Route::get('/branch/create', [BranchController::class, 'create'])->middleware('can:create-branch');
    Route::post('/branch', [BranchController::class, 'store'])->middleware('can:create-branch');
    Route::get('/branch/{id}', [BranchController::class, 'show'])->middleware('can:show-branch');
});


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
