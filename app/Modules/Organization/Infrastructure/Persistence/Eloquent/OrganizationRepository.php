<?php

namespace App\Modules\Organization\Infrastructure\Persistence\Eloquent;

use App\Modules\Organization\Domain\Contracts\OrganizationRepositoryInterface;
use App\Modules\Organization\Domain\Entities\Organization as OrganizationEntity;

class OrganizationRepository implements OrganizationRepositoryInterface
{
    public function findById(int $id): ?OrganizationEntity
    {
        $model = OrganizationModel::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function listAll(): array
    {
        return OrganizationModel::orderBy('name')->get()->map(fn($m) => $this->toEntity($m))->all();
    }

    public function save(OrganizationEntity $org): OrganizationEntity
    {
        $model = OrganizationModel::updateOrCreate(
            ['id' => $org->id()],
            ['name' => $org->name(), 'archived' => $org->archived()]
        );
        return $this->toEntity($model);
    }

    public function delete(OrganizationEntity $org): void
    {
        OrganizationModel::destroy($org->id());
    }

    private function toEntity(OrganizationModel $model): OrganizationEntity
    {
        return new OrganizationEntity($model->id, $model->name, (bool)$model->archived);
    }
}
