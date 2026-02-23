<?php

namespace App\Modules\Category\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Category\Application\UseCases\ListCategories;
use App\Modules\Category\Infrastructure\Persistence\Eloquent\CategoryModel as CategoryModel;
use App\Modules\Category\Presentation\Http\Requests\StoreCategoryRequest;
use App\Modules\Category\Presentation\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    private ListCategories $listCategories;

    public function __construct(ListCategories $listCategories)
    {
        $this->listCategories = $listCategories;
    }

    public function index(Request $request)
    {
        try {
            $org = Auth::user()->organization;

            $q = $request->query('q');
            $type = $request->query('type');
            $perPage = (int) $request->query('per_page', 20);
            $perPage = in_array($perPage, [10,20,50,100]) ? $perPage : 20;

            $query = CategoryModel::where('organization_id', $org->id);

            if ($q) {
                $query->where('name', 'like', "%{$q}%");
            }

            if ($type) {
                $query->where('type', $type);
            }

            $categories = $query->orderBy('name')->paginate($perPage);
            return view('categories.index', compact('categories'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Erro ao listar categorias.');
        }
    }

    public function create()
    {
        try {
            $types = [
                'recipe' => 'Receita',
                'expense' => 'Despesa',
                'investment' => 'Investimento',
            ];

            return view('categories.create', compact('types'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Erro ao abrir formulário de categoria.');
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $org = Auth::user()->organization;
            $data = $request->validated();
            $data['organization_id'] = $org->id;
            CategoryModel::create($data);
            return redirect()->route('categories.index')->with('success','Categoria criada com sucesso.');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error','Não foi possível criar categoria.');
        }
    }

    public function show($id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $category = CategoryModel::where('organization_id', $orgId)->findOrFail($id);
            return view('categories.show', compact('category'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Erro ao exibir categoria.');
        }
    }

    public function edit($id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $category = CategoryModel::where('organization_id', $orgId)->findOrFail($id);

            $types = [
                'recipe' => 'Receita',
                'expense' => 'Despesa',
                'investment' => 'Investimento',
            ];

            return view('categories.edit', compact('category', 'types'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Erro ao carregar categoria.');
        }
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $category = CategoryModel::where('organization_id', $orgId)->findOrFail($id);

            $data = $request->validated();
            $category->update($data);
            return redirect()->route('categories.index')->with('success','Categoria atualizada.');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error','Não foi possível atualizar categoria.');
        }
    }

    public function destroy($id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $category = CategoryModel::where('organization_id', $orgId)->findOrFail($id);

            // Defensive: only check relations if the FK column exists in the child table.
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
            return redirect()->route('categories.index')->with('success','Categoria removida.');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Erro ao remover categoria.');
        }
    }
}
