<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

// Public Admin Authentication Routes
Route::prefix('admin')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

});

// Protected Admin Routes
Route::prefix('admin')
    ->middleware('auth:sanctum')
    ->group(function () {

        // Authentication
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']);

        Route::get('/dashboard', [DashboardController::class, 'index']);


        // Book Management
        Route::get('/books', [BookController::class, 'index']);
        Route::post('/books', [BookController::class, 'store']);
        Route::get('/books/{id}', [BookController::class, 'show']);
        Route::put('/books/{id}', [BookController::class, 'update']);
        Route::delete('/books/{id}', [BookController::class, 'destroy']);

        // Borrowing Management
        Route::get('/borrowings', [BorrowingController::class, 'index']);
        Route::post('/borrowings', [BorrowingController::class, 'store']);
        Route::get('/borrowings/active', [BorrowingController::class, 'active']);
        Route::get('/borrowings/{id}', [BorrowingController::class, 'show']);
        Route::put('/borrowings/{id}/return', [BorrowingController::class, 'returnBook']);

         // Student Management
        Route::get('/students', [StudentController::class, 'index']);
        Route::post('/students', [StudentController::class, 'store']);
        Route::get('/students/{id}', [StudentController::class, 'show']);
        Route::put('/students/{id}', [StudentController::class, 'update']);
        Route::delete('/students/{id}', [StudentController::class, 'destroy']);


    });