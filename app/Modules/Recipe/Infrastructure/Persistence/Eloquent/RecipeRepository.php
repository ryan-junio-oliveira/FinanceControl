<?php

namespace App\Modules\Recipe\Infrastructure\Persistence\Eloquent;

use App\Modules\Recipe\Domain\Contracts\RecipeRepositoryInterface;
use App\Modules\Recipe\Domain\Entities\Recipe as RecipeEntity;
use DateTime;

class RecipeRepository implements RecipeRepositoryInterface
{
    public function findById(int $id): ?RecipeEntity
    {
        $model = RecipeModel::find($id);
        if (!$model) {
            return null;
        }
        return $this->toEntity($model);
    }

    public function listByOrganization(int $organizationId): array
    {
        $models = RecipeModel::where('organization_id', $organizationId)
            ->orderByDesc('created_at')
            ->get();
        return $models->map(fn($m) => $this->toEntity($m))->all();
    }

    public function save(RecipeEntity $recipe): RecipeEntity
    {
        $attributes = [
            'amount' => $recipe->amount(),
            'transaction_date' => $recipe->transactionDate()->format('Y-m-d'),
            'category_id' => $recipe->categoryId(),
            'organization_id' => $recipe->organizationId(),
        ];
        $model = RecipeModel::updateOrCreate(['id' => $recipe->id()], $attributes);
        return $this->toEntity($model);
    }

    public function delete(RecipeEntity $recipe): void
    {
        RecipeModel::destroy($recipe->id());
    }

    private function toEntity(RecipeModel $model): RecipeEntity
    {
        return new RecipeEntity(
            $model->id,
            (float) $model->amount,
            new DateTime($model->transaction_date),
            $model->category_id,
            $model->organization_id
        );
    }
}
