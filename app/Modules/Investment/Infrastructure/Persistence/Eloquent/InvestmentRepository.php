<?php

namespace App\Modules\Investment\Infrastructure\Persistence\Eloquent;

use App\Modules\Investment\Domain\Contracts\InvestmentRepositoryInterface;
use App\Modules\Investment\Domain\Entities\Investment as InvestmentEntity;
use DateTime;

class InvestmentRepository implements InvestmentRepositoryInterface
{
    public function findById(int $id): ?InvestmentEntity
    {
        $model = InvestmentModel::find($id);
        if (! $model) {
            return null;
        }

        return $this->toEntity($model);
    }

    public function listByOrganization(int $organizationId): array
    {
        $models = InvestmentModel::where('organization_id', $organizationId)
            ->orderByDesc('created_at')
            ->get();

        return $models->map(fn($m) => $this->toEntity($m))->all();
    }

    public function save(InvestmentEntity $investment): InvestmentEntity
    {
        $attributes = [
            'name' => $investment->name(),
            'amount' => $investment->amount(),
            'transaction_date' => $investment->transactionDate()->format('Y-m-d'),
            'fixed' => $investment->fixed(),
            'organization_id' => $investment->organizationId(),
        ];

        $model = InvestmentModel::updateOrCreate(
            ['id' => $investment->id()],
            $attributes
        );

        return $this->toEntity($model);
    }

    public function delete(InvestmentEntity $investment): void
    {
        InvestmentModel::destroy($investment->id());
    }

    private function toEntity(InvestmentModel $model): InvestmentEntity
    {
        return new InvestmentEntity(
            $model->id,
            $model->name,
            (float) $model->amount,
            new DateTime($model->transaction_date),
            (bool) $model->fixed,
            $model->organization_id
        );
    }
}
