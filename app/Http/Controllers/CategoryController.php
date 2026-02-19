<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $org = auth()->user()->organization;
        $categories = Category::where('organization_id', $org->id)
            ->orderBy('name')
            ->paginate(20);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $types = [
            'recipe' => 'Receita',
            'expense' => 'Despesa',
        ];

        return view('categories.create', compact('types'));
    }

    public function store(Request $request)
    {
        $org = auth()->user()->organization;

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:recipe,expense',
        ]);

        $data['organization_id'] = $org->id;

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Categoria criada com sucesso.');
    }

    public function show($id)
    {
        $orgId = auth()->user()->organization_id;
        $category = Category::where('organization_id', $orgId)->findOrFail($id);

        return view('categories.show', compact('category'));
    }

    public function edit($id)
    {
        $orgId = auth()->user()->organization_id;
        $category = Category::where('organization_id', $orgId)->findOrFail($id);

        $types = [
            'recipe' => 'Receita',
            'expense' => 'Despesa',
        ];

        return view('categories.edit', compact('category', 'types'));
    }

    public function update(Request $request, $id)
    {
        $orgId = auth()->user()->organization_id;
        $category = Category::where('organization_id', $orgId)->findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:recipe,expense',
        ]);

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Categoria atualizada.');
    }

    public function destroy($id)
    {
        $orgId = auth()->user()->organization_id;
        $category = Category::where('organization_id', $orgId)->findOrFail($id);

        // Defensive: only check relations if the FK column exists in the child table.
        try {
            $canDelete = true;

            if (\Illuminate\Support\Facades\Schema::hasColumn('recipes', 'category_id')) {
                if ($category->recipes()->exists()) {
                    $canDelete = false;
                }
            }

            if (\Illuminate\Support\Facades\Schema::hasColumn('expenses', 'category_id')) {
                if ($category->expenses()->exists()) {
                    $canDelete = false;
                }
            }

            if (! $canDelete) {
                return back()->withErrors(['error' => 'Não é possível remover uma categoria que está em uso.']);
            }

            $category->delete();

            return redirect()->route('categories.index')->with('success', 'Categoria removida.');
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => 'Erro ao remover categoria.']);
        }
    }
}
