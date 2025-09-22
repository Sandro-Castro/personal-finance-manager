<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', auth()->id())
            ->with('category')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc');

        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('date', '<=', $request->end_date);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $transactions = $query->paginate(10);
        $categories = Category::where('user_id', auth()->id())->get();

        return view('transactions.index', compact('transactions', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('user_id', auth()->id())->get();
        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'notes' => 'nullable|string'
        ]);

        $data['user_id'] = auth()->id();
        Transaction::create($data);

        return redirect()->route('transactions.index')->with('success', 'Transação criada com sucesso!');
    }

    public function show($id)
    {
        $transaction = Transaction::where('user_id', auth()->id())
            ->with('category')
            ->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = Transaction::where('user_id', auth()->id())->findOrFail($id);
        $categories = Category::where('user_id', auth()->id())->get();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::where('user_id', auth()->id())->findOrFail($id);
        
        $data = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'notes' => 'nullable|string'
        ]);

        $transaction->update($data);

        return redirect()->route('transactions.index')->with('success', 'Transação atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $transaction = Transaction::where('user_id', auth()->id())->findOrFail($id);
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transação excluída com sucesso!');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $transactions = Transaction::where('user_id', auth()->id())
            ->where('description', 'like', "%{$search}%")
            ->orWhereHas('category', function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->with('category')
            ->paginate(10);
            
        $categories = Category::where('user_id', auth()->id())->get();

        return view('transactions.index', compact('transactions', 'categories', 'search'));
    }
}