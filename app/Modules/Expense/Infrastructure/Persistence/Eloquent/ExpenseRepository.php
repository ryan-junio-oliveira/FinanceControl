<?php

namespace App\Modules\Expense\Infrastructure\Persistence\Eloquent;

use App\Modules\Expense\Domain\Contracts\ExpenseRepositoryInterface;
use App\Modules\Expense\Domain\Entities\Expense as ExpenseEntity;
use DateTime;

class ExpenseRepository implements ExpenseRepositoryInterface
{
    public function findById(int $id): ?ExpenseEntity
    {
        $model = ExpenseModel::find($id);
        if (!$model) {
            return null;
        }

        return $this->toEntity($model);
    }

    public function listByOrganization(int $organizationId): array
    {
        $models = ExpenseModel::where('organization_id', $organizationId)
            ->orderByDesc('created_at')
            ->get();

        return $models->map(fn($m) => $this->toEntity($m))->all();
    }

    public function save(ExpenseEntity $expense): ExpenseEntity
    {
        $attributes = [
            'amount' => $expense->amount(),
            'transaction_date' => $expense->transactionDate()->format('Y-m-d'),
            'category_id' => $expense->categoryId(),
            'organization_id' => $expense->organizationId(),
        ];

        $model = ExpenseModel::updateOrCreate(
            ['id' => $expense->id()],
            $attributes
        );

        return $this->toEntity($model);
    }

    public function delete(ExpenseEntity $expense): void
    {
        ExpenseModel::destroy($expense->id());
    }

    private function toEntity(ExpenseModel $model): ExpenseEntity
    {
        return new ExpenseEntity(
            $model->id,
            (float) $model->amount,
            new DateTime($model->transaction_date),
            $model->category_id,
            $model->organization_id
        );
    }
}
