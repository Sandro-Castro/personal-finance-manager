<?php

namespace App\Http\Controllers;

use App\Models\FinancialGoal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FinancialGoalController extends Controller
{
    public function index()
    {
        $goals = FinancialGoal::where('user_id', auth()->id())->paginate(10);

        $goals->getCollection()->transform(function($goal) {
        $deadlineDate = Carbon::parse($goal->deadline)->startOfDay(); // força início do dia
        $today = Carbon::now()->startOfDay(); // também
        $goal->days_remaining = $deadlineDate->diffInDays($today, false); // false para negativo se venceu
        return $goal;
    });

        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        return view('goals.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'required|numeric|min:0',
            'deadline' => 'required|date',
            'status' => 'required|in:in_progress,completed,cancelled',
            'description' => 'nullable|string'
        ]);

        $data['user_id'] = auth()->id();
        FinancialGoal::create($data);

        return redirect()->route('goals.index')->with('success', 'Objetivo financeiro criado com sucesso!');
    }

    public function show($id)
    {
        $goal = FinancialGoal::where('user_id', auth()->id())->findOrFail($id);
        return view('goals.show', compact('goal'));
    }

    public function edit($id)
    {
        $goal = FinancialGoal::where('user_id', auth()->id())->findOrFail($id);
        return view('goals.edit', compact('goal'));
    }

    public function update(Request $request, $id)
    {
        $goal = FinancialGoal::where('user_id', auth()->id())->findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'required|numeric|min:0',
            'deadline' => 'required|date',
            'status' => 'required|in:in_progress,completed,cancelled',
            'description' => 'nullable|string'
        ]);

        $goal->update($data);

        return redirect()->route('goals.index')->with('success', 'Objetivo financeiro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $goal = FinancialGoal::where('user_id', auth()->id())->findOrFail($id);
        $goal->delete();

        return redirect()->route('goals.index')->with('success', 'Objetivo financeiro excluído com sucesso!');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $goals = FinancialGoal::where('user_id', auth()->id())
            ->where('name', 'like', "%{$search}%")
            ->paginate(10);

        $goals->getCollection()->transform(function($goal) {
        $deadlineDate = Carbon::parse($goal->deadline)->startOfDay(); // força início do dia
        $today = Carbon::now()->startOfDay(); // também
        $goal->days_remaining = $deadlineDate->diffInDays($today, false); // false para negativo se venceu
        return $goal;
    });


        return view('goals.index', compact('goals'));
    }
}
