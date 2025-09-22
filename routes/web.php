<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\FinancialGoalController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('/categories/search', [CategoryController::class, 'search'])->name('categories.search');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/transactions/edit/{id}', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/update/{id}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    Route::get('/transactions/search', [TransactionController::class, 'search'])->name('transactions.search');
    
    Route::get('/goals', [FinancialGoalController::class, 'index'])->name('goals.index');
    Route::get('/goals/create', [FinancialGoalController::class, 'create'])->name('goals.create');
    Route::post('/goals', [FinancialGoalController::class, 'store'])->name('goals.store');
    Route::get('/goals/{id}', [FinancialGoalController::class, 'show'])->name('goals.show');
    Route::get('/goals/edit/{id}', [FinancialGoalController::class, 'edit'])->name('goals.edit');
    Route::put('/goals/update/{id}', [FinancialGoalController::class, 'update'])->name('goals.update');
    Route::delete('/goals/{id}', [FinancialGoalController::class, 'destroy'])->name('goals.destroy');
    Route::post('/goals/search', [FinancialGoalController::class, 'search'])->name('goals.search');

    
});