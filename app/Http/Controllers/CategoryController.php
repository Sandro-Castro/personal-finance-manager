<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', auth()->id())->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'color' => 'required|string|max:7',
            'icon' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $data['user_id'] = auth()->id();
        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Categoria criada com sucesso!');
    }

    public function show($id)
    {
        $category = Category::where('user_id', auth()->id())->findOrFail($id);
        return view('categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = Category::where('user_id', auth()->id())->findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::where('user_id', auth()->id())->findOrFail($id);
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'color' => 'required|string|max:7',
            'icon' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $category = Category::where('user_id', auth()->id())->findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Categoria excluída com sucesso!');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $categories = Category::where('user_id', auth()->id())
            ->where('name', 'like', "%{$search}%")
            ->paginate(10);

        return view('categories.index', compact('categories'));
    }
}