// Student
Route::get('/school', [SchoolController::class, 'index'])->middleware('can:list-school');

Route::get('/school/create', [SchoolController::class, 'create'])->middleware('can:create-school');
Route::post('/school', [SchoolController::class, 'store'])->middleware('can:create-school');

Route::get('/school/{id}', [SchoolController::class, 'show'])->middleware('can:show-school');

Route::get('/school/{id}/edit', [SchoolController::class, 'edit'])->middleware('can:edit-school');
Route::put('/school/{id}', [SchoolController::class, 'update'])->middleware('can:edit-school');