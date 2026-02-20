<?php

namespace App\Modules\Bank\Infrastructure\Persistence\Eloquent;

use App\Modules\Bank\Domain\Contracts\BankRepositoryInterface;
use App\Modules\Bank\Domain\Entities\Bank as BankEntity;

class BankRepository implements BankRepositoryInterface
{
    public function findById(int $id): ?BankEntity
    {
        $model = BankModel::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function listByOrganization(int $organizationId): array
    {
        $models = BankModel::where('organization_id', $organizationId)->get();
        return $models->map(fn($m) => $this->toEntity($m))->all();
    }

    public function save(BankEntity $bank): BankEntity
    {
        $attributes = ['name' => $bank->name(), 'organization_id' => $bank->organizationId()];
        $model = BankModel::updateOrCreate(['id' => $bank->id()], $attributes);
        return $this->toEntity($model);
    }

    public function delete(BankEntity $bank): void
    {
        BankModel::destroy($bank->id());
    }

    private function toEntity(BankModel $model): BankEntity
    {
        return new BankEntity($model->id, $model->name, $model->organization_id);
    }
}
