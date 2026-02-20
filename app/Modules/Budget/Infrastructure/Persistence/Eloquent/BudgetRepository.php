<?php

namespace App\Modules\Budget\Infrastructure\Persistence\Eloquent;

use App\Modules\Budget\Domain\Contracts\BudgetRepositoryInterface;
use App\Modules\Budget\Domain\Entities\Budget as BudgetEntity;
use DateTime;

class BudgetRepository implements BudgetRepositoryInterface
{
    public function findById(int $id): ?BudgetEntity
    {
        $model = BudgetModel::find($id);
        if (!$model) {
            return null;
        }

        return $this->toEntity($model);
    }

    public function listByOrganization(int $organizationId): array
    {
        $models = BudgetModel::where('organization_id', $organizationId)
            ->orderByDesc('created_at')
            ->get();

        return $models->map(fn($m) => $this->toEntity($m))->all();
    }

    public function save(BudgetEntity $budget): BudgetEntity
    {
        $attributes = [
            'name' => $budget->name(),
            'amount' => $budget->amount(),
            'start_date' => $budget->startDate()->format('Y-m-d'),
            'end_date' => $budget->endDate()->format('Y-m-d'),
            'category_id' => $budget->categoryId(),
            'is_active' => $budget->isActive(),
            'organization_id' => $budget->organizationId(),
        ];

        $model = BudgetModel::updateOrCreate(
            ['id' => $budget->id()],
            $attributes
        );

        return $this->toEntity($model);
    }

    public function delete(BudgetEntity $budget): void
    {
        BudgetModel::destroy($budget->id());
    }

    /**
     * Compute total spent for a given budget by querying expenses.
     */
    public function calculateSpent(BudgetEntity $budget): float
    {
        $q = \App\Modules\Expense\Infrastructure\Persistence\Eloquent\ExpenseModel::where('organization_id', $budget->organizationId())
            ->whereBetween('transaction_date', [
                $budget->startDate()->format('Y-m-d'),
                $budget->endDate()->format('Y-m-d'),
            ]);

        if ($budget->categoryId()) {
            $q->where('category_id', $budget->categoryId());
        }

        return (float) $q->sum('amount');
    }

    private function toEntity(BudgetModel $model): BudgetEntity
    {
        return new BudgetEntity(
            $model->id,
            $model->name,
            (float) $model->amount,
            new DateTime($model->start_date),
            new DateTime($model->end_date),
            $model->category_id,
            (bool) $model->is_active,
            $model->organization_id
        );
    }
}
