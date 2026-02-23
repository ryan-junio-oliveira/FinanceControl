<?php

namespace App\Modules\Admin\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Modules\Organization\Infrastructure\Persistence\Eloquent\OrganizationModel;
use App\Modules\Admin\Application\Contracts\ListCategoriesInterface;
use App\Modules\Admin\Application\Contracts\ManageCategoryInterface;
use App\Modules\Admin\Domain\Contracts\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    private ListCategoriesInterface $listUseCase;
    private ManageCategoryInterface $manageUseCase;
    private CategoryRepositoryInterface $categoryRepo;

    public function __construct(ListCategoriesInterface $listUseCase, ManageCategoryInterface $manageUseCase, CategoryRepositoryInterface $categoryRepo)
    {
        $this->listUseCase = $listUseCase;
        $this->manageUseCase = $manageUseCase;
        $this->categoryRepo = $categoryRepo;
    }

    public function index(Request $request)
    {
        $q = $request->query('q');
        $type = $request->query('type');
        $org = $request->query('org');
        $perPage = (int) $request->query('per_page', 20);
        $perPage = in_array($perPage, [10,20,50,100]) ? $perPage : 20;

        $all = $this->listUseCase->execute($org ? (int)$org : null);
        $categories = collect($all);
        if ($q) {
            $categories = $categories->filter(fn($c) => str_contains(strtolower($c->name), strtolower($q)));
        }
        if ($type) {
            $categories = $categories->filter(fn($c) => $c->type === $type);
        }
        $categories = $categories->sortBy('name')->forPage(request('page',1), $perPage);
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $categories->values(),
            count($all),
            $perPage,
            request('page',1),
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $organizations = OrganizationModel::orderBy('name')->get();
        return view('admin.categories.index', ['categories'=>$paginated, 'organizations'=>$organizations]);
    }

    public function create()
    {
        $types = [
            'recipe' => 'Receita',
            'expense' => 'Despesa',
            'investment' => 'Investimento',
        ];
        $organizations = OrganizationModel::orderBy('name')->get();
        return view('admin.categories.create', compact('types', 'organizations'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:recipe,expense,investment',
            'organization_id' => 'required|exists:organizations,id',
        ]);

        try {
            $this->manageUseCase->create($data['name'], $data['type'], (int)$data['organization_id']);
            return redirect()->route('admin.categories.index')->with('success', 'Categoria criada com sucesso.');
        } catch (\Throwable $e) {
            Log::error($e);
            return back()->withInput()->with('error', 'Não foi possível criar categoria.');
        }
    }

    public function edit(int $id)
    {
        try {
            $category = $this->categoryRepo->findById($id);
            if (! $category) {
                throw new \Exception('not found');
            }
            $types = [
                'recipe' => 'Receita',
                'expense' => 'Despesa',
                'investment' => 'Investimento',
            ];
            $organizations = OrganizationModel::orderBy('name')->get();
            return view('admin.categories.edit', compact('category', 'types', 'organizations'));
        } catch (\Throwable $e) {
            Log::error($e);
            return back()->with('error', 'Categoria não encontrada.');
        }
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:recipe,expense,investment',
            'organization_id' => 'required|exists:organizations,id',
        ]);

        try {
            $this->manageUseCase->update($id, $data['name'], $data['type'], (int)$data['organization_id']);
            return redirect()->route('admin.categories.index')->with('success', 'Categoria atualizada.');
        } catch (\Throwable $e) {
            Log::error($e);
            return back()->withInput()->with('error', 'Não foi possível atualizar categoria.');
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->manageUseCase->delete($id);
            return redirect()->route('admin.categories.index')->with('success', 'Categoria removida.');
        } catch (\Throwable $e) {
            Log::error($e);
            return back()->with('error', 'Não foi possível remover categoria.');
        }
    }
}
