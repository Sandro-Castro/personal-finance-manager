<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\FinancialGoal;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $now = Carbon::now();
        
        $totalIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->sum('amount');
        $totalExpense = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->sum('amount');
        $balance = $totalIncome - $totalExpense;
        
        $currentMonthIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereYear('date', $now->year)
            ->whereMonth('date', $now->month)
            ->sum('amount');
            
        $currentMonthExpense = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereYear('date', $now->year)
            ->whereMonth('date', $now->month)
            ->sum('amount');
            
        $currentMonthBalance = $currentMonthIncome - $currentMonthExpense;
        
        $dailyBalance = [];
        $daysInMonth = $now->daysInMonth;
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dayDate = Carbon::create($now->year, $now->month, $day);
            
            $dayIncome = Transaction::where('user_id', $user->id)
                ->where('type', 'income')
                ->whereDate('date', $dayDate)
                ->sum('amount');
                
            $dayExpense = Transaction::where('user_id', $user->id)
                ->where('type', 'expense')
                ->whereDate('date', $dayDate)
                ->sum('amount');
                
            $dailyBalance[$day] = $dayIncome - $dayExpense;
        }
        
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->with('category')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        $activeGoals = FinancialGoal::where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->orderBy('deadline', 'asc')
            ->take(3)
            ->get();

        return view('home', compact(
            'balance',
            'currentMonthIncome',
            'currentMonthExpense',
            'currentMonthBalance',
            'dailyBalance',
            'recentTransactions',
            'activeGoals'
        ));
    }
}