<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UserController;

use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\RefreshTokenMiddleware;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::group(['prefix' => 'auth'], function () {
    // Authentication routes
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // Password management
    Route::post('forget', [AuthController::class, 'forget']);
    Route::post('validate', [AuthController::class, 'validateCode']);
    Route::post('reset', [AuthController::class, 'resetPassword']);

    // Token management
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware([RefreshTokenMiddleware::class]);
    Route::post('logout', [AuthController::class, 'logout'])->middleware([JwtMiddleware::class]);

    // permissions
    Route::get('user/permissions', [AuthController::class, 'permissions'])->middleware([JwtMiddleware::class]);
});


Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('image/upload', [ResourceController::class, 'uploadImage']);
    Route::apiResource('institutions', InstitutionController::class);
    Route::apiResource('courses', CourseController::class);
    Route::apiResource('terms', TermController::class);
    Route::apiResource('academic-years', AcademicYearController::class);
    Route::apiResource('users', UserController::class);
});

// Student Routes
Route::middleware(['role:student'])->group(function () {
    Route::apiResource('students', StudentController::class);
    Route::get('profile', [AuthController::class, 'me']);
    // Add more routes specific to the student role
});
// Staff Routes
Route::middleware('role:staff')->prefix('staff')->group(function () {
    Route::get('dashboard', [StaffController::class, 'dashboard']);
    Route::get('reports', [StaffController::class, 'reports']);
    // Add more routes specific to the staff role
});

// University Routes
Route::middleware('role:university')->prefix('university')->group(function () {
    Route::get('dashboard', [UniversityController::class, 'dashboard']);
    Route::get('courses', [UniversityController::class, 'courses']);
    // Add more routes specific to the university role
});

// Agent Routes
Route::middleware('role:agent')->prefix('agent')->group(function () {
    Route::get('dashboard', [AgentController::class, 'dashboard']);
    Route::get('leads', [AgentController::class, 'leads']);
    // Add more routes specific to the agent role
});
