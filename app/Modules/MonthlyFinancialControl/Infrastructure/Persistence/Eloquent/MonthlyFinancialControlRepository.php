<?php

namespace App\Modules\MonthlyFinancialControl\Infrastructure\Persistence\Eloquent;

use App\Modules\MonthlyFinancialControl\Domain\Contracts\MonthlyFinancialControlRepositoryInterface;
use App\Modules\MonthlyFinancialControl\Domain\Entities\MonthlyFinancialControl as MfcEntity;

class MonthlyFinancialControlRepository implements MonthlyFinancialControlRepositoryInterface
{
    public function findById(int $id): ?MfcEntity
    {
        $model = MonthlyFinancialControlModel::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function listByOrganization(int $organizationId): array
    {
        $models = MonthlyFinancialControlModel::where('organization_id', $organizationId)->get();
        return $models->map(fn($m) => $this->toEntity($m))->all();
    }

    public function save(MfcEntity $mfc): MfcEntity
    {
        $attributes = [
            'month' => $mfc->month(),
            'organization_id' => $mfc->organizationId(),
        ];
        $model = MonthlyFinancialControlModel::updateOrCreate(['id' => $mfc->id()], $attributes);
        return $this->toEntity($model);
    }

    public function delete(MfcEntity $mfc): void
    {
        MonthlyFinancialControlModel::destroy($mfc->id());
    }

    private function toEntity(MonthlyFinancialControlModel $model): MfcEntity
    {
        return new MfcEntity($model->id, $model->month, $model->organization_id);
    }
}
