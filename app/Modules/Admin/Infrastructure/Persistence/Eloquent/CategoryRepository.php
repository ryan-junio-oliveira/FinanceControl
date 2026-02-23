<?php

namespace App\Modules\Admin\Infrastructure\Persistence\Eloquent;

use App\Modules\Admin\Domain\Contracts\CategoryRepositoryInterface;
use App\Modules\Admin\Domain\Entities\Category as CategoryEntity;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all(?int $organizationId = null): array
    {
        $query = \App\Modules\Admin\Infrastructure\Persistence\Eloquent\CategoryModel::query();
        if ($organizationId !== null) {
            $query->where('organization_id', $organizationId);
        }
        $models = $query->orderBy('name')->get();
        return $models->map(fn($m) => $this->toEntity($m))->all();
    }

    public function findById(int $id): ?CategoryEntity
    {
        $model = \App\Modules\Admin\Infrastructure\Persistence\Eloquent\CategoryModel::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function save(CategoryEntity $category): CategoryEntity
    {
        $attributes = [
            'name' => $category->name(),
            'type' => $category->type(),
            'organization_id' => $category->organizationId(),
        ];
        $model = \App\Modules\Admin\Infrastructure\Persistence\Eloquent\CategoryModel::updateOrCreate(
            ['id' => $category->id()],
            $attributes
        );
        return $this->toEntity($model);
    }

    public function delete(CategoryEntity $category): void
    {
        \App\Modules\Admin\Infrastructure\Persistence\Eloquent\CategoryModel::destroy($category->id());
    }

    private function toEntity(\App\Modules\Admin\Infrastructure\Persistence\Eloquent\CategoryModel $m): CategoryEntity
    {
        return new CategoryEntity(
            $m->id,
            $m->name,
            $m->type,
            (int)$m->organization_id
        );
    }
}
