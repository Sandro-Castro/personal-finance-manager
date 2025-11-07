<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    public function index()
    {
        $receipts = Receipt::where('user_id', auth()->id())
            ->with('category')
            ->orderBy('date', 'desc')
            ->paginate(12);
        return view('receipts.index', compact('receipts'));
    }

    public function create()
    {
        $categories = Category::where('user_id', auth()->id())->get();
        return view('receipts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120' // 5MB
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('receipts', 'public');
            $data['image_path'] = $imagePath;
        }

        $data['user_id'] = auth()->id();
        Receipt::create($data);

        return redirect()->route('receipts.index')->with('success', 'Comprovante criado com sucesso!');
    }

    public function show($id)
    {
        $receipt = Receipt::where('user_id', auth()->id())
            ->with('category')
            ->findOrFail($id);
        return view('receipts.show', compact('receipt'));
    }

    public function edit($id)
    {
        $receipt = Receipt::where('user_id', auth()->id())->findOrFail($id);
        $categories = Category::where('user_id', auth()->id())->get();
        return view('receipts.edit', compact('receipt', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $receipt = Receipt::where('user_id', auth()->id())->findOrFail($id);
        
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        if ($request->hasFile('image')) {
            if ($receipt->image_path) {
                Storage::disk('public')->delete($receipt->image_path);
            }
            $imagePath = $request->file('image')->store('receipts', 'public');
            $data['image_path'] = $imagePath;
        }

        $receipt->update($data);

        return redirect()->route('receipts.index')->with('success', 'Comprovante atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $receipt = Receipt::where('user_id', auth()->id())->findOrFail($id);

        if ($receipt->image_path) {
            Storage::disk('public')->delete($receipt->image_path);
        }

        $receipt->delete();

        return redirect()->route('receipts.index')->with('success', 'Comprovante excluído com sucesso!');
    }

    public function pdf(Receipt $receipt)
    {
        if (method_exists($this, 'authorize')) {
            $this->authorize('view', $receipt);
        } else {
            if ($receipt->user_id !== Auth::id()) {
                abort(403);
            }
        }

        $pdf = Pdf::loadView('reports.receipt', compact('receipt'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download("recibo-{$receipt->id}.pdf");
    }
    public function search(Request $request)
    {
        $search = $request->get('search');
        
        $receipts = Receipt::where('user_id', auth()->id())
            ->where(function($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhereHas('category', function($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->with('category')
            ->orderBy('date', 'desc')
            ->paginate(12);

        return view('receipts.index', compact('receipts', 'search'));
    }
}