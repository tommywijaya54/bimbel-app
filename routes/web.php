<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\PricelistController;
use App\Http\Controllers\PromolistController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RegistrationitemController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\AdvisorController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\EmployeeroleController;
use App\Http\Controllers\RoletypeController;
use App\Http\Controllers\ActionhistoryController;
use App\Http\Controllers\ScheduleController;

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
    Route::resource('user', UserController::class, [
        'only' => ['index', 'edit', 'update']
    ]);

    Route::resource('employee', EmployeeController::class, [
        'only' => ['index,edit']
    ]);


    Route::resource('manager', ManagerController::class, [
        'only' => ['index,edit']
    ]);


    Route::resource('branch', BranchController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('expense', ExpenseController::class, [
        'only' => ['index,edit']
    ]);


    Route::resource('rental', RentalController::class, [
        'only' => ['index,edit']
    ]);


    Route::resource('asset', AssetController::class, [
        'only' => ['index,edit']
    ]);


    Route::resource('parent', ParentController::class, [
        'only' => ['index,edit']
    ]);


    Route::resource('student', StudentController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('school', SchoolController::class, [
        'only' => ['index,edit']
    ]);


    Route::resource('pricelist', PricelistController::class, [
        'only' => ['index,edit']
    ]);


    Route::resource('promolist', PromolistController::class, [
        'only' => ['index,edit']
    ]);


    Route::resource('registration', RegistrationController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    Route::resource('registrationitem', RegistrationitemController::class, [
        'only' => ['index,edit']
    ]);


    Route::resource('salary', SalaryController::class, [
        'only' => ['index,edit']
    ]);


    Route::resource('advisor', AdvisorController::class, [
        'only' => ['index,edit']
    ]);


    Route::resource('teacher', TeacherController::class, [
        'only' => ['index,edit']
    ]);


    Route::resource('subject', SubjectController::class, [
        'only' => ['index,edit']
    ]);


    Route::resource('employeerole', EmployeeroleController::class, [
        'only' => ['index,edit']
    ]);


    Route::resource('roletype', RoletypeController::class, [
        'only' => ['index,edit']
    ]);


    Route::resource('actionhistory', ActionhistoryController::class, [
        'only' => ['index,edit']
    ]);


    Route::resource('schedule', ScheduleController::class, [
        'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
    ]);


    // Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
});


require __DIR__ . '/auth.php';
