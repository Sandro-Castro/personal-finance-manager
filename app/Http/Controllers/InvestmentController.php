<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = Investment::where('user_id', auth()->id())->paginate(10);
        return view('investments.index', compact('investments'));
    }

    public function create()
    {
        return view('investments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:stocks,funds,treasury,fixed_income,crypto,others',
            'initial_amount' => 'required|numeric|min:0',
            'current_value' => 'required|numeric|min:0',
            'investment_date' => 'required|date',
            'expected_return' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,redeemed,cancelled',
            'description' => 'nullable|string'
        ]);

        $data['user_id'] = auth()->id();
        Investment::create($data);

        return redirect()->route('investments.index')->with('success', 'Investimento criado com sucesso!');
    }

    public function show($id)
    {
        $investment = Investment::where('user_id', auth()->id())->findOrFail($id);
        return view('investments.show', compact('investment'));
    }

    public function edit($id)
    {
        $investment = Investment::where('user_id', auth()->id())->findOrFail($id);
        return view('investments.edit', compact('investment'));
    }

    public function update(Request $request, $id)
    {
        $investment = Investment::where('user_id', auth()->id())->findOrFail($id);
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:stocks,funds,treasury,fixed_income,crypto,others',
            'initial_amount' => 'required|numeric|min:0',
            'current_value' => 'required|numeric|min:0',
            'investment_date' => 'required|date',
            'expected_return' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,redeemed,cancelled',
            'description' => 'nullable|string'
        ]);

        $investment->update($data);

        return redirect()->route('investments.index')->with('success', 'Investimento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $investment = Investment::where('user_id', auth()->id())->findOrFail($id);
        $investment->delete();

        return redirect()->route('investments.index')->with('success', 'Investimento excluído com sucesso!');
    }
}