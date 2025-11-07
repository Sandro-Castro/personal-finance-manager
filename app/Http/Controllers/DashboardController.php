<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\FinancialGoal;
use Carbon\Carbon;
use ArielMejiaDev\LarapexCharts\LarapexChart;

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

        $chart = (new LarapexChart)
            ->lineChart()
            ->setTitle('Evolução do Mês')
            ->setSubtitle('Saldo diário acumulado')
            ->addData('Saldo Diário', array_values($dailyBalance))
            ->setColors(['#3B71CA'])
            ->setXAxis(array_keys($dailyBalance))
            ->setMarkers(['#3B71CA'], 5, 10)
            ->setStroke(3)
            ->setGrid();

        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push($now->copy()->subMonths($i));
        }

        $monthLabels = $months->map(fn($m) => $m->translatedFormat('M/Y'))->toArray();
        $monthlyIncomeData = [];
        $monthlyExpenseData = [];

        foreach ($months as $month) {
            $income = Transaction::where('user_id', $user->id)
                ->where('type', 'income')
                ->whereYear('date', $month->year)
                ->whereMonth('date', $month->month)
                ->sum('amount');

            $expense = Transaction::where('user_id', $user->id)
                ->where('type', 'expense')
                ->whereYear('date', $month->year)
                ->whereMonth('date', $month->month)
                ->sum('amount');

            $monthlyIncomeData[] = $income;
            $monthlyExpenseData[] = $expense;
        }

        $monthlyChart = (new LarapexChart)
            ->barChart()
            ->setTitle('Evolução de Receitas e Despesas')
            ->setSubtitle('Últimos 6 meses')
            ->addData('Receitas', $monthlyIncomeData)
            ->addData('Despesas', $monthlyExpenseData)
            ->setColors(['#28a745', '#dc3545'])
            ->setXAxis($monthLabels)
            ->setGrid();

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
            'activeGoals',
            'chart',
            'monthlyChart'
        ));
    }
}
