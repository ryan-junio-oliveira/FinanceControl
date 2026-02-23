<?php

namespace App\Modules\Shared\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Infrastructure\Persistence\Eloquent\CategoryModel as Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $org = Auth::user()->organization;

        $q = $request->query('q');
        $type = $request->query('type');
        $perPage = (int) $request->query('per_page', 20);
        $perPage = in_array($perPage, [10,20,50,100]) ? $perPage : 20;

        $query = Category::where('organization_id', $org->id);

        if ($q) {
            $query->where('name', 'like', "%{$q}%");
        }

        if ($type) {
            $query->where('type', $type);
        }

        $categories = $query->orderBy('name')->paginate($perPage);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $types = [
            'recipe' => 'Receita',
            'expense' => 'Despesa',
            'investment' => 'Investimento',
        ];

        return view('categories.create', compact('types'));
    }

    public function store(Request $request)
    {
        $org = Auth::user()->organization;

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:recipe,expense,investment',
        ]);

        $data['organization_id'] = $org->id;

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Categoria criada com sucesso.');
    }

    public function show($id)
    {
        $orgId = Auth::user()->organization_id;
        $category = Category::where('organization_id', $orgId)->findOrFail($id);

        return view('categories.show', compact('category'));
    }

    public function edit($id)
    {
        $orgId = Auth::user()->organization_id;
        $category = Category::where('organization_id', $orgId)->findOrFail($id);

        $types = [
            'recipe' => 'Receita',
            'expense' => 'Despesa',
            'investment' => 'Investimento',
        ];

        return view('categories.edit', compact('category', 'types'));
    }

    public function update(Request $request, $id)
    {
        $orgId = Auth::user()->organization_id;
        $category = Category::where('organization_id', $orgId)->findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:recipe,expense,investment',
        ]);

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Categoria atualizada.');
    }

    public function destroy($id)
    {
        $orgId = Auth::user()->organization_id;
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
