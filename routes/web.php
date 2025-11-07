<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\FinancialGoalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth'])->group(function () {

    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::get('/', [DashboardController::class, 'index'])->name('home');

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

    Route::get('/goals', [FinancialGoalController::class, 'index'])->name('goals.index');
    Route::get('/goals/create', [FinancialGoalController::class, 'create'])->name('goals.create');
    Route::post('/goals', [FinancialGoalController::class, 'store'])->name('goals.store');
    Route::get('/goals/{id}', [FinancialGoalController::class, 'show'])->name('goals.show');
    Route::get('/goals/edit/{id}', [FinancialGoalController::class, 'edit'])->name('goals.edit');
    Route::put('/goals/update/{id}', [FinancialGoalController::class, 'update'])->name('goals.update');
    Route::delete('/goals/{id}', [FinancialGoalController::class, 'destroy'])->name('goals.destroy');
    Route::post('/goals/search', [FinancialGoalController::class, 'search'])->name('goals.search');


    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    Route::get('/investments/search', [InvestmentController::class, 'search'])->name('investments.search');
    Route::get('/investments', [InvestmentController::class, 'index'])->name('investments.index');
    Route::get('/investments/create', [InvestmentController::class, 'create'])->name('investments.create');
    Route::post('/investments', [InvestmentController::class, 'store'])->name('investments.store');
    Route::get('/investments/{id}', [InvestmentController::class, 'show'])->name('investments.show');
    Route::get('/investments/edit/{id}', [InvestmentController::class, 'edit'])->name('investments.edit');
    Route::put('/investments/update/{id}', [InvestmentController::class, 'update'])->name('investments.update');
    Route::delete('/investments/{id}', [InvestmentController::class, 'destroy'])->name('investments.destroy');
            
    Route::get('/receipts/search', [ReceiptController::class, 'search'])->name('receipts.search');
    Route::get('/receipts', [ReceiptController::class, 'index'])->name('receipts.index');
    Route::get('/receipts/create', [ReceiptController::class, 'create'])->name('receipts.create');
    Route::post('/receipts', [ReceiptController::class, 'store'])->name('receipts.store');
    Route::get('/receipts/{id}', [ReceiptController::class, 'show'])->name('receipts.show');
    Route::get('/receipts/edit/{id}', [ReceiptController::class, 'edit'])->name('receipts.edit');
    Route::put('/receipts/update/{id}', [ReceiptController::class, 'update'])->name('receipts.update');
    Route::delete('/receipts/{id}', [ReceiptController::class, 'destroy'])->name('receipts.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('transactions/{transaction}/pdf', [TransactionController::class, 'pdf'])->name('transactions.pdf');
    Route::get('receipts/{receipt}/pdf', [ReceiptController::class, 'pdf'])->name('receipts.pdf');
});