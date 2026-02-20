<?php

namespace App\Modules\Category\Infrastructure\Persistence\Eloquent;

use App\Modules\Category\Domain\Contracts\CategoryRepositoryInterface;
use App\Modules\Category\Domain\Entities\Category as CategoryEntity;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function findById(int $id): ?CategoryEntity
    {
        $model = CategoryModel::find($id);
        if (!$model) {
            return null;
        }
        return $this->toEntity($model);
    }

    public function listByOrganization(int $organizationId): array
    {
        $models = CategoryModel::where('organization_id', $organizationId)
            ->orderBy('name')
            ->get();
        return $models->map(fn($m) => $this->toEntity($m))->all();
    }

    public function save(CategoryEntity $category): CategoryEntity
    {
        $model = CategoryModel::updateOrCreate(
            ['id' => $category->id()],
            [
                'name' => $category->name(),
                'type' => $category->type(),
                'organization_id' => $category->organizationId(),
            ]
        );
        return $this->toEntity($model);
    }

    public function delete(CategoryEntity $category): void
    {
        CategoryModel::destroy($category->id());
    }

    private function toEntity(CategoryModel $model): CategoryEntity
    {
        return new CategoryEntity(
            $model->id,
            $model->name,
            $model->type,
            $model->organization_id
        );
    }
}
