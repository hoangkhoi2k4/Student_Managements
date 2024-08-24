<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\DepartmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::resource('students', StudentController::class);

Route::get('students/{student}/subject', [StudentController::class, 'getSubjects'])->name('students.subject');

Route::get('students/{student}/{subject}/edit-score', [StudentController::class, 'editScore'])->name('students.edit-score');

Route::get('register-subject/{student}', [StudentController::class, 'registerSubject'])->name('students.register-subject');

Route::post('register-subject/{student}', [StudentController::class, 'storeRegisterSubject'])->name('students.store-register-subject');

Route::put('students/{student}/update-scores', [StudentController::class, 'updateScores'])->name('students.update-scores');

Route::post('excel/import-student', [StudentController::class, 'import'])->name('students.import');

Route::get('excel/export-template', [StudentController::class, 'getTemplate'])->name('students.get-template');

Route::get('list-subject-ajax', [StudentController::class, 'getListSubjectAjax']);

Route::resource('departments', DepartmentController::class);

Route::resource('subjects', SubjectController::class);

Route::resource('roles', RoleController::class);
